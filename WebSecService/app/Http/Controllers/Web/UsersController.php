<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\UsersController;
use App\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Web\Artisan;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Carbon\Carbon;


class UsersController extends Controller {
    use ValidatesRequests;


    public function register(Request $request) {
        return view('users.register');
        }

    public function doRegister(Request $request) {
        

        // if($request->password!=$request->password_confirmation)
        //     return redirect()->route('register', ['error'=>'Confirm password not matched.']);

        // if(!$request->email || !$request->name || !$request->password)
        //     return redirect()->route('register', ['error'=>'Missing registration info.']);

        // if(User::where('email', $request->email)->first()) //Not Secure
        //     return redirect()->route('register', ['error'=>'User name already exist.']);

        $this->validate($request, [
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed',
            Password::min(8)->numbers()->letters()->mixedCase()->symbols()]
        ]);


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);  
        $user->save();


        $title = "Verification Link";
        $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
        $link = route("verify", ['token' => $token]);
        Mail::to($user->email)->send(new VerificationEmail($link, $user->name));

        return redirect("/");
    }

    public function verify(Request $request) {
        $decryptedData = json_decode(Crypt::decryptString($request->token), true);
        $user = User::find($decryptedData['id']);
        if(!$user) abort(401);
        $user->email_verified_at = Carbon::now();
        $user->save();
        
        return view('users.verified', compact('user'));
    }

    public function login(Request $request) {
    return view('users.login');
    }

    public function doLogin(Request $request) {

        $user = User::where('email', $request->email)->first();

        if(!$user->email_verified_at)
            return redirect()->back()->withInput($request->input())
                ->withErrors('Your email is not verified.');

        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');
            $user = User::where('email', $request->email)->first();
            Auth::setUser($user);
        
    return redirect('/');
    }

    public function doLogout(Request $request) {

        Auth::logout();

    return redirect('/');
    }

    public function profile(Request $request, User $user = null) {
        $user = $user ?? auth()->user();
    
        // Authorization Check
        if (auth()->id() !== $user?->id && !auth()->user()->hasPermissionTo('show_users')) {
            abort(401);
        }
    
        // Fetch Direct Permissions
        $directPermissions = $user->getDirectPermissions();
    
        // Fetch Role-Based Permissions
        $rolePermissions = $user->getPermissionsViaRoles();
    
        // Combine and Remove Duplicates
        $permissions = $directPermissions->merge($rolePermissions)->unique('id');
    
        return view('users.profile', compact('user', 'permissions'));
    }
    
            
        
           

    public function index(Request $request)
    {
        $query = User::query();

        // Apply filters if provided
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users_index')->with('success', 'User created successfully.');
    }

    public function edit(Request $request, User $user = null) {
   
        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }
        
        $roles = [];
        foreach
        (Role::all() as $role) {
               $role->taken = ($user->hasRole($role->name));
               $roles[] = $role;
           }

           $permissions = [];
           $directPermissionsIds = $user->getDirectPermissions()->pluck('id')->toArray();           foreach(Permission::all() as $permission) {
               $permission->taken = in_array($permission->id, $directPermissionsIds);
               $permissions[] = $permission;
           }
        //    $permissions = Permission::all(); // Fetch all permissions
        return view('users.edit', compact('user', 'roles', 'permissions'));
     }

     public function save(Request $request, User $user) {
        if (auth()->user()->hasPermissionTo('edit_users')) {
            $user->syncRoles($request->roles);
            
            // Fetch the permission names for the given IDs
            $permissionNames = Permission::whereIn('id', $request->permissions)
                ->pluck('name')->toArray();
                
            $user->syncPermissions($permissionNames);
        }
    
        return redirect(route('profile', ['user' => $user]));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('users_index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users_index')->with('success', 'User deleted successfully.');
    }
    
}
    
    
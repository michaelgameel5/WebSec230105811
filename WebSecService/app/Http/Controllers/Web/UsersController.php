<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;

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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\DB;





class UsersController extends Controller {
    use ValidatesRequests;


    public function register(Request $request) {
        return view('users.register');
        }

    
        
        public function DoRegister(Request $request)
        {
            // Validate user input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);
        
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        
            // Assign the "Customer" role
            $role = Role::where('name', 'Customer')->first();
            if ($role) {
                $user->assignRole('Customer'); // Using Spatie Permission package
            }
        
            return redirect()->route('login')->with('success', 'Registration successful! You are now assigned the Customer role.');
        }
        
        

    public function login(Request $request) {
    return view('users.login');
    }

    public function doLogin(Request $request) {

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
    
        $purchasedProducts = $user->purchases()->get();

    
        return view('users.profile', compact('user', 'permissions', 'purchasedProducts'));
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
    



    public function listCustomers() {
        // Get the "Customer" role ID dynamically using raw query
        $customerRoleId = DB::table('roles')->where('name', 'Customer')->value('id');

        if (!$customerRoleId) {
            return redirect()->back()->with('error', 'Customer role not found.');
        }

        // Fetch users associated with the Customer role using raw query
        $customers = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', $customerRoleId)
            ->select('users.*') // Select all user fields
            ->get();

        return view('users.customers', compact('customers'));
    }

    public function addCredit(Request $request, User $customer) {
        // Get the Employee role ID dynamically
        $employeeRoleId = DB::table('roles')->where('name', 'Employee')->value('id');
    
        // Check if the authenticated user is an employee
        $isEmployee = DB::table('model_has_roles')
            ->where('model_id', auth()->id())
            ->where('role_id', $employeeRoleId)
            ->exists();
    
        if (!$isEmployee) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    
        // Debugging - Check if data exists before updating
        // dd([
        //     'customer_id' => $customer->id,
        //     'credit' => $request->credit,
        //     'authenticated_user' => auth()->id(),
        //     'current_credit' => $customer->credit,
        // ]);
    
        $request->validate([
            'credit' => 'required|numeric|min:1'
        ]);
    
        // Try updating the credit
        $updated = DB::table('users')
            ->where('id', $customer->id)
            ->increment('credit', $request->credit);
    
        if ($updated) {
            return redirect()->back()->with('success', 'Credit added successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update credit.');
        }
    }
    
}
    
    
<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;


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

        return redirect("/");
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
}
    
    
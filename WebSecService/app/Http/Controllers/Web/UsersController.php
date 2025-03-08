<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Models\User;


class UsersController extends Controller {
    public function register(Request $request) {
        return view('users.register');
        }
        public function doRegister(Request $request) {

            if($request->password!=$request->password_confirmation)
                return redirect()->route('register', ['error'=>'Confirm password not matched.']);

            if(!$request->email || !$request->name || !$request->password)
                return redirect()->route('register', ['error'=>'Missing registration info.']);

            if(User::where('email', $request->email)->first()) //Not Secure
                return redirect()->route('register', ['error'=>'User name already exist.']);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password; //Not Secure
            $user->save();
            return redirect("/");
        }
        public function login(Request $request) {
        return view('users.login');
        }
        public function doLogin(Request $request) {
        return redirect('/');
        }
        public function doLogout(Request $request) {
        return redirect('/');
        }
    }
    
    
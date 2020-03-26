<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        return view('auth.login');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }


    public function login(ValidateLoginRequest $request){
        if (Auth::attempt(['user'=>$request->user,'password'=>$request->password,'role' => $request->role,'access' => true])) {
            return response()->json(["message"=>"Bienvenido(a) ".Auth::user()->full_name,"type" => "success","redirect"=>route('home')]);
        }else{
        	return response()->json(["message"=> "Error con el user, clave y/o rol",'type' => "error"]);
        }
    }
}

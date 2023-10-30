<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
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

    /**
     * Override the login method (AuthenticatesUsers trait)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
       // Extract the data from the incoming request 
       $requestedData = $request->all();

       //Validate the email and password
       $credential = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
       ]);
       // Attempt to authenticate a user using the given credentials.
       if(Auth::attempt($credential)){
       
            //If user is admin then redirect to admin home
            if(Auth::user()->role == 'admin'){
                return redirect()->route('admin.home');
            }

             //If current user is user then redirect to user home
            if(Auth::user()->role == 'user'){
                return redirect()->route('home');
            }

       }else{
         //If details are invalid
            return redirect()->route('login')
        ->with('error','Email-Address And Password Are Wrong.');
       }
        
    }
  
}

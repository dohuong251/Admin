<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function getLogin()
    {
//        return view('auth.login');

        if(Auth::guard('web') ->check()){
            return redirect()->route('admin.home');
        }
        else {
            return view('auth.login');
        }

    }

    public function postLogin(Request $request)
    {
        $validateRules = [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ];
        $validateMess = [
            'required' => 'Vui lòng điền :attribute',
            'string' => ':attribute phải là chuỗi kí tự',
            'email' => 'Email không đúng định dạng'
        ];
        $validator = Validator::make($request->all(), $validateRules, $validateMess);

        if ($validator->failed()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user_data = array(
                'email' => $request->get('email'),
                'password' => $request->get('password'),

            );

            if (Auth::guard('web')->attempt($user_data)) {

                return redirect()->route('admin.home');

            } else {
                $errors = new MessageBag(['errorlogin' => 'Email hoặc mật khẩu không đúng']);
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logOut(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

}

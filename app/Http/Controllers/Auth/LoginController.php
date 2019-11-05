<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\model;
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
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.home');
        } else {
            return view('auth.login');
        }

    }

    public function postLogin(Request $request)
    {
        $validateRules = [
            'username' => 'required|string',
            'password' => 'required|string'
        ];
        $validateMess = [
            'required' => 'Vui lòng điền :attribute',
            'string' => ':attribute phải là chuỗi kí tự'
        ];
        $validator = Validator::make($request->all(), $validateRules, $validateMess);

        if ($validator->failed()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user_data = array(
                'username' => $request->get('username'),
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

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
        return null;
    }

    /**
     * @return model sẽ thực hiện xóa hàng loạt trong hàm delete
     */
    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
        return null;
    }
}

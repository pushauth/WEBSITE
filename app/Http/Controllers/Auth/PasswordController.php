<?php

namespace PushAuth\Http\Controllers\Auth;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use PushAuth\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use PushAuth\User;


class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectPath = '/';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getEmail()
    {
        return view('dashboard.auth.password');
    }

    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('dashboard.auth.reset')->with('token', $token);
    }

    public function postEmail(Request $request)
    {
     //   dd('stop');
        $this->validate($request, ['email' => 'required|email']);

        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->status == 'disable') {
            return redirect()
                ->back()
                ->withErrors([
                    'email' => 'This account has been disabled. Please contact to support@pushauth.io',
                ]);
        }




        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));
            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );



        $user = User::where('email', $credentials['email'])->firstOrFail();

        if ($user->status == 'disable') {
            return redirect()
                ->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'This account has been disabled. Please contact to support@pushauth.io',
                ]);
        }



        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });


        $user->update([
            'confirmed'=>'true'
        ]);


        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect($this->redirectPath())->with('status', trans($response));
            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }




}

<?php

namespace PushAuth\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Mail;
use PushAuth\User;
use PushAuth\UserConfirm;
use Session;
use Validator;
use PushAuth\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;

use Auth;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $loginPath = '/login';

    //protected $redirectPath = '/';

    protected $redirectAfterLogout = '/';

    protected $redirectPath = '/';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }



    public function getLogin()
    {

        return view('dashboard.auth.login');
    }

    public function getRegister()
    {
        return view('dashboard.auth.register');
    }

    public function postRegister(Request $request)
    {


        //$validator = $this->validator($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')->withErrors($validator)->withInput();
        }

//dd('2');


        $UData = $request->all();

        $mailStr = explode('@', $UData['email']);
        $name = $mailStr['0'].date('HisdmY');



        //Throttle one hour
        if (UserConfirm::where('created_at', '>=', Carbon::now()->subMinutes(60)->toDateTimeString())
                        ->where('email', $UData['email'])
                        ->where('status', 'false')
                        ->count() > 0) {

            $request->session()->flash('alert-warning', 'We already sent confirmation email to you. You can repeat register to this email later.');

            //return back()->withErrors($validator)->withInput();
            return back()->withErrors($validator)->withInput();;

        }



        $userConfirm = UserConfirm::create([
            'email'=>$UData['email'],
            'pass'=>bcrypt($UData['password']),
            'name'=>$name,
            //'status',
            'urlhash'=>str_random(32),
            //'confirm_dt',
        ]);

        $dataMail = [
            'url'=>url('/register/confirm',$userConfirm->urlhash)
        ];

        Mail::queue(['text' => 'emails.confirmation.user'], $dataMail, function ($message) use ($UData) {
            $message->from(env('MAIL_ADDRESS'), 'PushAuth');
            $message->subject('PushAuth Confirmation User');
            $message->to($UData['email']);
        });


        return view('dashboard.auth.confirm');


        //Auth::login($this->create($request->all()));

        //return redirect($this->redirectPath());

    }

    public function postConfirm($hash)
    {


        $userConfirm = UserConfirm::where('urlhash', $hash)->where('status', 'false')->firstOrFail();

        $userConfirm->update([
            'status'=>'true',
            'confirm_dt'=>Carbon::now()
        ]);



        Auth::login($this->create([
            'email'=>$userConfirm->email,
            'password'=>$userConfirm->pass,
            'name'=>$userConfirm->name
        ]));

        $user = Auth::user();
        $user->profile()->create([]);
        $user->role()->create([]);
        $user->plan()->create(['plan_id'=>'1']);
        $user->msgLogLast()->create([]);

        $user->notifications()->create([
'subject'=>'We are happy to see you!',
'body'=>view('dashboard.notifys.firstlogin')->render(),
'urlhash'=>str_random(32)
        ]);


        $dataMail=[

        ];

        Mail::queue(['text' => 'emails.congratulation.userRegister'], $dataMail, function ($message) use ($userConfirm) {
            $message->from(env('MAIL_ADDRESS'), 'PushAuth');
            $message->subject('PushAuth - Thank you for registering!');
            $message->to($userConfirm['email']);
        });

//startTour();
        Session::put('showTour', 'true');

        return redirect($this->redirectPath());
        /*
         * TODO
         * find confirm record
         *
         * if confirm record in device?
         *
         * Auth::login($user);
         * return redirect($this->redirectPath());
         */
    }

    public function postLogin(Request $request)
    {

        //dd($request->email);







        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator)->withInput();
        }


        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        //dd('0');
        $credentials = $this->getCredentials($request);

        //dd();

        $user = User::where('email', $credentials['email'])->firstOrFail();

        if ($user->status == 'disable') {
            return redirect($this->loginPath())
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([
                    $this->loginUsername() => 'This account has been disabled. Please contact to support@pushauth.io',
                ]);
        }

        if ($user->confirmed == 'false') {
            //TODO user first



            $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject('Confirm first LogIn to PushAuth');
            });

/*            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return redirect()->back()->with('status', trans($response));
                case Password::INVALID_USER:
                    return redirect()->back()->withErrors(['email' => trans($response)]);
            }*/



            $data = [
                'title'=>'Welcome to PushAuth!',
                'message'=>'It is your first login in PushAuth. Please check your email and confirm.'
            ];
            return view('dashboard.info_pages.index')->with($data);

        }



        if (Auth::attempt($credentials, $request->has('remember'))) {

            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }



        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

       $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' =>$data['password'],
            'confirmed'=>'true'
        ]);

        return $user;
    }
}

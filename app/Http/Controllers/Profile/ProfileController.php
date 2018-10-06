<?php

namespace PushAuth\Http\Controllers\Profile;

use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Mail;
use PushAuth\Files;
use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use Auth;
use PushAuth\PricePlan;
use PushAuth\PushRequest;
use PushAuth\PushRoutes;
use PushAuth\TicketThread;
use PushAuth\User;
use PushAuth\UserEmailConfirmation;
use PushAuth\UserNotification;
use PushAuth\UserProfile;
use PushAuth\UserStripe;
use PushAuth\UserStripeCards;
use Session;
use Storage;
use Stripe\Customer;
use Stripe\Error\Card;
use Stripe\Error\InvalidRequest;
use Stripe\Stripe;
use Stripe\Subscription;
use Validator;
use Image;
use Carbon\Carbon;

use SEO;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        SEO::setTitle('Profile');
        return view('dashboard.profile.index');
    }



public function showSecurity() {
    SEO::setTitle('Security');
    return view('dashboard.profile.security');
}







    public function updateCancel() {

        $user=Auth::user();

        $user->plan()->update([
            'plan_id' => '1',
        ]);



        Stripe::setApiKey(env('STRIPE_SECRET'));
        $subscription = Subscription::retrieve($user->stripe->subscription_id);
        $subscription->cancel();

        $user->stripe->update([
            'subscription_id'    => Null,
            'plan_id'=>Null,
            'current_period_end' => Null,
            'error_status'=>'false'
        ]);


        //TODO mail that plan free
        $dataMail = [
            'billing_url'  => route('profile.billing'),
            'request_url' => route('support.ticket.create'),
        ];

        Mail::queue(['text' => 'emails.billing.subscriptionCancel'], $dataMail, function ($message) use ($user) {
            $message->from(env('MAIL_ADDRESS'), 'PushAuth');
            $message->subject('PushAuth Changed to FREE plan');
            $message->to($user->email);
        });
        Session::flash('alert-success', 'Subscription canceled');

        return redirect()->route('profile.billing');
    }


    public function updateCharge() {

        $user=Auth::user();


        Stripe::setApiKey(env('STRIPE_SECRET'));

        if ($user->stripe->subscription_id == false) {

            try {
                $subscription=Subscription::create(array(
                    "customer" => $user->stripe->customer_id,
                    "plan" => "2"
                ));
            }

        catch (InvalidRequest $e) {
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $error = $err['message'];


                Session::flash('alert-warning', $error);
                return redirect()->route('profile.billing');
            }
        catch(Card $e) {

                // Use the variable $error to save any errors
                // To be displayed to the customer later in the page
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $error = $err['message'];


                Session::flash('alert-warning', $error);
                return redirect()->route('profile.billing');

            }

            $user->stripe()->update([
                'subscription_id'=>$subscription->id,
                'plan_id'=>'2',
                //'error_status'=>'false'
            ]);
        }




        Session::flash('alert-success', 'Subscription to premium plan success');

        return redirect()->route('profile.billing');
    }



public function showBilling() {

    return view('dashboard.profile.billing');
}


    public function updatePrice($id) {


        $plan = PricePlan::where('name', $id)->firstOrFail();



        $user = Auth::user();


        if ($id == 'FREE') {
            return redirect()->route('profile.billing.cancel');
        }
        if ($id == 'PREMIUM') {

            if ($user->stripeCards()->count() > 0) {
                return redirect()->route('profile.billing.charge');
            } elseif ($user->stripeCards()->count() == 0) {
                return redirect()->route('profile.billing');
            }


        }


        Session::flash('alert-success', 'The price plan was changed.');

        return redirect()->route('profile.price');



    }
    public function destroyCard($hash) {

        $user=Auth::user();


        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $customer = Customer::retrieve($user->stripe->customer_id);
            $customer->sources->retrieve($user->stripeCards()->where('hash', $hash)->first()->card_id)->delete();
        }
        catch (InvalidRequest $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $error = $err['message'];
            //dd($body);

            Session::flash('alert-warning', $error);
            return redirect()->route('profile.billing');
        }
        catch(Card $e) {

            // Use the variable $error to save any errors
            // To be displayed to the customer later in the page
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $error = $err['message'];



            Session::flash('alert-warning', $error);
            return redirect()->route('profile.billing');

        }

        $customer = Customer::retrieve($user->stripe->customer_id);
        $defCard=$customer->default_source;

        //dd($defCard);

/*        $cards=$customer->sources->all(array("object" => "card"));
        $cards->__toArray(true);
        foreach ($cards['data'] as $card) {
            if ($user->stripeCards()->where('card_id',$card['id'])->exists() == false) {

            }
        }*/




        $user->stripeCards()->where('hash',$hash)->delete();

        $user->stripeCards()->update([
            'default'=>'false'
        ]);
        $user->stripeCards()->where('card_id',$defCard)->update([
            'default'=>'true'
        ]);


        Session::flash('alert-success', 'The credit card has been deleted.');

        return redirect()->route('profile.billing');

    }

    public function storeBilling(Request $request) {

        $user = Auth::user();


        //dd($request->all());
        Stripe::setApiKey(env('STRIPE_SECRET'));

        if ($user->stripe == false){
            $customer = Customer::create(array(
                "email" => $user->email,
            ));
            UserStripe::create([
                'user_id'=>$user->id,
                'customer_id'=>$customer->id,
                //'error_flag'=>
            ]);
            $customerID=$customer->id;
        } else {
            $customerID=$user->stripe->customer_id;
        }



        try {
            $cu = Customer::retrieve($customerID); // stored in your application
            $cu->sources->create(array("source" => $request->stripeToken));

            //$cu->subscriptions->


            $success = "Your credit card have been added!";
        }
        catch (InvalidRequest $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $error = $err['message'];


            Session::flash('alert-warning', $error);
            return redirect()->route('profile.billing');
        }
        catch(Card $e) {

            // Use the variable $error to save any errors
            // To be displayed to the customer later in the page
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $error = $err['message'];


            Session::flash('alert-warning', $error);
            return redirect()->route('profile.billing');

        }

        $cards=$cu->sources->all(array("object" => "card"));

        $cards->__toArray(true);

        if($user->stripeCards) {
            $user->stripeCards()->delete();
        }
        $defCard=$cu->default_source;



        //dd($cards['data']);
        foreach ($cards['data'] as $card) {

            ($defCard == $card['id']) ? $def='true' : $def='false';

        $user->stripeCards()->create([
            'card_id'=>$card['id'],
            'last4'=>$card['last4'],
            'exp_month'=>$card['exp_month'],
            'exp_year'=>$card['exp_year'],
            'brand'=>$card['brand'],
            'hash'=>str_random(32),
            'attempt_dt'=>Carbon::now(),
            'default'=>$def
        ]);


        }



        Session::flash('alert-success', 'Your credit card have been added!');

        return redirect()->route('profile.billing');


    }

    public function showPrice() {

        $plan_free = PricePlan::find(1);
        $plan_premium = PricePlan::find(2);

        $limits_free = $plan_free->limits;
        $limits_premium = $plan_premium->limits;

        $data = [
            'free'=>[
                'name'=>$plan_free->name,
                'pushes_day'=>$limits_free->where('key', 'pushes')->where('period', 'day')->first()->value,
                'pushes_month'=>$limits_free->where('key', 'pushes')->where('period', 'month')->first()->value,
                'logs_period'=>$limits_free->where('key', 'logs')->first()->period,
                'apps'=>$limits_free->where('key', 'apps')->first()->value,
                'users'=>$limits_free->where('key', 'users')->first()->value,
                'devices'=>$limits_free->where('key', 'devices')->first()->value,
                'routes'=>$limits_free->where('key', 'routes')->first()->value,
                'webhooks'=>$limits_free->where('key', 'webhooks')->first()->value
            ],
            'premium'=>[
                'name'=>$plan_premium->name,
                'pushes_day'=>$limits_premium->where('key', 'pushes')->where('period', 'day')->first()->value,
                'pushes_month'=>$limits_premium->where('key', 'pushes')->where('period', 'month')->first()->value,
                'logs_period'=>$limits_premium->where('key', 'logs')->first()->period,
                'apps'=>$limits_premium->where('key', 'apps')->first()->value,
                'users'=>$limits_premium->where('key', 'users')->first()->value,
                'devices'=>$limits_premium->where('key', 'devices')->first()->value,
                'routes'=>$limits_premium->where('key', 'routes')->first()->value,
                'webhooks'=>$limits_premium->where('key', 'webhooks')->first()->value
            ]
        ];

        return view('dashboard.profile.price')->with($data);
    }


public function showNotify() {
    SEO::setTitle('Notifications');
    return view('dashboard.profile.notify');
}
    public function showNotifyItem($hash) {

        SEO::setTitle('Notification');
        $user = Auth::user();
if (UserNotification::where('user_id',$user->id)->where('urlhash', $hash)->exists()) {

    $notify = UserNotification::where('user_id',$user->id)->where('urlhash', $hash)->first();

    $notify->update([
        'is_read'=>'true',
        'read_dt'=>Carbon::now()
    ]);

    $data = [
        'notify'=>$notify
    ];
    return view('dashboard.profile.notifyItem')->with($data);
}
else {

}



    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function updateImage(Request $request)
    {
        $user = Auth::user();

        $file = $request->file('user_img');
        $validator = Validator::make(array('user_img' => $file), [
            'user_img' => 'mimes:jpeg,bmp,png|max:5120|required',
        ]);

        if ($validator->fails()) {

            $request->session()->flash('alert-warning', 'Validating error.');
            return back()->withErrors($validator)->withInput();

        } else {


            $newFileName = str_random(24);
            $extension = strtolower($file->getClientOriginalExtension());


            $storage = Storage::disk('users');
            if (!$storage->exists($user->id)) {
                $storage->makeDirectory($user->id);
            }


            if ($user->profile->user_img != null) {
               $storage->delete($user->id.'/'.$user->profile->user_img);
            }

            $img = Image::make($file);
            $img->fit(250, 250);

            $img->save(storage_path('/users/'.$user->id.'/'. $newFileName. '.' .$extension));

            $user->profile()->update(['user_img' => $newFileName. '.' .$extension]);

            Session::flash('alert-success', 'The profile was updated.');

            return redirect()->route('profile');


        }


    }



    public function showUserImage($hash) {

        $user = Auth::user();

        if (UserProfile::where('user_img', $hash)->exists()) {
            $client = UserProfile::where('user_img', $hash)->first();


            $imgPath = storage_path('users/' . $client->user_id . '/' . $hash);


        }
        else {


            $imgPath = public_path('/assets/images/default_avatar.png');
        }

        $img = Image::cache(function ($image) use ($imgPath) {
            //global $imgPath;
            $image->make($imgPath);
        }, 10, true);

        return $img->response();





    }


        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //


        $user = Auth::user();


        $validator = Validator::make([
            'name'=>$request->name,
            //'profile.first_name' => $request->profile['first_name'],
            //'profile.last_name' => $request->profile['last_name'],
            //'profile.email' => $request->profile['email'],
        ],
            [
                'name'=>'required'
                //'profile.full_name' => 'required|min:2|max:255',
                //'profile.email' => 'required|email|unique:users,email,' . Auth::user()->id,

            ]);


        /*$validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:24',
            'about'=>'required|min:8',
            'app_img'=>'mimes:jpeg,png|max:1024'
        ]);*/

        if ($validator->fails()) {

            $request->session()->flash('alert-warning', 'Validating error.');
            return back()->withErrors($validator)->withInput();

        } else {

            $user->update([
                'name'=>$request->name
            ]);

            $user->profile()->update([
                'first_name'=>$request->profile['first_name'],
                'last_name'=>$request->profile['last_name'],
                'company'=>$request->profile['company'],
                'tel'=>$request->profile['tel'],
                'website'=>$request->profile['website'],

            ]);

            Session::flash('alert-success', 'The profile was updated.');

            return redirect()->route('profile');

        }






        }


    public function updatePassword(Request $request)
    {
        //

        $user = Auth::user();

        Validator::extend('passcheck', function ($attribute, $value, $parameters) {
            return Hash::check($value, Auth::user()->getAuthPassword());
        });

        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
            'password_old' => 'required|passcheck|min:6',
        ],
            [
                'passcheck' => 'Your old password was incorrect',
            ]);

        if ($validator->fails()) {
            $request->session()->flash('alert-warning', 'Validating error.');
            return back()->withErrors($validator)->withInput();
        } else {


            $user->update(['password'=>bcrypt($request->password)]);


            $dataMail=[];

            Mail::queue(['text' => 'emails.information.password_changed'], $dataMail, function ($message) use ($user) {
                $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                $message->subject('PushAuth Password changed');
                $message->to($user->email);
            });



            Session::flash('alert-success', 'Your password has been changed!');

            return redirect()->route('profile.security');


        }




    }

    public function updateMailConfirm($hash)
    {

        if ($hash) {

            try {
                $confirm = UserEmailConfirmation::where('urlhash', $hash)
                    ->where('status', 'false')
                    ->firstOrFail();
            } catch (ModelNotFoundException $e) {
                //dd('4');
                return abort(404);
            }


            //CHECK ALREADY?

            if (User::where('email',$confirm->email)->exists()) {
                $data = [
                    'title'=>'Confirmation cancel',
                    'message'=>'User with this email already exists'
                ];
                return view('dashboard.info_pages.index')->with($data);
            }


            $confirm->update([
                'status'     => 'true',
                'confirm_dt' => Carbon::now()
            ]);


            $confirm->user->update([
                'email'=>$confirm->email
            ]);


            $dataMail=[];

            Mail::queue(['text' => 'emails.information.email_changed'], $dataMail, function ($message) use ($confirm) {
                $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                $message->subject('PushAuth Email changed');
                $message->to($confirm->email);
            });


            $data = [
                'title'=>'Successfull changed.',
                'message'=>'Your email changed. You can SignIn with new email.'
            ];
            return view('dashboard.info_pages.index')->with($data);

        }
        else {
            return abort(404);
        }

        }

    public function updateMail(Request $request)
    {
        //

        $user = Auth::user();

        //$file = $request->file('user_img');
        $validator = Validator::make([
            'email'=>$request->email
        ], [
            'email'=>'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {

            $request->session()->flash('alert-warning', 'Validating error.');
            return back()->withErrors($validator)->withInput();

        } else {


            $confirm = UserEmailConfirmation::create([
                'user_id'=>$user->id,
                'email'=>$request->email,
                'urlhash'=>str_random(32),

            ]);
            $dataMail = [
                'url'=>route('confirmEmail', $confirm->urlhash)
            ];


            Mail::queue(['text' => 'emails.confirmation.emailChanged'], $dataMail, function ($message) use ($user) {
                $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                $message->subject('PushAuth Confirmation Email');
                $message->to($user->email);
            });

            Session::flash('alert-purple', 'Please, check your '. $user->email . ' for confirmation of change email.');

            return redirect()->route('profile.security');

        }




    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        $user = Auth::user();

        if ($user->stripe) {
            if ($user->stripe->subscription_id != Null) {
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $subscription = Subscription::retrieve($user->stripe->subscription_id);
                $subscription->cancel();
            }
            }

            $userDeviceArr=$user->devices()->lists('id')->toArray();
            $userAppArr=$user->app()->lists('id')->toArray();

        PushRoutes::whereIn('device_id', $userDeviceArr)->delete();
        PushRoutes::where('client_id',$user->id)->delete();

        PushRequest::whereIn('app_id',$userAppArr)->delete();
        PushRequest::whereIn('device_id',$userDeviceArr)->delete();

        TicketThread::where('author_id',$user->id)->delete();
        Files::where('user_id', $user->id)->delete();


        $user->profile()->delete();
        $user->devices()->delete();
        $user->tickets()->delete();


        $user->notifications()->delete();
        $user->app()->delete();
        $user->logins()->delete();
        $user->role()->delete();

        $user->stripe()->delete();
        $user->stripeCards()->delete();
        $user->stripeInvoice()->delete();
        $user->plan()->delete();
        $user->msgLogLast()->delete();



        $user->delete();




        return redirect()->route('dashboard');
    }
}

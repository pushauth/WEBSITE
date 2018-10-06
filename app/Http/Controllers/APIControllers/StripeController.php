<?php

namespace PushAuth\Http\Controllers\APIControllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Mail;
use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\UserStripe;
use PushAuth\UserStripeInvoice;
use Stripe\Customer;
use Stripe\Invoice;
use Stripe\Stripe;
use Stripe\Subscription;

class StripeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $json = $request->json()->all();
        Stripe::setApiKey(env('STRIPE_SECRET'));


        if (in_array($json['type'],['invoice.upcoming', 'invoice.created']))
         {

            \Log::info('Fired invoice.upcoming or invoice.created');


            $customerID = $json['data']['object']['customer'];
            $invoiceID = $json['data']['object']['id'];
            $currency = $json['data']['object']['currency'];
            $amount = $json['data']['object']['total'];
            $paid = $json['data']['object']['paid'];

            $period_start = $json['data']['object']['lines']['data'][0]['period']['start'];
            $period_end = $json['data']['object']['lines']['data'][0]['period']['end'];

             ($paid == true) ? $paid='true' : $paid='false';

             \Log::info('Paid? - '.$paid);


            \Log::info('data: '.print_r([
                    'user_id'=>'id',
                    'invoice_id'=>$invoiceID,
                    'currency'=>$currency,
                    'amount'=>$amount,
                    'paid'=>$paid,
                    'period_start'=>Carbon::createFromTimestampUTC($period_start)->toDateTimeString(),
                    'period_end'=>Carbon::createFromTimestampUTC($period_end)->toDateTimeString()
                ],true));
             $userStripe=UserStripe::where('customer_id', $customerID)->firstOrFail();


            if (UserStripeInvoice::where('invoice_id', $invoiceID)->exists() == false) {
                \Log::info('Paid-2 ? - '.$paid);
                UserStripeInvoice::create([
                    'user_id'=>$userStripe->user_id,
                    'invoice_id'=>$invoiceID,
                    'currency'=>$currency,
                    'amount'=>$amount,
                    'paid'=>$paid,
                    'period_start'=>Carbon::createFromTimestampUTC($period_start)->toDateTimeString(),
                    'period_end'=>Carbon::createFromTimestampUTC($period_end)->toDateTimeString()
                ]);
            }
            else {
                UserStripeInvoice::where('invoice_id', $invoiceID)->update([
                    'currency'=>$currency,
                    'amount'=>$amount,
                    'paid'=>$paid,
                    'period_start'=>Carbon::createFromTimestampUTC($period_start)->toDateTimeString(),
                    'period_end'=>Carbon::createFromTimestampUTC($period_end)->toDateTimeString()
                ]);
            }



            $user=$userStripe->user;
            $dataMail = [
                'billing_url'  => route('profile.billing'),
                'request_url' => route('support.ticket.create'),
                'date'=>Carbon::now()->toDateTimeString(),
                'total'=>round(($amount/100),2),
            ];

            Mail::queue(['text' => 'emails.billing.invoiceUpcoming'], $dataMail, function ($message) use ($user) {
                $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                $message->subject('PushAuth Invoice Upcoming');
                $message->to($user->email);
            });


        }

if ($json['type'] == 'invoice.payment_succeeded') {

            $customerID = $json['data']['object']['customer'];
            $invoiceID = $json['data']['object']['id'];
            //$period_end = $json['data']['object']['lines']['data'][0]['period']['end'];
            $amount = $json['data']['object']['total'];

            $userStripe = UserStripe::where('customer_id', $customerID)->firstOrFail();

            if ($json['data']['object']['paid'] == true) {
                $endDT = Carbon::createFromTimeStampUTC($json['data']['object']['lines']['data'][0]['period']['end'])->toDateTimeString();

                $userStripe->update([
                    'current_period_end' => $endDT,
                    'error_status'=>'false'
                ]);
                $userStripe->user->plan()->update([
                    'plan_id' => '2',
                ]);

                UserStripeInvoice::where('invoice_id', $invoiceID)->update([
                    'paid' => 'true'
                ]);

                $user=$userStripe->user;
                $dataMail = [
                    'billing_url'  => route('profile.billing'),
                    'request_url' => route('support.ticket.create'),
                    'date'=>Carbon::now()->toDateTimeString(),
                    'total'=>round(($amount/100),2),
                ];

                Mail::queue(['text' => 'emails.billing.invoicePaySuccess'], $dataMail, function ($message) use ($user) {
                    $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                    $message->subject('PushAuth Payment Success');
                    $message->to($user->email);
                });


            }
            }
if($json['type'] == 'invoice.payment_failed') {

                $customerID = $json['data']['object']['customer'];
                $userStripe = UserStripe::where('customer_id', $customerID)->firstOrFail();
                $customer = Customer::retrieve($customerID);
                $invoiceID = $json['data']['object']['id'];

                if ($userStripe->cards()->count() > 1) {

                    if ($userStripe->cards()
                            ->where('default', 'false')
                            ->where('attempt_dt', '<=', Carbon::now()->subHour()->toDateTimeString())
                            ->count() > 0
                    ) {
                        $nextCard = $userStripe->cards()
                            ->where('default', 'false')
                            ->where('attempt_dt', '<=', Carbon::now()->subHour()->toDateTimeString())
                            ->first();

                        $customer->default_source = $nextCard->card_id;
                        $customer->save();

                        $userStripe->cards()->update([
                            'default' => 'false',
                        ]);
                        $nextCard->update([
                            'attempt_dt' => Carbon::now(),
                            'default'    => 'true',
                        ]);

                        $invoice = Invoice::retrieve($invoiceID);
                        $invoice = $invoice->pay();

                        return response()->json([], 200);

                    } /*else {
                //TODO mail can not proceesed
            }*/


                } /*elseif ($userStripe->cards()->count() == 1) {
            //one card

            //TODO mail can not proceesed



        }*/
                UserStripeInvoice::where('invoice_id', $invoiceID)->update([
                    'paid'=>'false'
                ]);

                $user = $userStripe->user;

                if ($json['data']['object']['attempt_count'] == 1) {

                    $userStripe->update([
                        'error_status'=>'true'
                    ]);

                    $dataMail = [
                        'billing_url'  => route('profile.billing'),
                        'request_url' => route('support.ticket.create'),
                    ];

                    Mail::queue(['text' => 'emails.billing.invoicePayFail'], $dataMail, function ($message) use ($user) {
                        $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                        $message->subject('PushAuth  We could not process your payment');
                        $message->to($user->email);
                    });



                }


                if ($json['data']['object']['next_payment_attempt'] == null) {

                    $userStripe->user->plan()->update([
                        'plan_id' => '1',
                    ]);

                    $subscription = Subscription::retrieve($userStripe->subscription_id);
                    $subscription->cancel();

                    $userStripe->update([
                        'subscription_id'    => Null,
                        'current_period_end' => Null,
                        'error_status'=>'true',
                        'plan_id'=>Null
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

                }




            /*    $user=$userStripe->user;
                $user->*/

        }


        return response()->json([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

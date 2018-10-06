@include('dashboard.layout.header')
{!!  Html::style('assets/css/account.css') !!}


@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')
<div id="content-wrapper" class="content-wrapper view view-account">
    <div class="container-fluid">
        <h2 class="view-title">My Account</h2>
        <div class="row">
            <div class="module-wrapper col-lg-12 col-md-12 col-sm-12 col-xs-12">

                @include('dashboard.layout.result_msg')


                <section class="module">
                    <div class="module-inner">
                        <div class="side-bar">
                            @include('dashboard.profile.userinfo')

                            @include('dashboard.profile.nav')

                        </div>

                        <div class="content-panel">
                            <h2 class="title">Billing</h2>
                            <div class="billing">
                                <div class="secure text-center margin-bottom-md">
                                    @if ($user->stripe)
                                    @if ($user->stripe->error_status == 'true')
                                        <div class="alert alert-theme alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <strong>Your payment method failed.</strong> Please update or change your
                                            credit cards to attempt to charge again, to prevent suspension.

                                        </div>
                                    @endif
                                    @endif





                                    @if ($user->stripeCards()->count() == 0)
                                        <div class="alert alert-theme alert-pink alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <strong>Ooops!</strong> You dont have any active credit card. Please add
                                            card first for change to premium plan.
                                        </div>
                                    @endif


                                    <h3 class="margin-bottom-md text-success">
                                        <span class="fs1 icon" aria-hidden="true" data-icon="&#xe06c;"></span>
                                        Secure credit card payment<br/>
                                        <small>This is a secure TLS encrypted payment</small>
                                    </h3>
                                    <div class="accepted-cards">
                                        <ul class="list-inline">
                                            <li>
                                                <img src="{{asset('assets/images/payment-icon-set/icons/visa-curved-32px.png')}}"
                                                     alt="Visa"/></li>
                                            <li>
                                                <img src="{{asset('assets/images/payment-icon-set/icons/mastercard-curved-32px.png')}}"
                                                     alt="MasterCard"/></li>
                                            <li>
                                                <img src="{{asset('assets/images/payment-icon-set/icons/maestro-curved-32px.png')}}"
                                                     alt="Maestro"/></li>
                                            <li>
                                                <img src="{{asset('assets/images/payment-icon-set/icons/american-express-curved-32px.png')}}"
                                                     alt="American Express"/></li>
                                        </ul>
                                    </div>
                                </div>

                                @if ($user->stripeCards()->count() == 0)
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button id="addCard" type="button"
                                                    class="btn btn-lg btn-block btn-pink-alt addCard">Add credit card
                                            </button>
                                            <br>
                                        </div>
                                    </div>
                                @endif

                                @if ($user->stripe)



                                    @if($user->stripe->subscription_id == Null)
                                        @if ($user->stripe->cards->count() > 0)
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <a href="{{route('profile.billing.charge')}}" style="font-size: 16px;"
                                                   class="btn btn-lg btn-block btn-pink-alt">Subscribe to PREMIUM plan (49$/month)</a>
                                                <br>
                                            </div>
                                        </div>
                                            @endif
                                    @else
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <a href="{{route('profile.billing.cancel')}}" style="font-size: 16px;"
                                                   class="btn btn-lg btn-block btn-pink-alt">Cancel subscription</a>
                                                <br>
                                            </div>
                                        </div>
                                    @endif
@endif


                                    <div class="row">

                                        @if ($user->stripeCards()->count() > 0)
                                        <section class="module module-headings" style="    margin-left: 50px;
    margin-right: 50px;">
                                            <div class="module-inner">
                                                <div class="module-heading">
                                                    <h3 class="module-title">Your credit cards</h3>
                                                    <ul class="actions list-inline" style="margin-top: -15px;">

                                                        <li>
                                                            <button id="addCard" type="button"
                                                                    class="btn btn-pink-alt addCard">Add credit card
                                                            </button>
                                                        </li>

                                                    </ul>

                                                </div>

                                                <div class="module-content collapse in" id="content-3">


                                                    @foreach($user->stripeCards()->orderBy('default','asc')->get() as $stripeCard)

                                                        <div class="module-content-inner no-padding-bottom row">
                                                            <div class="col-md-6">
                                                                <h4>{{$stripeCard->brand}}
                                                                    xxxx-<strong>{{$stripeCard->last4}}</strong></h4>
                                                                <p class="text-muted">Expires {{$stripeCard->exp_month}}
                                                                    /{{$stripeCard->exp_year}}</p>
                                                            </div>
                                                            <div class="col-md-6 text-right">
                                                                <button type="button"
                                                                        data-card-hash="{{$stripeCard->hash}}"
                                                                        class="btn btn-danger btn-circle removeCard">
                                                                    <span class="icon icon_close"></span></button>
                                                            </div>

                                                        </div>
                                                    @endforeach



                                                </div>

                                            </div>

                                        </section>
                                        @endif

                                    </div>
                                    <div class="row">


                                        @if ($user->stripeInvoice()->count() > 0)
                                            <section class="module module-headings" style="">
                                                <div class="module-inner">
                                                    <div class="module-heading">
                                                        <h3 class="module-title">Billing history</h3>


                                                    </div>

                                                    <div class="module-content collapse in" id="content-3">
                                                        <div class="module-content-inner no-padding-bottom row">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Date</th>
                                                                        <th>Description</th>
                                                                        <th>Amount</th>
                                                                        <th></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    @foreach($user->stripeInvoice()->orderBy('id','desc')->where('created_at', '>=', \Carbon\Carbon::now()->subYear()->toDateTimeString())->get() as $invoice)
                                                                        <tr>
                                                                            <th>{{$invoice->created_at}} UTC</th>
                                                                            <td>Invoice for PREMIUM,
                                                                                period: {{$invoice->period_start}}
                                                                                - {{$invoice->period_end}}</td>
                                                                            <td>{{round(($invoice->amount/100),2)}} {{strtoupper($invoice->currency)}}</td>
                                                                            <td>
                                                                                @if($invoice->paid == 'true')
                                                                                    <label class="label label-success">paid</label>
                                                                                @elseif($invoice->paid == 'false')
                                                                                    <label class="label label-default">unpaid</label>
                                                                                @endif


                                                                            </td>
                                                                        </tr>
                                                                    @endforeach


                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>


                                                    </div>

                                                </div>

                                            </section>
                                        @endif


                                    </div>



                            </div>

                        </div>

                    </div>

                </section>

            </div>

        </div>

    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="myModalAddCard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add credit card</h4>
            </div>
            <div class="modal-body">


                {!! Form::open(array('route' => 'profile.billing.save','class'=>'form-horizontal','role'=>'form', 'autocomplete'=>'off', 'data-stripe-publishable-key'=>env('STRIPE_KEY'), 'id'=>'stripe-form','method'=>'POST')) !!}


                <div class="form-group">
                    <label class="col-sm-3 control-label">Card Number </label>
                    <div class="col-sm-9">
                        <input id="stripe-card"  autocorrect='off' autocapitalize='off' autocomplete='off' type="text" class="form-control" placeholder="••••  ••••  ••••  ••••">
                        <p class="help-block">The 16 digits on the front of your credit card.</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Expiration Date</label>
                    <div class="col-sm-9 form-inline">
                        <select id="stripe-month" class="form-control" autocorrect='off' autocapitalize='off' autocomplete='off'>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <span class="divider">/</span>
                        <select id="stripe-year" class="form-control" autocorrect='off' autocapitalize='off' autocomplete='off'>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                            <option value="2031">2031</option>
                            <option value="2032">2032</option>
                            <option value="2033">2033</option>
                            <option value="2034">2034</option>
                            <option value="2035">2035</option>
                            <option value="2036">2036</option>
                            <option value="2037">2037</option>

                        </select>
                        <p class="help-block">The date your credit card expires. Find this on the front of your credit
                            card.</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Security Code</label>
                    <div class="col-sm-9">
                        <input id="stripe-cvc" autocorrect="off" autocapitalize="off" autocomplete="off" type="password" class="form-control" style="width: 120px;" placeholder="CVC">
                        <p class="help-block">The last 3 digits displayed on the back of your credit card.</p>
                    </div>
                </div>

                {{-- <hr />
                 <div class="action-wrapper text-center">

                     <div class="action-btn">
                         <button type="submit" id="btn" class="btn btn-success btn-lg">
                             Save payment method

                         </button>
                     </div>


                 </div>--}}
                <div class='row'>
                    <div class='col-md-12 error form-group hide'>
                        <hr>
                        <div class='alert-danger alert'>
                            Please correct the errors and try again.
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default-alt" data-dismiss="modal">Close</button>
                <button id="btn" class="btn btn-primary">Add card</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModalRemoveCard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Sure to remove card?</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure to want remove credit card from billing?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default-alt" data-dismiss="modal">Close</button>
                <button id="makeDeleteCard" data-card-hash="" class="btn btn-danger">Remove card</button>
            </div>
        </div>
    </div>
</div>


@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')


<script src="https://js.stripe.com/v2/"></script>
<script>


    $(document).ready(function () {

        $('body').on('click', '#btn', function (event) {
            event.preventDefault();

            $('#stripe-form').submit();

        });


        //removeCard
        $('body').on('click', '.removeCard', function (event) {
            event.preventDefault();
            $('#makeDeleteCard').attr('data-card-hash', $(this).attr('data-card-hash'));
            $('#myModalRemoveCard').modal('show');

        });

        $('body').on('click', '#makeDeleteCard', function (event) {
            event.preventDefault();
            $('#myModalRemoveCard').modal('hide');
            var hash = $(this).attr('data-card-hash');

            window.location = '{{route('billing.card.delete',Null)}}/' + hash;

        });


        $('body').on('click', '.addCard', function (event) {
            event.preventDefault();

            $('#myModalAddCard').modal('show');

        });


        Stripe.setPublishableKey('{!! env('STRIPE_KEY') !!}');

        function stripeResponseHandler(status, response) {
            var $form = $('#stripe-form');

            if (response.error) {
                $('#btn').removeClass('disabled');
                $('#btn').text('Save payment method');

                $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
            } else {
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }


        };


        $('#stripe-form').submit(function (event) {
            var $form = $(this);
            event.preventDefault();
            // Disable the submit button to prevent repeated clicks
            //$form.find('button').prop('disabled', true);
            $("#btn").addClass('disabled').text('Just one moment...');

            Stripe.card.createToken({
                number: $('#stripe-card').val(),
                cvc: $('#stripe-cvc').val(),
                exp_month: $('#stripe-month').val(),
                exp_year: $('#stripe-year').val()
            }, stripeResponseHandler);

            // Prevent the form from submitting with the default action
            return false;
        });


        /*
         $('#btn').on('click', function(e) {
         var form = $('#stripe-form');


         $("#btn").attr('disabled', 'disabled').text('Just one moment...');



         e.preventDefault();



         Stripe.card.createToken({
         number: $('#stripe-card').val(),
         cvc: $('#stripe-cvc').val(),
         exp_month: $('#stripe-month').val(),
         exp_year: $('#stripe-year').val()
         }, function(status, response) {
         var token;
         if (response.error) {
         form.find('#stripe-errors').text(response.error.message).show();
         $("#btn").removeAttr('disabled');
         $("#btn").text(submitInitialText);
         } else {
         token = response.id;
         form.append($('<input type="hidden" name="token">').val(token));
         form.submit();
         }
         });

         });*/


    });


</script>
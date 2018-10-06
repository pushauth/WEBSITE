<?php

namespace PushAuth\Http\Controllers\Admin;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Mail;
use PushAuth\Files;
use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\PricePlan;
use PushAuth\PushRequest;
use PushAuth\Ticket;
use PushAuth\User;
use PushAuth\UserApp;
use PushAuth\UserConfirm;
use PushAuth\UserDeviceConfirm;
use PushAuth\UserDevices;
use PushAuth\UserLogin;
use Response;
use Session;
use Storage;
use Validator;

use Image;

class AdminController extends Controller
{


    public function indexNotify($id = null)
    {

        //dd($id);


        if ($id != Null) {
            $u = User::find($id);

            $client[$u->id] = $u->name;
            $clientArr = [$u->id];
        }
        else {
            $client = [];
            $clientArr = [];
        }
        $data=[
          'client' => $client,
          'clientArr'=>$clientArr
        ];
        return view('dashboard.admin.notify')->with($data);
    }

    public function storeNotify(Request $request)
    {

//dd($request->all());

        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'body'=>'required',

            //'to_field'=>'required_if:to,false|email',
            //'code'=>'required_if:mode,false|min:3|max:8'
        ],
            [
                /*'to_field.required_if'=>'Required To field, when you select remote push.',
                'to_field.email'=>'Field To must be valid email address',
                'code.required_if'=>'Required Code field, when you select push type of Code.',
                'code.min'=>'Field Code must be min 3 character',
                'code.max'=>'Field Code must be max 8 character',*/
            ]);

        if ($validator->fails()) {


            $request->session()->flash('alert-warning', 'Validating error.');
            return back()->withErrors($validator)->withInput();

        } else {
            //return Response::json(['3'=>'2'], 422);




            if ($request->mode_to == 'enable') {
                //all
                $clients = User::where('status', 'enable')->get();
            }
            else {
                $clients = User::whereIn('id', $request->client)->get();
            }

        $timer = 5;
            foreach ($clients as $client) {

                $client->notifications()->create([
                    'subject'=>$request->subject,
                    'body'=>$request->body,
                    'urlhash'=>str_random(32),
                ]);



                if ($request->with_mail == 'enable') {
                    $subj = $request->subject;
                    $body = $request->email_body;
                    $dataMail= [
                        'body'=>$body
                    ];

                    Mail::later($timer,['text' => 'emails.information.notify'], $dataMail, function ($message) use ($client,$subj) {
                        $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                        $message->subject('PushAuth Information - '.$subj);
                        $message->to($client->email);
                    });


                }


                $timer=$timer+5;
            }




            Session::flash('alert-success', 'The message is sended.');

            return redirect()->route('admin.notify');
        }





            //return view('dashboard.admin.pushes');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //


        $data= [
            'totalUserConfirmed'=>UserConfirm::all(),
            'totalDeviceConfirmed'=>UserDeviceConfirm::all(),
            'totalUsers'=>User::all(),
            'totalPushes'=>PushRequest::all(),
            'totalDevices'=>UserDevices::all(),
            'totalApps'=>UserApp::all()
        ];






        return view('dashboard.admin.index')->with($data);
    }
    public function indexUsers()
    {
        //
        //$users = User::orderBy('updated_at', 'DESC')->paginate(10);

/*        $data = [
            'users'=>$users
        ];*/




        return view('dashboard.admin.users');
    }




    public function updatePlan($id, Request $request)
    {

        $validator = Validator::make($request->all(), [


            //'to_field'=>'required_if:to,false|email',
            //'code'=>'required_if:mode,false|min:3|max:8'
        ],
            [
                /*'to_field.required_if'=>'Required To field, when you select remote push.',
                'to_field.email'=>'Field To must be valid email address',
                'code.required_if'=>'Required Code field, when you select push type of Code.',
                'code.min'=>'Field Code must be min 3 character',
                'code.max'=>'Field Code must be max 8 character',*/
            ]);

        if ($validator->fails()) {


            $request->session()->flash('alert-warning', 'Validating error.');
            return back()->withErrors($validator)->withInput();

        } else {


            $plan = PricePlan::find($id);

            $limits = $plan->limits;

            $plan->update([
                'name'=>$request->name
            ]);


            $limits->where('key', 'pushes')->where('period', 'day')->first()->update([
                'value'=>$request->pushes_day
            ]);


$limits->where('key', 'pushes')->where('period', 'month')->first()->update(['value'=>$request->pushes_month]);
$limits->where('key', 'logs')->first()->update(['period'=>$request->logs_period]);
$limits->where('key', 'apps')->first()->update(['value'=>$request->apps]);
$limits->where('key', 'users')->first()->update(['value'=>$request->users]);
$limits->where('key', 'devices')->first()->update(['value'=>$request->devices]);
$limits->where('key', 'routes')->first()->update(['value'=>$request->routes]);
$limits->where('key', 'webhooks')->first()->update(['value'=>$request->webhooks]);





            Session::flash('alert-success', 'The plan is updated.');

            return redirect()->route('admin.plans');
        }




    }





    public function showPlan($id)
    {

        $plan = PricePlan::find($id);

        $limits = $plan->limits;


        $limits = [
            'name'=>$plan->name,
            'pushes_day'=>$limits->where('key', 'pushes')->where('period', 'day')->first()->value,
            'pushes_month'=>$limits->where('key', 'pushes')->where('period', 'month')->first()->value,
            'logs_period'=>$limits->where('key', 'logs')->first()->period,
            'apps'=>$limits->where('key', 'apps')->first()->value,
            'users'=>$limits->where('key', 'users')->first()->value,
            'devices'=>$limits->where('key', 'devices')->first()->value,
            'routes'=>$limits->where('key', 'routes')->first()->value,
            'webhooks'=>$limits->where('key', 'webhooks')->first()->value
        ];

        $data = [
            'plan'=>$plan,
            'limits'=>$limits

        ];

        return view('dashboard.admin.plan')->with($data);

    }

    public function indexTickets()
    {
        //
        //$users = User::orderBy('updated_at', 'DESC')->paginate(10);

        /*        $data = [
                    'users'=>$users
                ];*/

        $tickets = Ticket::all();


        $data = [
            'tickets'=>$tickets
        ];



        return view('dashboard.admin.tickets')->with($data);
    }


    public function indexPlans()
    {
        //
        //$users = User::orderBy('updated_at', 'DESC')->paginate(10);

        /*        $data = [
                    'users'=>$users
                ];*/

        $plans = PricePlan::all();


        $data = [
            'plans'=>$plans
        ];



        return view('dashboard.admin.plans')->with($data);
    }



    public function indexPushes()
    {


        return view('dashboard.admin.pushes');
    }

public function indexPushesAjaxApp(Request $request, $id) {

    $dataArr=[];
    $orderColumn = $request->order['0']['column']+1;
    $orderDir = $request->order['0']['dir'];

    if ($request->search['value']) {
        $searchSlug = $request->search['value'];

        $data = PushRequest::where(function ($query) use ($searchSlug) {
            return $query
                ->where('hash', 'LIKE', '%' . $searchSlug . '%')
                ->orWhere('mode', 'LIKE', '%' . $searchSlug . '%')
                ->orWhereHas('app', function ($q) use ($searchSlug) {
                    return $q->where('name', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhere('about', 'LIKE', '%' . $searchSlug . '%');
                })
                ->orWhereHas('device', function ($q) use ($searchSlug) {
                    return $q->where('uuid', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhere('token', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhere('os', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhereHas('user', function ($q) use ($searchSlug) {
                            return $q->where('name', 'LIKE', '%' . $searchSlug . '%');
                        });
                });
            //->orWhere('url', 'LIKE', '%' . $searchSlug . '%')
            //->orWhere('about', 'LIKE', '%' . $searchSlug . '%');

        })
            ->where('app_id', $id)
            ->get();

    }else {
        $data = PushRequest::with('app','device')->where('app_id', $id)->get();
    }


    $dataCount = $data->count();



    foreach ($data as $item) {

        //$itemStatus='';


        if ($item->status == 'enable') {
            $itemStatus='<span class=\'label label-normal\'>enable</span>';
        } else {
            $itemStatus='<span class=\'label label-critical\'>disable</span>';
        }

        if ($item->mode == 'code') {
            $answer = '<span class=\'label label-review\'>OK</span>';
            $mode = '<span class=\'label label-normal\'>code</span>';
        } elseif ($item->mode == 'push') {
            $mode = '<span class=\'label label-critical\'>push</span>';
            if ($item->answer == Null) {
                $answer = '<span class=\'label label-progress\'>no answer</span>';
            } else {
                if ($item->answer == 'true') {
                    $answer = '<span class=\'label label-open\'>YES</span>';
                }else {
                    $answer = '<span class=\'label label-closed\'>NO</span>';
                }
            }
        }
        elseif ($item->mode == 'qr') {
            $mode = '<span class=\'label label-normal\'>QR code</span>';
            if ($item->response_code == Null) {
                $answer = '<span class=\'label label-progress\'>not using</span>';
            } else {
                $answer = '<span class=\'label label-open\'>used</span>';
            }

        }


        if ($item->device) {
            $clientDevice = '<a href=\''.route('admin.device',$item->device->id).'\'>'.str_limit($item->device->token, 6,'<strong>XXX</strong>').'</a>/'.'<a href=\''.route('admin.user.show',$item->device->user->id).'\'>'.$item->device->user->name.'</a>';
        } else {
            $clientDevice = '-';
        }



        array_push($dataArr,
            ['1'           => $item->created_at->toDateTimeString(),
             '2'           => $clientDevice,
             '3'           => $mode,
             '4'           => $answer,
             //'5'           => $item->app->name,
             '5'            =>str_limit($item->hash, 6,'<strong>XXX</strong>'),
             /*                 '7'           => 'show',
                              '8'           => 'del',*/
             "DT_RowClass" => null,
            ]);
    }


    $dataCollect = collect($dataArr);



    if ($orderDir == 'desc') {
        $dataCollect = $dataCollect->sortByDesc($orderColumn);
    }else {
        $dataCollect = $dataCollect->sortBy($orderColumn);
    }




    $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();




    $dataRes = ['draw' => intval($request->draw),
                'recordsTotal' => $dataCount,
                'recordsFiltered' => $dataCount,
                'data' => $dataArr,

    ];

    return response()->json($dataRes);


}




    public function indexPushesAjaxByDevice(Request $request, $id)
    {

        $dataArr=[];
        $orderColumn = $request->order['0']['column']+1;
        $orderDir = $request->order['0']['dir'];

        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $data = PushRequest::where(function ($query) use ($searchSlug) {
                return $query
                    ->where('hash', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('mode', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhereHas('app', function ($q) use ($searchSlug) {
                        return $q->where('name', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('about', 'LIKE', '%' . $searchSlug . '%');
                    })
                    ->orWhereHas('device', function ($q) use ($searchSlug) {
                        return $q->where('uuid', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('token', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('os', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhereHas('user', function ($q) use ($searchSlug) {
                                return $q->where('name', 'LIKE', '%' . $searchSlug . '%');
                            });
                    });
                //->orWhere('url', 'LIKE', '%' . $searchSlug . '%')
                //->orWhere('about', 'LIKE', '%' . $searchSlug . '%');

            })->where('device_id', $id)->get();

        }else {
            $data = PushRequest::with('app','device')->where('device_id', $id)->get();
        }


        $dataCount = $data->count();



        foreach ($data as $item) {

            //$itemStatus='';


            if ($item->status == 'enable') {
                $itemStatus='<span class=\'label label-normal\'>enable</span>';
            } else {
                $itemStatus='<span class=\'label label-critical\'>disable</span>';
            }

            if ($item->mode == 'code') {
                $answer = '<span class=\'label label-review\'>OK</span>';
                $mode = '<span class=\'label label-normal\'>code</span>';
            } elseif ($item->mode == 'push') {
                $mode = '<span class=\'label label-critical\'>push</span>';
                if ($item->answer == Null) {
                    $answer = '<span class=\'label label-progress\'>no answer</span>';
                } else {
                    if ($item->answer == 'true') {
                        $answer = '<span class=\'label label-open\'>YES</span>';
                    }else {
                        $answer = '<span class=\'label label-closed\'>NO</span>';
                    }
                }
            }





            array_push($dataArr,
                ['1'           => $item->created_at->toDateTimeString(),
                 '2'           => '<a href=\''.route('admin.app',$item->app->id).'\'>'.$item->app->name.'</a>',
                 '3'           => $mode,
                 '4'           => $answer,
                 //'5'           => $item->app->name,
                 '5'            =>str_limit($item->hash, 6,'<strong>XXX</strong>'),
                 /*                 '7'           => 'show',
                                  '8'           => 'del',*/
                 "DT_RowClass" => null,
                ]);
        }


        $dataCollect = collect($dataArr);



        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        }else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }




        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();




        $dataRes = ['draw' => intval($request->draw),
                    'recordsTotal' => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data' => $dataArr,

        ];

        return response()->json($dataRes);


    }
    public function updateTicketClose($id)
    {
        try {
            $ticket = Ticket::where('url_hash', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            Session::flash('alert-warning', 'The ticket with ID: ' . $id . ' was not found.');

            return redirect()->route('admin.tickets');
        }

        $ticket->update([
           'status'=>'close'
        ]);
        Session::flash('alert-success', 'The ticket was updated!');

        return redirect()->route('admin.ticket.show',$ticket->id);

    }
    public function updateTicketWork($id)
    {
        try {
            $ticket = Ticket::where('url_hash', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            Session::flash('alert-warning', 'The ticket with ID: ' . $id . ' was not found.');

            return redirect()->route('admin.tickets');
        }

        $ticket->update([
            'status'=>'work'
        ]);
        Session::flash('alert-success', 'The ticket was updated!');

        return redirect()->route('admin.ticket.show',$ticket->id);
    }


    public function storeTicketAnswer($id, Request $request)
    {


        $user = Auth::user();

        try {
            $ticket = Ticket::where('url_hash', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            Session::flash('alert-warning', 'The ticket with ID: ' . $id . ' was not found.');

            return redirect()->route('admin.tickets');
        }



        $validator = Validator::make($request->all(), [
            'body' => 'required|min:8',
        ]);
        $validator->setAttributeNames([
            'body'=>'Comment'
        ]);

        if ($validator->fails()) {

            $request->session()->flash('alert-warning', 'Validating error.');

            return back()->withErrors($validator)->withInput();

        } else {


            if ($request->hasFile('files')) {


                $files=$request->file('files');
                $uploadcount=0;
                $file_count=count($files);

                //dd('count: '.$file_count);
                foreach ($files as $file) {


                    $validatorFile = Validator::make(['files' => $file], [
                        'files'=>'max:512'
                    ]);
                    if ($validatorFile->passes()) {
                        $uploadcount++;
                    }
                }


                if ($uploadcount != $file_count) {

                    $request->session()->flash('alert-warning', 'File may be size until 512K');

                    return back()->withErrors($validatorFile)->withInput();

                }


            }


            $thread = $ticket->threads()->create([
                'author_id'=>$user->id,
                'text'=>$request->body,
                'url_hash'=>str_random(32),
            ]);



            if ($request->hasFile('files')) {
                //Create files
                $storage = Storage::disk('users');
                if (!$storage->exists($user->id)) {
                    $storage->makeDirectory($user->id);
                }


                foreach ($files as $file) {

                    $extension = $file->getClientOriginalExtension();
                    $mime = $file->getClientMimeType();
                    $originalName = $file->getClientOriginalName();

                    $fileHash = str_random(30);
                    $file_name = $fileHash . '.' . strtolower($extension);
                    $storage->put($user->id . '/' . $file_name,
                        file_get_contents($file->getRealPath()));

                    $isimage = 'false';
                    if (substr($mime, 0, 5) == 'image') {
                        $isimage = 'true';
                    }

                    Files::create([

                        'user_id'     => $user->id,
                        'target_id'   => $thread->id,
                        'target_type' => 'ticket_thread',
                        'name'        => $originalName,
                        'hash'        => $fileHash,
                        'mime'        => $mime,
                        'extension'   => strtolower($extension),
                        'status'      => 'success',
                        'image'       => $isimage,

                    ]);

                }
            }


            $dataMail = [
                'url'=>route('support.ticket.show',$ticket->url_hash),
                'code'=>str_limit($ticket->url_hash,6,'')
            ];

            $client = $ticket->client;

            Mail::queue(['text' => 'emails.ticket.comment2client'], $dataMail, function ($message) use ($client) {
                $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                $message->subject('PushAuth Support Service');
                $message->to($client->email);
            });


            Session::flash('alert-success', 'The answer was added!');

            return redirect()->route('admin.ticket.show',$ticket->id);









        }






    }



    public function showTicket($id)
    {
        try {
            $ticket = Ticket::where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            Session::flash('alert-warning', 'The ticket with ID: ' . $id . ' was not found.');

            return redirect()->route('support.ticket.index');
        }


        $data = [
          'ticket'=>$ticket
        ];
        return view('dashboard.admin.ticket')->with($data);

    }




    public function indexTicketsAjax(Request $request)
    {
        $dataArr=[];
        $orderColumn = $request->order['0']['column']+1;
        $orderDir = $request->order['0']['dir'];

        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $data = Ticket::where(function ($query) use ($searchSlug) {
                return $query
                    ->where('url_hash', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('type', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('status', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('subject', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhereHas('app', function ($q) use ($searchSlug) {
                        return $q->where('name', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('about', 'LIKE', '%' . $searchSlug . '%');
                    })
                    ->orWhereHas('client', function ($q) use ($searchSlug) {
                        return $q->where('email', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('name', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhereHas('profile', function ($q) use ($searchSlug) {
                                return $q->where('first_name', 'LIKE', '%' . $searchSlug . '%')
                                    ->orWhere('last_name', 'LIKE', '%' . $searchSlug . '%');
                            });
                    });
                //->orWhere('url', 'LIKE', '%' . $searchSlug . '%')
                //->orWhere('about', 'LIKE', '%' . $searchSlug . '%');

            })->get();

        }else {
            $data = Ticket::with('app','client')->get();
        }


        $dataCount = $data->count();



        foreach ($data as $item) {

            //$itemStatus='';


            if ($item->status == 'open') {
                $itemStatus='<span class=\'text-danger\'>[ open ] </span>';
            } elseif ($item->status == 'work') {
                $itemStatus=' <span class=\'text-pink\'>[ work ]</span>';
            } elseif ($item->status == 'close') {
                $itemStatus='<span class=\'text-success\'>[ close ]</span>';
            }




            array_push($dataArr,
                ['1'           => '<a href=\''.route('admin.ticket.show',$item->id).'\'>'.str_limit($item->subject,32,'...').'</a>',

                 '2'           => '<a href=\''.route('admin.user.show',$item->client->id).'\'>'.$item->client->email.'</a>',
                 '3'           => $item->created_at->toDateTimeString(),
                 '4'           => $item->type,
                 '5'           => $itemStatus,
                 '6'            => '<i class=\'fa fa-comment\'></i> '.$item->threads->count(),
                 /*                 '7'           => 'show',
                                  '8'           => 'del',*/
                 "DT_RowClass" => null,
                ]);
        }


        $dataCollect = collect($dataArr);



        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        }else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }




        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();




        $dataRes = ['draw' => intval($request->draw),
                    'recordsTotal' => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data' => $dataArr,

        ];

        return response()->json($dataRes);

    }

    public function indexPushesAjax(Request $request)
    {

        $dataArr=[];
        $orderColumn = $request->order['0']['column']+1;
        $orderDir = $request->order['0']['dir'];

        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $data = PushRequest::where(function ($query) use ($searchSlug) {
                return $query
                    ->where('hash', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('mode', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhereHas('app', function ($q) use ($searchSlug) {
                        return $q->where('name', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('about', 'LIKE', '%' . $searchSlug . '%');
                    })
                    ->orWhereHas('device', function ($q) use ($searchSlug) {
                        return $q->where('uuid', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('token', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('os', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhereHas('user', function ($q) use ($searchSlug) {
                                return $q->where('name', 'LIKE', '%' . $searchSlug . '%');
                            });
                    });
                    //->orWhere('url', 'LIKE', '%' . $searchSlug . '%')
                //->orWhere('about', 'LIKE', '%' . $searchSlug . '%');

            })->get();

        }else {
            $data = PushRequest::with('app','device')->get();
        }


        $dataCount = $data->count();



        foreach ($data as $item) {

            //$itemStatus='';


            if ($item->status == 'enable') {
                $itemStatus='<span class=\'label label-normal\'>enable</span>';
            } else {
                $itemStatus='<span class=\'label label-critical\'>disable</span>';
            }

if ($item->mode == 'code') {
    $answer = '<span class=\'label label-review\'>OK</span>';
    $mode = '<span class=\'label label-normal\'>code</span>';
} elseif ($item->mode == 'push') {
    $mode = '<span class=\'label label-critical\'>push</span>';
    if ($item->answer == Null) {
        $answer = '<span class=\'label label-progress\'>no answer</span>';
    } else {
        if ($item->answer == 'true') {
            $answer = '<span class=\'label label-open\'>YES</span>';
        }else {
            $answer = '<span class=\'label label-closed\'>NO</span>';
        }
            }
}
elseif ($item->mode == 'qr') {
    $mode = '<span class=\'label label-normal\'>QR code</span>';
    if ($item->response_code == Null) {
        $answer = '<span class=\'label label-progress\'>not using</span>';
    } else {
        $answer = '<span class=\'label label-open\'>used</span>';
    }

}


            if ($item->device) {
                $clientDevice = '<a href=\''.route('admin.device',$item->device->id).'\'>'.str_limit($item->device->token, 6,'<strong>XXX</strong>').'</a>/'.'<a href=\''.route('admin.user.show',$item->device->user->id).'\'>'.$item->device->user->name.'</a>';
            } else {
                $clientDevice = '-';
            }





            array_push($dataArr,
                ['1'           => $item->created_at->toDateTimeString(),
                 '2'           => $clientDevice,
                 '3'           => $mode,
                 '4'           => $answer,
                 '5'           => '<a href=\''.route('admin.app',$item->app->id).'\'>'.$item->app->name.'</a>',
                 '6'            =>str_limit($item->hash, 6,'<strong>XXX</strong>'),
/*                 '7'           => 'show',
                 '8'           => 'del',*/
                 "DT_RowClass" => null,
                ]);
        }


        $dataCollect = collect($dataArr);



        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        }else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }




        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();




        $dataRes = ['draw' => intval($request->draw),
                    'recordsTotal' => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data' => $dataArr,

        ];

        return response()->json($dataRes);


    }




    public function indexDevices()
    {


        return view('dashboard.admin.devices');
    }

    public function indexDevicesAjaxAppsByDevice(Request $request, $id= null)
    {

        $dataArr=[];
        $orderColumn = $request->order['0']['column']+1;
        $orderDir = $request->order['0']['dir'];


        $query = PushRequest::query();



        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $query->whereHas('device', function ($q) use ($searchSlug) {
                return $q->where('os', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('uuid', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('token', 'LIKE', '%' . $searchSlug . '%');
            })
                ->get();
        }else {
            $query->with('device')->get();
        }


        //if ($id != null) {
        $query->where('device_id', $id);
        $query->groupBy('app_id');




        $data = $query->get();
        $dataCount = $data->count();
//dd($data->all());


        foreach ($data as $item) {

            //$itemStatus='';
            //dd($item->device);


            if ($item->app->status == 'enable') {
                $itemStatus='<span class=\'label label-normal\'>enable</span>';
            } else {
                $itemStatus='<span class=\'label label-critical\'>disable</span>';
            }
            //$devices =$item->pushRequests->lists('device_id')->toArray();
            $devices =$item->app->pushRequests->lists('device_id')->toArray();

            array_push($dataArr,
                ['1'           =>  '<a href=\''.route('admin.app',$item->id).'\'>'.$item->app->name.'</a>',
                 '2'           => $item->app->pushRequests->count(),
                 '3'           => count(array_unique($devices)),
                 '4'           => '<a href=\''.route('admin.user.show',$item->app->user->id).'\'>'.$item->app->user->name.'</a>',
                 '5'           => $itemStatus,
                 /*                 '6'           => 'edit',
                                  '7'           => 'del',*/
                 "DT_RowClass" => null,
                ]);

        }


        $dataCollect = collect($dataArr);



        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        }else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }




        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();




        $dataRes = ['draw' => intval($request->draw),
                    'recordsTotal' => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data' => $dataArr,

        ];

        return response()->json($dataRes);



    }









    public function indexDevicesAjaxApp(Request $request, $id= null)
    {

        $dataArr=[];
        $orderColumn = $request->order['0']['column']+1;
        $orderDir = $request->order['0']['dir'];


        $query = PushRequest::query();



        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $query->whereHas('device', function ($q) use ($searchSlug) {
                return $q->where('os', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('uuid', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('token', 'LIKE', '%' . $searchSlug . '%');
            })
                ->get();
        }else {
            $query->with('device')->get();
        }


        //if ($id != null) {
            $query->where('app_id', $id);
        $query->groupBy('device_id');




        $data = $query->get();
        $dataCount = $data->count();
//dd($data->all());


        foreach ($data as $item) {

            //$itemStatus='';
            //dd($item->device);

            if ($item->device) {


                if ($item->device->status == 'enable') {
                    $itemStatus = '<span class=\'label label-normal\'>enable</span>';
                } else {
                    $itemStatus = '<span class=\'label label-critical\'>disable</span>';
                }


                array_push($dataArr,
                    ['1'           => '<a href=\'' . route('admin.device', $item->device->id) . '\'>' . str_limit($item->device->uuid, 6, '<strong>XXX</strong>') . '</a>',
                     '2'           => '<a href=\'' . route('admin.device', $item->device->id) . '\'>' . str_limit($item->device->token, 6, '<strong>XXX</strong>') . '</a>',
                     '3'           => '<a href=\'' . route('admin.user.show', $item->device->user->id) . '\'>' . $item->device->user->name . '</a>',
                     '4'           => $item->device->pushes->count(),
                     '5'           => $item->device->os,
                     '6'           => $itemStatus,
                     /*                 '7'           => 'edit',
                                      '8'           => 'del',*/
                     "DT_RowClass" => null,
                    ]);
            }
        }


        $dataCollect = collect($dataArr);



        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        }else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }




        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();




        $dataRes = ['draw' => intval($request->draw),
                    'recordsTotal' => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data' => $dataArr,

        ];

        return response()->json($dataRes);


    }


    public function indexDevicesAjax(Request $request, $id= null)
    {

        $dataArr=[];
        $orderColumn = $request->order['0']['column']+1;
        $orderDir = $request->order['0']['dir'];


        $query = UserDevices::query();



        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $query->where(function ($query) use ($searchSlug) {
                return $query
                    ->where('uuid', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('token', 'LIKE', '%' . $searchSlug . '%');

            })
                ->get();
        }else {
            $query->with('user')->get();
        }


        if ($id != null) {
            $query->where('user_id', $id);
        }



        $data = $query->get();
        $dataCount = $data->count();



        foreach ($data as $item) {

            //$itemStatus='';


            if ($item->status == 'enable') {
                $itemStatus='<span class=\'label label-normal\'>enable</span>';
            } else {
                $itemStatus='<span class=\'label label-critical\'>disable</span>';
            }


            array_push($dataArr,
                ['1'           => '<a href=\''.route('admin.device', $item->id).'\'>'.str_limit($item->uuid, 6,'<strong>XXX</strong>').'</a>',
                 '2'           => '<a href=\''.route('admin.device', $item->id).'\'>'.str_limit($item->token, 6,'<strong>XXX</strong>').'</a>',
                 '3'           => '<a href=\''.route('admin.user.show',$item->user->id).'\'>'. $item->user->name.'</a>',
                 '4'           => $item->pushes->count(),
                 '5'           => $item->os,
                 '6'            =>$itemStatus,
/*                 '7'           => 'edit',
                 '8'           => 'del',*/
                 "DT_RowClass" => null,
                ]);
        }


        $dataCollect = collect($dataArr);



        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        }else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }




        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();




        $dataRes = ['draw' => intval($request->draw),
                    'recordsTotal' => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data' => $dataArr,

        ];

        return response()->json($dataRes);


    }
    public function updateApp(Request $request, $id)
    {


//$user = User::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:24',
            'about'=>'required|min:8',
            'app_img'=>'mimes:jpeg,png|max:1024'
        ]);

        if ($validator->fails()) {

            $request->session()->flash('alert-warning', 'Validating error.');
            return back()->withErrors($validator)->withInput();

        } else {


            //$reqData=$request->all();

            $ips = explode(',', $request->ip_mask);
            $ipsArr = [];
            foreach ($ips as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    array_push($ipsArr, $ip);
                }

            }
            // dd($ipsArr);

            if (count($ipsArr) > 0) {
                $ipmask = implode(',', $ipsArr);
            } else {
                $ipmask = Null;
            }

            ($request->url) ? $url = $request->url : $url = Null;


            try {
                $app = UserApp::where('id', $id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
                Session::flash('alert-warning', 'The App was not found.');

                return redirect()->route('admin.apps');
            }

            $user = $app->user;
            //Create files
            $storage = Storage::disk('users');
            if (!$storage->exists($user->id)) {
                $storage->makeDirectory($user->id);
            }

            $file = $request->file('app_img');
            if ($request->hasFile('app_img')) {
                $extension = $file->getClientOriginalExtension();
                //$mime = $file->getClientMimeType();
                //$originalName = $file->getClientOriginalName();

                $fileHash = str_random(32);
                $file_name = $fileHash . '.' . strtolower($extension);
                $storage->put($user->id . '/' . $file_name,
                    file_get_contents($file->getRealPath()));

                $storage->delete($user->id . '/' . $app->img);


            } else {
                $file_name = $app->img;
            }

//$img;

            ($request->status == 'enable') ? $status = 'enable' : $status = 'disable';


            $app->update([
                'name'    => $request->name,
                'about'   => $request->about,
                'urlhash' => str_random(32),

                'status'  => $status,
                'url'     => $url,
                'ip_mask' => $ipmask,
                'img'     => $file_name,



            ]);


            Session::flash('alert-success', 'The App was updated.');

            return redirect()->route('admin.app',$app->id);

        }

    }

    public function showApp($id)
    {

        $app = UserApp::find($id);
        $data=[
            'app'=>$app
        ];
        return view('dashboard.admin.app')->with($data);
    }

    public function showDevice($id)
    {
        $device = UserDevices::find($id);
        $data=[
            'device'=>$device
        ];

        return view('dashboard.admin.device')->with($data);
    }

    public function showPush($id)
    {

        $push = PushRequest::find($id);
        $data = [
            'push'=>$push
        ];

        return view('dashboard.admin.push')->with($data);
    }






    public function indexApps()
    {


        return view('dashboard.admin.apps');
    }


    public function indexAppsAjax(Request $request, $id = null)
    {

        $dataArr=[];
        $orderColumn = $request->order['0']['column']+1;
        $orderDir = $request->order['0']['dir'];



        /*
         * $query = User::query();
         * if(Input::has('one')){
    $query->where('filter1', '>', Input::get('one'));
}
$users = $query->get();
         */
        $query = UserApp::query();


        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $query->where(function ($query) use ($searchSlug) {
                return $query
                    ->where('name', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('ip_mask', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('url', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('about', 'LIKE', '%' . $searchSlug . '%');

            });
        }else {
            $query->with('user', 'pushRequests');
        }


        if ($id != null) {
            $query->where('user_id', $id);
        }



        $data = $query->get();
        $dataCount = $data->count();



        foreach ($data as $item) {

            //$itemStatus='';


                if ($item->status == 'enable') {
                    $itemStatus='<span class=\'label label-normal\'>enable</span>';
                } else {
                    $itemStatus='<span class=\'label label-critical\'>disable</span>';
                }

/*
            $apps=$item->app()->lists('id')->toArray();
            $pushesCount = PushRequest::whereIn('app_id',$apps)->count();
            $clients = PushRequest::whereIn('app_id',$apps)->lists('device_id')->toArray();*/
            $devices =$item->pushRequests->lists('device_id')->toArray();

            array_push($dataArr,
                ['1'           =>  '<a href=\''.route('admin.app',$item->id).'\'>'.$item->name.'</a>',
                 '2'           => $item->pushRequests->count(),
                 '3'           => count(array_unique($devices)),
                 '4'           => '<a href=\''.route('admin.user.show',$item->user->id).'\'>'. $item->user->name.'</a>',
                 '5'           => $itemStatus,
/*                 '6'           => 'edit',
                 '7'           => 'del',*/
                 "DT_RowClass" => null,
                ]);
        }


        $dataCollect = collect($dataArr);



        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        }else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }




        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();




        $dataRes = ['draw' => intval($request->draw),
                    'recordsTotal' => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data' => $dataArr,

        ];

        return response()->json($dataRes);


    }

    public function indexUsersAjaxJson(Request $request)
    {
        $items = [];

        $searchSlug = $request->q;

        $UserRes = User::where(function ($query) use ($searchSlug) {
            return $query
                ->where('email', 'LIKE', '%' . $searchSlug . '%')
                ->orWhere('name', 'LIKE', '%' . $searchSlug . '%')
                ->orWhereHas('profile', function ($q) use ($searchSlug) {
                    return $q->where('first_name', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhere('company', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhere('tel', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhere('website', 'LIKE', '%' . $searchSlug . '%');
                });
        })
            ->get();

        foreach ($UserRes as $user) {
            # code...
            array_push($items, ['id'       => $user->id,
                                'name'     => $user->name,
                                //'img'      => CoreClass::showUserImgSmall($user->profile->user_img),
                                'position' => $user->email,
                                'value'    => $user->id]);
        }

        $data = ['items' => $items];

        return response()->json($data);



    }

    public function updateUserPassword(Request $request, $id) {
        //admin.update.user.profile

        $user = User::find($id);




        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
           // 'password_old' => 'required|passcheck|min:6',
        ],
            [
                //'passcheck' => 'Your old password was incorrect',
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



            Session::flash('alert-success', 'The profile was updated.');

            return redirect()->route('admin.user.show', $user->id);


        }

    }


    public function updateDevice(Request $request, $id) {

        $device = UserDevices::find($id);

        Session::flash('alert-success', 'The device was updated.');

        $device->update($request->all());

        return redirect()->route('admin.device', $device->id);

    }

    public function updatePush(Request $request, $id) {

        $push = PushRequest::find($id);



        $push->update($request->all());






        Session::flash('alert-success', 'The push was updated.');
        return redirect()->route('admin.push', $push->id);

    }



    public function updateUserEmail(Request $request, $id) {
        //admin.update.user.profile

        $user = User::find($id);


        $validator = Validator::make([
            'email'=>$request->email
        ], [
            'email'=>'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {

            $request->session()->flash('alert-warning', 'Validating error.');
            return back()->withErrors($validator)->withInput();

        } else {


            $user->update(['email'=>$request->email]);

            Session::flash('alert-success', 'The profile was updated.');

            return redirect()->route('admin.user.show', $user->id);


        }





    }

    public function updateUserImage(Request $request, $id) {
        //admin.update.user.profile

        $user = User::find($id);

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
                $storage->delete($user->id . '/' . $user->profile->user_img);
            }

            $img = Image::make($file);
            $img->fit(250, 250);

            $img->save(storage_path('/users/' . $user->id . '/' . $newFileName . '.' . $extension));

            $user->profile()->update(['user_img' => $newFileName . '.' . $extension]);


            Session::flash('alert-success', 'The profile was updated.');

            return redirect()->route('admin.user.show', $user->id);


        }

        }

    public function destroyUserImage(Request $request, $id) {
        //admin.update.user.profile

        $user = User::find($id);

        $storage = Storage::disk('users');
        if (!$storage->exists($user->id)) {
            $storage->makeDirectory($user->id);
        }
        if ($user->profile->user_img != null) {
            $storage->delete($user->id . '/' . $user->profile->user_img);
            $user->profile()->update(['user_img' => Null]);
        }
        Session::flash('alert-success', 'The profile was updated.');

        return redirect()->route('admin.user.show', $user->id);


    }


    public function updateUserProfile(Request $request, $id) {
        //admin.update.user.profile

        $user = User::find($id);

        //dd($user);


        $user->update([
            'name'=>$request->name,
            'confirmed'=>$request->confirmed,
            'status'=>$request->status
        ]);

        $user->profile()->update([
            'first_name'=>$request->profile['first_name'],
            'last_name'=>$request->profile['last_name'],
            'company'=>$request->profile['company'],
            'tel'=>$request->profile['tel'],
            'website'=>$request->profile['website'],
        ]);

        $user->role()->update([
            'role'=>$request->role
        ]);



        Session::flash('alert-success', 'The profile was updated.');

        return redirect()->route('admin.user.show', $user->id);








    }


    public function showUser($id)
    {

        $client = User::find($id);
        $data=[
            'client'=>$client
        ];
        return view('dashboard.admin.user')->with($data);
    }


    public function indexLoginsAjax(Request $request, $id)
    {

        $dataArr=[];
        $orderColumn = $request->order['0']['column']+1;
        $orderDir = $request->order['0']['dir'];

        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $data = UserLogin::where(function ($query) use ($searchSlug) {
                return $query
                    ->where('ip', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('user_agent', 'LIKE', '%' . $searchSlug . '%');

            })
                ->where('user_id',$id)
                ->get();
        }else {
            $data = UserLogin::where('user_id',$id)->get();
        }


        $dataCount = $data->count();



        foreach ($data as $item) {


            array_push($dataArr,
                ['1'           => $item->created_at->toDateTimeString(),
                 '2'           => $item->ip,
                 '3'           => $item->user_agent,
                ]);
        }


        $dataCollect = collect($dataArr);



        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        }else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }




        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();




        $dataRes = ['draw' => intval($request->draw),
                    'recordsTotal' => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data' => $dataArr,

        ];

        return response()->json($dataRes);

    }





    public function indexUsersAjax(Request $request)
    {

        $dataArr=[];
        $orderColumn = $request->order['0']['column']+1;
        $orderDir = $request->order['0']['dir'];

        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $data = User::where(function ($query) use ($searchSlug) {
                return $query
                    ->where('email', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('name', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhereHas('profile', function ($q) use ($searchSlug) {
                        return $q->where('first_name', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('company', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('tel', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('website', 'LIKE', '%' . $searchSlug . '%');
                    });
            })
                ->get();
        }else {
            $data = User::with('profile', 'app', 'devices', 'notifications')->get();
        }


        $dataCount = $data->count();



        foreach ($data as $item) {

            $itemStatus='';

            if ($item->confirmed == 'false') {
                $itemStatus='<span class=\'label label-low\'>not approved</span>';
            } else {
                if ($item->status == 'enable') {
                    $itemStatus='<span class=\'label label-normal\'>enable</span>';
                } else {
                    $itemStatus='<span class=\'label label-critical\'>disable</span>';
                }
            }

            $apps=$item->app()->lists('id')->toArray();
            $pushesCount = PushRequest::whereIn('app_id',$apps)->count();
            $clients = PushRequest::whereIn('app_id',$apps)->lists('device_id')->toArray();


            array_push($dataArr,
                ['1'           => '<a href=\''.route('admin.user.show',$item->id).'\'>'.$item->name.'</a>',
                 '2'           => $item->email,
                 '3'           => $item->app->count(),
                 '4'           => $pushesCount,
                 '5'           => count(array_unique($clients)),
                 '6'           => $itemStatus,
                 "DT_RowClass" => null,
                ]);
        }


        $dataCollect = collect($dataArr);



        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        }else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }




        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();




$dataRes = ['draw' => intval($request->draw),
'recordsTotal' => $dataCount,
'recordsFiltered' => $dataCount,
'data' => $dataArr,

];

return response()->json($dataRes);


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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showLogin($id)
    {
        $user = Auth::user();



        Auth::loginUsingId($id, true);
        Session::put('returnToAdmin', $user->id);

        return redirect()->route('dashboard');



    }
    public function showLoginAdmin()
    {

        // $user = User::find($id);
        //dd(Session::has('returnToAdmin'));
        if (Session::has('returnToAdmin')) {
            //dd(session('returnToAdmin'));
            Auth::loginUsingId(session('returnToAdmin'), true);
            Session::forget('returnToAdmin');

            return redirect()->route('dashboard');
        }


    }
    public function destroyPush($id)
    {
        //

        $push = PushRequest::find($id);

        $push->delete();





        Session::flash('alert-success', 'The Push deleted.');

        return redirect()->route('admin.pushes');






    }

    public function destroyDevice($id)
    {
        //

        $device = UserDevices::find($id);

        $device->pushes()->delete();
        $device->routes()->delete();
        $device->delete();




        Session::flash('alert-success', 'The device deleted.');

        return redirect()->route('admin.devices');






    }
    public function destroyApp($id)
    {
        //

        $app = UserApp::find($id);

        $app->pushRequests()->delete();
        $app->delete();




        Session::flash('alert-success', 'The app deleted.');

        return redirect()->route('admin.apps');






    }











    public function destroy($id)
    {
        //

        $user = User::find($id);



        $user->profile()->delete();
        $user->devices()->delete();
        $user->notifications()->delete();
        $user->app()->delete();
        $user->logins()->delete();
        $user->role()->delete();
        $user->delete();



        Session::flash('alert-success', 'The user deleted.');

        return redirect()->route('admin.users');






    }
}

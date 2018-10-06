<?php

namespace PushAuth\Http\Controllers\Dashboard;

use Carbon\Carbon;
use File;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\PushRequest;
use PushAuth\PushRoutes;
use PushAuth\User;
use PushAuth\UserApp;
use PushAuth\UserDevices;
use Session;
use Storage;
use Validator;
use Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use SEO;
use SEOMeta;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        

        return view('dashboard.app.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user();
        if (($user->plan->plan->name == 'FREE') && ($user->app->count() >= $user->plan->limits->where('key', 'apps')->first()->value)) {
            return abort(404);
        }


        SEO::setTitle('New application');

        return view('dashboard.app.create');
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
        //if ($request->ip_mask) {

        //}

        $user = Auth::user();


        if (($user->plan->plan->name == 'FREE') && ($user->app->count() >= $user->plan->limits->where('key', 'apps')->first()->value)) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), [
            'name'    => 'required|min:2|max:24',
            'about'   => 'required|min:8',
            'app_img' => 'mimes:jpeg,png|max:1024',
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


            } else {
                $file_name = Null;
            }

//$img;


            $userApp = UserApp::create([
                'name'        => $request->name,
                'about'       => $request->about,
                'urlhash'     => str_random(32),
                'user_id'     => $user->id,
                'status'      => 'enable',
                'url'         => $url,
                'ip_mask'     => $ipmask,
                'img'         => $file_name,
                'public_key'  => str_random(32),
                'private_key' => str_random(32),

            ]);

            $userApp->hook()->create([
                'hash' => str_random(32),
            ]);


            $data = [
                'app' => $userApp,
            ];


            return view('dashboard.app.created')->with($data);

        }

    }

    public function showDevicesAjax($id, Request $request)
    {


        $dataArr = [];
        $orderColumn = $request->order['0']['column'] + 1;
        $orderDir = $request->order['0']['dir'];


        $app = UserApp::where('urlhash', $id)->firstOrFail();

        $pr = PushRequest::where('app_id', $app->id)->get();

        $prArr = $pr->lists('id')->toArray();

        $query = UserDevices::query();


        $devID = $pr->lists('device_id')->toArray();
        $devID = array_unique($devID);

        $devRoutes = PushRoutes::whereIn('req_id', $prArr)->lists('device_id')->toArray();
        $devRoutes = array_unique($devRoutes);
        $devRoutes = array_filter($devRoutes, function ($var) {
            return !is_null($var);
        });

        $devID = array_unique(array_merge($devID, $devRoutes));
        //dd($devID);
        //$devices = UserDevices::whereIn('id', $devID)->take(5)->get();


        $query->whereIn('id', $devID);


        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $query->where(function ($query) use ($searchSlug) {
                return $query
                    ->where('uuid', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhereHas('user', function ($q) use ($searchSlug) {
                        return $q->where('email', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('name', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhereHas('profile', function ($q) use ($searchSlug) {
                                return $q->where('first_name', 'LIKE', '%' . $searchSlug . '%')
                                    ->orWhere('last_name', 'LIKE', '%' . $searchSlug . '%')
                                    ->orWhere('company', 'LIKE', '%' . $searchSlug . '%')
                                    ->orWhere('tel', 'LIKE', '%' . $searchSlug . '%')
                                    ->orWhere('website', 'LIKE', '%' . $searchSlug . '%');
                            });
                    })
                    ->orWhere('token', 'LIKE', '%' . $searchSlug . '%');

            })
                ->get();
        } else {
            $query->get();
        }


        $data = $query->get();
        $dataCount = $data->count();


        foreach ($data as $item) {

            //$itemStatus='';


            if ($item->status == 'enable') {
                $itemStatus = '<span class=\'label label-normal\'>enable</span>';
            } else {
                $itemStatus = '<span class=\'label label-critical\'>disable</span>';
            }


            array_push($dataArr,
                ['1'           => str_limit($item->uuid, 6, '<strong>XXX</strong>') . '</a>',
                 '2'           => $item->user->email,
                 '3'           => $item->pushes->count(),
                 '4'           => "Name: ".$item->name ." <br>
                                 Vendor: ".$item->vendor." <br>
                                 OS: ".$item->os_detail." ",
                 '5'           => $itemStatus,
                 "DT_RowClass" => null,
                ]);
        }


        $dataCollect = collect($dataArr);


        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        } else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }


        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();


        $dataRes = ['draw'            => intval($request->draw),
                    'recordsTotal'    => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data'            => $dataArr,

        ];

        return response()->json($dataRes);


    }


    public function showDevices($id)
    {
        $user = Auth::user();
        try {
            $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
            Session::flash('alert-warning', 'The App was not found.');

            return redirect()->route('appList');
        }

        SEO::setTitle('Application Devices - ' . $app->name);

        $pr = PushRequest::where('app_id', $app->id)->get();
        $prArr = $pr->lists('id')->toArray();

        $devID = $pr->lists('device_id')->toArray();
        $devID = array_unique($devID);

        $devRoutes = PushRoutes::whereIn('req_id', $prArr)->lists('device_id')->toArray();
        $devRoutes = array_unique($devRoutes);
        $devRoutes = array_filter($devRoutes, function ($var) {
            return !is_null($var);
        });

        $devID = array_unique(array_merge($devID, $devRoutes));


        $devices = UserDevices::whereIn('id', $devID)->take(5)->get();

        $data = [
            'app'     => $app,
            'devices' => $devices,
        ];

        return view('dashboard.app.devices')->with($data);
    }


    public function showClientsAjax($id, Request $request)
    {


        $dataArr = [];
        $orderColumn = $request->order['0']['column'] + 1;
        $orderDir = $request->order['0']['dir'];


        $query = User::query();

        //$query->();

        $app = UserApp::where('urlhash', $id)->firstOrFail();


        $pr = PushRequest::where('app_id', $app->id)->get();
        $prArr = $pr->lists('id')->toArray();

        $devID = $pr->lists('device_id')->toArray();
        $devID = array_unique($devID);

        $devices = UserDevices::whereIn('id', $devID)->lists('user_id')->toArray();
        $uidArr = array_unique($devices);

        $clientRoutes = PushRoutes::whereIn('req_id', $prArr)->lists('client_id')->toArray();
        $clientRoutes = array_filter($clientRoutes, function ($var) {
            return !is_null($var);
        });
        $clientRoutes = array_unique($clientRoutes);

        $uidArr = array_unique(array_merge($uidArr, $clientRoutes));

        $query->whereIn('id', $uidArr);


        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $query->where('email', 'LIKE', '%' . $searchSlug . '%')
                ->orWhere('name', 'LIKE', '%' . $searchSlug . '%')
                ->orWhereHas('profile', function ($q) use ($searchSlug) {
                    return $q->where('first_name', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhere('company', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhere('tel', 'LIKE', '%' . $searchSlug . '%')
                        ->orWhere('website', 'LIKE', '%' . $searchSlug . '%');
                })
                ->get();
        } else {
            $query->get();
        }

        $data = $query->get();
        $dataCount = $data->count();
//dd($data->all());


        foreach ($data as $item) {
            if ($item->status == 'enable') {
                $status = "<label class=\"label label-success\">enable</label>";
            } elseif ($item->status == 'disable') {
                $status = "<label class=\"label label-danger\">disable</label>";
            }


            array_push($dataArr, [
                    '1'           => $item->email,
                    '2'           => $item->devices->count(),
                    '3'           => $status,
                    "DT_RowClass" => null,

                ]

            );


        }


        $dataCollect = collect($dataArr);


        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        } else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }


        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();


        $dataRes = ['draw'            => intval($request->draw),
                    'recordsTotal'    => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data'            => $dataArr,

        ];

        return response()->json($dataRes);


    }


    public function showRoutesAjax(Request $request, $id)
    {


        $user = Auth::user();
        $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();


        $dataArr = [];
        $orderColumn = $request->order['0']['column'] + 1;
        $orderDir = $request->order['0']['dir'];

        $query = PushRequest::query();
        $query->where('app_id', $app->id);
        $query->where('mode', 'route');


        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $query->where(function ($query) use ($searchSlug) {
                return $query
                    ->where('hash', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhereHas('routes', function ($q) use ($searchSlug) {
                        return $q->whereHas('device', function ($q) use ($searchSlug) {
                            return $q->where('uuid', 'LIKE', '%' . $searchSlug . '%')
                                ->orWhere('token', 'LIKE', '%' . $searchSlug . '%')
                                ->orWhere('os', 'LIKE', '%' . $searchSlug . '%')
                                ->orWhereHas('user', function ($q) use ($searchSlug) {
                                    return $q->where('name', 'LIKE', '%' . $searchSlug . '%')
                                        ->orWhere('email', 'LIKE', '%' . $searchSlug . '%');
                                });

                        })->orWhereHas('client', function ($q) use ($searchSlug) {
                            return $q->whereHas('profile', function ($q) use ($searchSlug) {
                                return $q->where('first_name', $searchSlug)
                                    ->orWhere('last_name', 'LIKE', '%' . $searchSlug . '%')
                                    ->orWhere('company', 'LIKE', '%' . $searchSlug . '%')
                                    ->orWhere('tel', 'LIKE', '%' . $searchSlug . '%')
                                    ->orWhere('website', 'LIKE', '%' . $searchSlug . '%');
                            })->orWhere('email', $searchSlug);
                        });

                    });
            });
        } else {
            $query->with('app', 'device', 'routes');
        }


        $data = $query->get();
        $dataCount = $data->count();


        foreach ($data as $item) {

            //$itemStatus='';


            $clientAndDevices = '-';
            $clientAndDevicesArr = [];

            if ($item->routes->count() > 0) {

                foreach ($item->routes as $route) {


                    if ($route->answer == 'true') {
                        $route->answer = '<span class=\'label label-open\'>YES</span>';
                    } elseif ($route->answer == 'false') {
                        $route->answer = '<span class=\'label label-closed\'>NO</span>';
                    } else {
                        if ($item->mode != 'code') {
                            $route->answer = 'no answer';
                        } else {
                            $route->answer = '-';
                        }

                    }


                    array_push($clientAndDevicesArr, ['order'  => $route->order,
                                                      'client' => $route->client->email,
                                                      'device' => str_limit($route->device->uuid, 6, '<strong>XXX</strong>'),
                                                      'status' => $route->status,
                                                      'answer' => $route->answer]);
                }

            }


            //$clientAndDevicesArr=collect($clientAndDevicesArr)->sortByDesc('order')->toArray();

            //dd(collect($clientAndDevicesArr)->sortBy('order')->values()->all());
            $clientAndDevicesArr = collect($clientAndDevicesArr)->sortBy('order')->values()->all();

            //dd($item->routes->unique('client_id')->lists('client_id')->toArray());

            $clientsArr = $item->routes->unique('client_id')->lists('client_id')->toArray();

            $answer = 'no answer';


            if ($item->answer == 'true') {
                $answer = '<span class=\'label label-open\'>YES</span>';
            } elseif ($item->answer == 'false') {
                $answer = '<span class=\'label label-closed\'>NO</span>';


            } elseif ($item->answer == Null) {

                $successCount = 0;
                $failCount = 0;
                foreach ($clientsArr as $c) {
                    if ($item->routes()->where('client_id', $c)->where('answer', 'true')->count() > 0) {
                        $successCount++;
                    }
                    if ($item->routes()->where('client_id', $c)->where('answer', 'false')->count() > 0) {
                        $failCount++;
                    }
                }

                if (count($clientsArr) == $successCount) {
                    $answer = '<span class=\'label label-open\'>YES</span>';
                }
                if (count($clientsArr) == $failCount) {
                    $answer = '<span class=\'label label-closed\'>NO</span>';
                }
            }


            array_push($dataArr,
                ['1' => str_limit($item->hash, 6, '<strong>XXX</strong>'),
                 '2' => $item->routes->unique('client_id')->lists('client_id')->count(),
                 '3' => $item->routes->unique('device_id')->lists('device_id')->count(),
                 '4' => $answer,
                 '5' => $item->created_at->toDateTimeString(),

                 'c'           => $clientAndDevicesArr,
                 /*                 '7'           => 'show',
                                  '8'           => 'del',*/
                 "DT_RowClass" => null,
                ]);
        }


        $dataCollect = collect($dataArr);


        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        } else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }


        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();


        $dataRes = ['draw'            => intval($request->draw),
                    'recordsTotal'    => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data'            => $dataArr,

        ];

        return response()->json($dataRes);


    }


    public function showRoutes($id)
    {
        $user = Auth::user();
        try {
            $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
            Session::flash('alert-warning', 'The App was not found.');

            return redirect()->route('appList');
        }

        SEO::setTitle('Application push routes - ' . $app->name);


        $data = [
            'app' => $app,

        ];

        return view('dashboard.app.routes')->with($data);


    }


    public function showClients($id)
    {
        $user = Auth::user();
        try {
            $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
            Session::flash('alert-warning', 'The App was not found.');

            return redirect()->route('appList');
        }

        SEO::setTitle('Application clients - ' . $app->name);

        $pr = PushRequest::where('app_id', $app->id)->get();

        $prArr = $pr->lists('id')->toArray();

        $clientsRoutes = PushRoutes::whereIn('req_id', $prArr)->lists('client_id')->toArray();
        $clientsRoutes = array_unique($clientsRoutes);
        $clientsRoutes = array_filter($clientsRoutes, function ($var) {
            return !is_null($var);
        });

        $devID = $pr->lists('device_id')->toArray();
        $devID = array_unique($devID);

        $devices = UserDevices::whereIn('id', $devID)->lists('user_id')->toArray();
        $devices = array_merge($devices, $clientsRoutes);
        $uidArr = array_unique($devices);

        $clients = User::whereIn('id', $uidArr)->get();

        $data = [
            'app'     => $app,
            'clients' => $clients,
        ];

        return view('dashboard.app.clients')->with($data);
    }

    public function showHooks($id)
    {
        $user = Auth::user();
        try {
            $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
            Session::flash('alert-warning', 'The App was not found.');

            return redirect()->route('appList');
        }

        SEO::setTitle('Application Hooks - ' . $app->name);


        ($app->hook->qr_flag == 'true') ? $qr_flag = true : $qr_flag = false;
        ($app->hook->push_flag == 'true') ? $push_flag = true : $push_flag = false;
        ($app->hook->timeout_flag == 'true') ? $timeout_flag = true : $timeout_flag = false;

        ($app->hook->status == 'enable') ? $status = true : $status = false;

        $data = [
            'app'          => $app,
            'qr_flag'      => $qr_flag,
            'push_flag'    => $push_flag,
            'timeout_flag' => $timeout_flag,
            'status'       => $status,
        ];

        return view('dashboard.app.hooks')->with($data);
    }


    public function showSettings($id)
    {
        $user = Auth::user();
        try {
            $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
            Session::flash('alert-warning', 'The App was not found.');

            return redirect()->route('appList');
        }

        SEO::setTitle('Application Settings - ' . $app->name);

        ($app->status == 'enable') ? $app->status = true : $app->status = false;

        $data = [
            'app' => $app,
        ];

        return view('dashboard.app.settings')->with($data);
    }


    public function showPushes($id)
    {
        $user = Auth::user();
        try {
            $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
            Session::flash('alert-warning', 'The App was not found.');

            return redirect()->route('appList');
        }

        SEO::setTitle('Application Pushes - ' . $app->name);


        $data = [
            'app'    => $app,
            'pushes' => $app->pushRequests,
        ];

        return view('dashboard.app.pushes')->with($data);
    }


    public function showPushesAjax($id, Request $request)
    {

        $user = Auth::user();
        $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();


        $dataArr = [];
        $orderColumn = $request->order['0']['column'] + 1;
        $orderDir = $request->order['0']['dir'];

        $query = PushRequest::query();
        $query->where('app_id', $app->id);
        $query->whereIn('mode', ['code', 'push', 'qr']);


        if ($request->search['value']) {
            $searchSlug = $request->search['value'];

            $query->where(function ($query) use ($searchSlug) {
                return $query
                    ->where('hash', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhere('mode', 'LIKE', '%' . $searchSlug . '%')
                    ->orWhereHas('device', function ($q) use ($searchSlug) {
                        return $q->where('uuid', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('token', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhere('os', 'LIKE', '%' . $searchSlug . '%')
                            ->orWhereHas('user', function ($q) use ($searchSlug) {
                                return $q->where('name', 'LIKE', '%' . $searchSlug . '%');
                            });
                    });

            });
        } else {
            $query->with('app', 'device');
        }


        $data = $query->get();
        $dataCount = $data->count();


        foreach ($data as $item) {

            //$itemStatus='';


            if ($item->status == 'enable') {
                $itemStatus = '<span class=\'label label-normal\'>enable</span>';
            } else {
                $itemStatus = '<span class=\'label label-critical\'>disable</span>';
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
                    } else {
                        $answer = '<span class=\'label label-closed\'>NO</span>';
                    }
                }
            } elseif ($item->mode == 'qr') {
                $mode = '<span class=\'label label-normal\'>QR code</span>';
                if ($item->response_code == Null) {
                    $answer = '<span class=\'label label-progress\'>not using</span>';
                } else {
                    $answer = '<span class=\'label label-open\'>used</span>';
                }

            }


            if ($item->device) {
                if ($item->device->os == 'ios') {
                    $devOS = '<span class=\'fa fa-apple\'></span>';
                } elseif ($item->device->os == 'android') {
                    $devOS = '<span class=\'fa fa-android\'></span>';
                }

                $clientDevice = $item->device->user->email . ' / ' . $devOS;

                $clientDevice = $clientDevice . "<br>

                                 Name: ".$item->device->name ." <br>
                                 Vendor: ".$item->device->vendor." <br>
                                 OS: ".$item->device->os_detail."
                
                
                " ;

            } else {
                $clientDevice = '-';
            }


            array_push($dataArr,
                ['1' => str_limit($item->hash, 6, '<strong>XXX</strong>'),
                 '2' => $clientDevice,
                 '3' => $mode,
                 '4' => $answer,

                 '5'           => $item->created_at->toDateTimeString(),
                 /*                 '7'           => 'show',
                                  '8'           => 'del',*/
                 "DT_RowClass" => null,
                ]);
        }


        $dataCollect = collect($dataArr);


        if ($orderDir == 'desc') {
            $dataCollect = $dataCollect->sortByDesc($orderColumn);
        } else {
            $dataCollect = $dataCollect->sortBy($orderColumn);
        }


        $dataArr = $dataCollect->splice($request->start, $request->length)->values()->all();


        $dataRes = ['draw'            => intval($request->draw),
                    'recordsTotal'    => $dataCount,
                    'recordsFiltered' => $dataCount,
                    'data'            => $dataArr,

        ];

        return response()->json($dataRes);


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = Auth::user();

        try {
            $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
            Session::flash('alert-warning', 'The App was not found.');

            return redirect()->route('appList');
        }

        SEO::setTitle('Application - ' . $app->name);

        $pr = PushRequest::where('app_id', $app->id)->get();

        $prArr = $pr->lists('id')->toArray();

        $devRoutes = PushRoutes::whereIn('req_id', $prArr)->lists('device_id')->toArray();

        $devices = $pr->lists('device_id')->toArray();


        $devices = array_unique(array_merge($devRoutes, $devices));

        $devices = array_filter($devices, function ($var) {
            return !is_null($var);
        });

        $clients = UserDevices::whereIn('id', $devices)->lists('user_id')->toArray();

        $data = [
            'app'     => $app,
            'devices' => count($devices),
            'clients' => count(array_unique($clients)),
        ];

        return view('dashboard.app.show')->with($data);


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
        SEO::setTitle('Edit application');
        $user = Auth::user();
        try {
            $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
            Session::flash('alert-warning', 'The App was not found.');

            return redirect()->route('appList');
        }


        ($app->status == 'enable') ? $app->status = true : $app->status = false;

        $data = [
            'app' => $app,
        ];

        return view('dashboard.app.edit')->with($data);


    }

    public function storeHooksTest(Request $request, $id)
    {
        dd($request->all());

    }


    public function updateHooks(Request $request, $id)
    {
        $user = Auth::user();
//dd($request->all());
        $validator = Validator::make($request->all(), [
            'payload_url' => 'required|url',
            //'retry'=>'in:0,1,2,3,4,5',
            //'retry_code'=>'required_if:retry,1,2,3,4,5'
        ]);

        if ($validator->fails()) {

            $request->session()->flash('alert-warning', 'Validating error.');

            return back()->withErrors($validator)->withInput();;


        } else {


            try {
                $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();
            } catch (ModelNotFoundException $e) {

                Session::flash('alert-warning', 'The App was not found.');

                return redirect()->route('appList');
            }


            if ($request->btn == 'test') {

                $client = new Client();

                /*                $res = $client->request('POST', 'https://api.github.com/user', [
                                    'auth' => ['user', 'pass']
                                ]);

                                dd($res->getStatusCode());*/
                /*                "hook":{
                                    "type":"App",
                    "id":11,
                    "active":true,
                    "events":["pull_request"],
                    "app_id":37,
                    ...
                  }*/


                $dataHook = base64_encode(json_encode([
                    'req_hash'           => 'test-data',
                    'app_public_key'     => $app->public_key,
                    'app_name'           => $app->name,
                    'client_email'       => 'test-data',
                    'client_platform'    => 'test-data',
                    'response_timestamp' => Carbon::now()->timestamp,
                ]));

                $testData = ['hook' => [
                    'event'     => 'test',
                    'timestamp' => Carbon::now()->timestamp,
                    'data'      => $dataHook,
                    'signature' => base64_encode(hash_hmac('sha256', $dataHook, $app->private_key, true)),
                ]];
                $resTest['data'] = $testData;
                $resTest['ctype'] = $request->ctype;


                if ($request->ctype == 'form') {

                    $dataArr['form_params'] = $testData;

                } elseif ($request->ctype == 'json') {

                    $dataArr['json'] = $testData;

                }
//dd($dataArr);
                $dataArrRes = [
                    'allow_redirects' => false,
                    'connect_timeout' => 3.14,
                    'headers'         => [
                        'User-Agent'       => 'pushauth/hooks',
                        'X-PushAuth-Event' => 'test',
                    ],


                ];
                $dataArrRes = array_merge($dataArrRes, $dataArr);
                //dd($dataArrRes);
                try {
                    $response = $client->request('POST', $request->payload_url, $dataArrRes);
                    $responseArr['code'] = $response->getStatusCode();
                    $responseArr['phrase'] = $response->getReasonPhrase();
                } catch (ConnectException $e) {


                    $resTest['code'] = '';
                    $resTest['phrase'] = $e->getMessage();

                    Session::flash('test-result-error', $resTest);
                    Session::flash('alert-danger', 'The App hooks was tested with error.');

                    return redirect()->route('app.show.hooks', $app->urlhash);


                } catch (RequestException $e) {
                    $response = $e->getResponse();

                    $resTest['code'] = $response->getStatusCode();
                    $resTest['phrase'] = $response->getReasonPhrase();

                    Session::flash('test-result-error', $resTest);
                    Session::flash('alert-danger', 'The App hooks was tested with error.');

                    return redirect()->route('app.show.hooks', $app->urlhash);


                }


                $resTest['code'] = $responseArr['code'];
                $resTest['phrase'] = $responseArr['phrase'];

                Session::flash('test-result-ok', $resTest);
                Session::flash('alert-success', 'The App hooks was tested and we automatic save configuration.');


                ($request->qr_flag) ? $qr_flag = 'true' : $qr_flag = 'false';
                ($request->push_flag) ? $push_flag = 'true' : $push_flag = 'false';
                ($request->timeout_flag) ? $timeout_flag = 'true' : $timeout_flag = 'false';

                ($request->status) ? $status = 'enable' : $status = 'disable';

                $app->hook()->update([
                    'payload_url'  => $request->payload_url,
                    'type'         => $request->ctype,
                    'qr_flag'      => $qr_flag,
                    'push_flag'    => $push_flag,
                    'timeout_flag' => $timeout_flag,
                    'status'       => $status,
                ]);


                return redirect()->route('app.show.hooks', $app->urlhash);


            } elseif ($request->btn == 'save') {
                Session::flash('alert-success', 'The App hooks was updated.');


                ($request->qr_flag) ? $qr_flag = 'true' : $qr_flag = 'false';
                ($request->push_flag) ? $push_flag = 'true' : $push_flag = 'false';
                ($request->timeout_flag) ? $timeout_flag = 'true' : $timeout_flag = 'false';

                ($request->status) ? $status = 'enable' : $status = 'disable';

                $app->hook()->update([
                    'payload_url'  => $request->payload_url,
                    'type'         => $request->ctype,
                    'qr_flag'      => $qr_flag,
                    'push_flag'    => $push_flag,
                    'timeout_flag' => $timeout_flag,
                    'status'       => $status,
                ]);


                return redirect()->route('app.show.hooks', $app->urlhash);
            }


        }

    }


    public function updateKeys(Request $request)
    {

        $user = Auth::user();
        try {
            $app = UserApp::where('urlhash', $request->app_hash)->where('user_id', $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
            Session::flash('alert-warning', 'The App was not found.');
            $data = [
                'pk1' => 'no valid key',
                'pk2' => 'no valid key too',
            ];

            return response()->json($data);
        }
        $pk1 = str_random(32);
        $pk2 = str_random(32);

        $app->update([
            'public_key'  => $pk1,
            'private_key' => $pk2,
        ]);


        $data = [
            'pk1' => $pk1,
            'pk2' => $pk2,
        ];

        return response()->json($data);


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

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name'    => 'required|min:2|max:24',
            'about'   => 'required|min:8',
            'app_img' => 'mimes:jpeg,png|max:1024',
        ]);

        if ($validator->fails()) {

            $request->session()->flash('alert-warning', 'Validating error.');

            //return back()->withErrors($validator)->withInput();
            return back()->withErrors($validator)->withInput();;


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
                $app = UserApp::where('urlhash', $id)->where('user_id', $user->id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
                Session::flash('alert-warning', 'The App was not found.');

                return redirect()->route('appList');
            }

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
                if ($app->img) {
                    $storage->delete($user->id . '/' . $app->img);
                }


            } else {
                $file_name = $app->img;
            }

//$img;

            ($request->status == 'enable') ? $status = 'enable' : $status = 'disable';


            $app->update([
                'name'    => $request->name,
                'about'   => $request->about,
                'urlhash' => str_random(32),
                //'user_id'=>$user->id,
                'status'  => $status,
                'url'     => $url,
                'ip_mask' => $ipmask,
                'img'     => $file_name,
                //'public_key'=>str_random(32),
                //'private_key'=>str_random(32),

            ]);


            Session::flash('alert-success', 'The App was updated.');

            return redirect()->route('app.show.settings', $app->urlhash);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($urlhash)
    {
        //

        $user = Auth::user();
        try {
            $app = UserApp::where('urlhash', $urlhash)->where('user_id', $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            //$request->session()->flash('alert-warning', 'Ошибка, заполните все поля.');
            Session::flash('alert-warning', 'The App was not found.');

            return redirect()->route('appList');
        }

        $app->hook()->delete();

        $app->delete();

        Session::flash('alert-success', 'The App was deleted.');

        return redirect()->route('appList');
    }
}

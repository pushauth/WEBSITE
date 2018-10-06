<?php

namespace PushAuth\Http\Controllers\Support;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Image;
use Mail;
use PushAuth\Files;
use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\Ticket;
use PushAuth\User;
use PushAuth\UserApp;
use SEO;
use Session;
use Storage;
use Validator;


class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        SEO::setTitle('Support');
        return view('dashboard.support.index');
    }
    public function indexApi()
    {
        //
        SEO::setTitle('API');
        return view('dashboard.support.indexApi');
    }

    public function indexLibraries()
    {
        //
        //
        //
        return redirect('https://github.com/pushauth');
        //SEO::setTitle('Libraries');
        //return view('dashboard.support.indexLibraries');
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

    public function storeComment(Request $request, $id)
    {


        $user = Auth::user();

        try {
            $ticket = Ticket::where('url_hash', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            Session::flash('alert-warning', 'The ticket with ID: ' . $id . ' was not found.');

            return redirect()->route('support.ticket.index');
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



            Session::flash('alert-success', 'The comment was added!');

            return redirect()->route('support.ticket.show', $ticket->url_hash);









        }





    }


    public function storeCloseTicket($id)
    {
        $user = Auth::user();

        try {
            $ticket = Ticket::where('url_hash', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            Session::flash('alert-warning', 'The ticket with ID: ' . $id . ' was not found.');

            return redirect()->route('support.ticket.index');
        }


        $ticket->update([
            'status'=>'close'
        ]);


        Session::flash('alert-success', 'The ticket was closed!');

        return redirect()->route('support.ticket.show',$ticket->url_hash);



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
        $user = Auth::user();


        $validator = Validator::make($request->all(), [
            'req_type'    => 'required',
            'subj'   => 'required|min:8|max:256',
            'body' => 'required|min:8',
        ]);
        $validator->setAttributeNames([
            'req_type'=>'Request type',
            'subj'=>'Subject',
            'body'=>'Question'
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



$appId=null;
if ($request->app_hash) {
    $appID=UserApp::where('urlhash',$request->app_hash)->first()->id;
}








            $ticket = Ticket::create([
                'author_id'=>$user->id,
                'status'=>'open',
                'subject'=>$request->subj,
                'text'=>$request->body,
                'type'=>$request->req_type,
                'app_id'=>$appID,
                'error_msg'=>$request->error_msg,
                'issue_dt'=>Carbon::parse($request->timeline)->toDateTimeString(),
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
                        'target_id'   => $ticket->id,
                        'target_type' => 'ticket',
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


            Mail::queue(['text' => 'emails.ticket.create2client'], $dataMail, function ($message) use ($user) {
                $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                $message->subject('PushAuth Support Service');
                $message->to($user->email);
            });




            Session::flash('alert-success', 'The ticket was created!');

            return redirect()->route('support.ticket.index');



        }

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

       $ticket = Ticket::where('url_hash', $id)->first();

        SEO::setTitle('Support - request #'.str_limit($ticket->url_hash,6,''));



        $data=[
            'ticket'=>$ticket
        ];

        return view('dashboard.support.ticket.show')->with($data);



    }

public function showDownloadImage($id) {
    $fileHash = explode('.', $id);
    $fileHash = $fileHash[0];

    $file = Files::whereHash($fileHash)->firstOrFail();

    $imgPath = storage_path('users/' . $file->user_id . '/' . $file->hash . '.' . $file->extension);

    $img = Image::cache(function ($image) use ($imgPath) {
        //global $imgPath;
        $image->make($imgPath)->fit(200, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }, 10, true);

    return $img->response();

}
    public function showDownload($id)
    {
        $file = Files::whereHash($id)->firstOrFail();
        $imgPath = storage_path('users/' . $file->user_id . '/' . $file->hash . '.' . $file->extension);
        $headers = ['Content-Type' => $file->mime];

        return response()->download($imgPath, $file->name, $headers);
    }



    public function createTicket(Request $request)
    {
        //

/*
        $user = User::find(2);

        dd($user->app()->lists('name','urlhash')->toArray());*/

$user = Auth::user();
        if ($user->tickets()->where('created_at', '>=', Carbon::now()->subMinutes(30)->toDateTimeString())->count() > 0 ) {

            $request->session()->flash('alert-warning', 'Request limit is 1 ticket in 30 minutes. Please create ticket later.');
            return back();

        }



        SEO::setTitle('Support - request');
        return view('dashboard.support.ticket.create');
    }




    public function indexTicket()
    {
        //
        SEO::setTitle('Support - all requests');
        return view('dashboard.support.ticket.index');
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
    public function destroy($id)
    {
        //
    }
}

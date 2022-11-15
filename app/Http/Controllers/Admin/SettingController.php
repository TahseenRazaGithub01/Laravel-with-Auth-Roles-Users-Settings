<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Setting;
use App\Models\Logs;
use App\Http\Controllers\Controller;

use App\Helpers\helper as Helper;

use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Validation\Rule;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

// use Image;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->middleware('permission:setting-list|setting-create|setting-edit|setting-delete', ['only' => ['index','store']]);
        $this->middleware('permission:setting-create', ['only' => ['create','store']]);
        $this->middleware('permission:setting-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:setting-delete', ['only' => ['destroy']]);

    }
    public function index()
    {
        $search = request('search');

        if (!empty($search)) {
            $record = Setting::where('settings.contact_email', 'like', '%'.$search.'%')
                ->orWhere('settings.contact_number', 'like', '%'.$search.'%')
                ->orWhere('settings.contact_whatsapp', 'like', '%'.$search.'%')
                ->orderBy('settings.id','DESC')
                ->get();
                return view('settings.index', compact('record') );
        }else{
            $record = Setting::whereId(1)->get();

            if($record != false){
                return view('settings.index', compact('record') );
            }else{
                abort(404);
            }
        }


        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('settings.add');
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

        $record = Setting::whereId($id)->first();

        $logs = Logs::get_logs_details(Setting::getTableName(), $id);

        if($record != false){
            return view('settings.edit', compact('record','logs'));
        }else{
            abort(404);
        }
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
        $setting = Setting::find($id);

        $setting->update($request->all());

        if(isset($request['header_logo'])){

            $header_logo = Helper::upload_image($request->file('header_logo'));

            $data = array(
                'header_logo'        => $header_logo,
            );

            $setting->update($data);

        }

        if(isset($request['footer_logo'])){

            $footer_logo = Helper::upload_image($request->file('footer_logo'));

            $data = array(
                'footer_logo'        => $footer_logo,
            );

            $setting->update($data);

        }

        Logs::add_log(Setting::getTableName(), $id, $request->all, 'edit', 1);
        return redirect()->route('settings.index')->with('success','Record Updated !');

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

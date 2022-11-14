<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Logs;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use Illuminate\Validation\Rule;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);

    }
	
    public function index()
    {
        $search = request('search');

        if (!empty($search)) {
            $users = User::where('users.name', 'like', '%'.$search.'%')
                ->orWhere('users.email', 'like', '%'.$search.'%')
                ->orderBy('users.id','DESC')
                ->paginate(10);
        } else {
            $users = User::orderBy('users.id','DESC')->paginate(15);
        }

        return view('users.index', compact('users') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.add', compact('roles') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {

        $data = [
            'name'  => $request->name,
            'email'  => $request->email,
            'password' => Hash::make($request->password),
        ];

        $record = User::create( $data );
        $record->assignRole($request->roles); // Add new line for Role

        Logs::add_log(User::getTableName(), $record->id, $data, 'add', '');

        return redirect()->route('users.index')->with('success','Record Added !');
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
        $record = User::whereId($id)->first();

        $logs = Logs::get_logs_details(User::getTableName(), $id);

        $roles = Role::pluck('name','name')->all();
        $userRole = $record->roles->pluck('name','name')->all();

        if($record != false){
            return view('users.edit', compact('record','logs', 'roles', 'userRole'));
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

        $this->validate($request, [
            'name' => 'required',
            'roles' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ]
        ]);

        $user = User::find($id);
        $input = $request->all();

        if($request->password == null || $request->password == NULL || $request->password == ''){
            $input = $request->except(['password']);
        }else{
            $input['password'] = Hash::make($input['password']);
        }

        $user->update($input);

        DB::table('model_has_roles')->where('model_id',$id)->delete(); // check this working or not 
        $user->assignRole($request->input('roles')); // if $request->roles ; for input //

        Logs::add_log(User::getTableName(), $id, $input, 'edit', 1);
        return redirect()->route('users.index')->with('success','Record Updated !');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
 
        return redirect()->route('users.index')->with('success', 'Record Deleted !');
    }
}

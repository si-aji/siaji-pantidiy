<?php

namespace App\Http\Controllers\Dashboard;

use DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $options;
    public function __construct()
    {
        $this->options = [
            'pages' => ['list', 'create', 'edit', 'delete'],
            'post' => ['list', 'create', 'edit', 'delete'],
            'category' => ['list', 'create', 'edit'],
            'keyword' => ['list', 'create', 'edit'],
            'panti_list' => ['list', 'create', 'edit'],
            'panti_liputan' => ['list', 'create', 'edit'],
            'location_provinsi' => ['list', 'create', 'edit'],
            'location_kabupaten' => ['list', 'create', 'edit'],
            'location_kecamatan' => ['list', 'create', 'edit'],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('content.dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = $this->options;
        return view('content.dashboard.roles.create', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'roles_name' => ['required', 'string', 'max:191', 'unique:roles,name'],
            'permission.*' => ['nullable']
        ]);

        $role = new Role;
        $role->name = $request->roles_name;
        $role->save();

        foreach($request->permission as $value){
            $check = Permission::where('name', $value)->first();
            $store = null;

            if(empty($check)){
                $store = Permission::create([
                    'name' => $value
                ]);
            }
        }

        // Assign Permission
        $role->syncPermissions($request->permission);

        return redirect()->route('dashboard.roles-setting.index')->with([
            'action' => 'Store',
            'message' => 'Role successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $old_options = Permission::join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where('role_has_permissions.role_id', $id)
            ->get()->pluck('name');
        return view('content.dashboard.roles.show', compact('role', 'old_options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $options = $this->options;
        $role = Role::findOrFail($id);
        $old_options = Permission::join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where('role_has_permissions.role_id', $id)
            ->get()->pluck('name');

        return view('content.dashboard.roles.edit', compact('role', 'options', 'old_options'));
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
        $request->validate([
            'roles_name' => ['required', 'string', 'max:191', 'unique:roles,name,'.$id],
            'permission.*' => ['nullable']
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->roles_name;
        $role->save();

        foreach($request->permission as $value){
            $check = Permission::where('name', $value)->first();
            $store = null;

            if(empty($check)){
                $store = Permission::create([
                    'name' => $value
                ]);
            }
        }

        // Assign Permission
        $role->syncPermissions($request->permission);

        return redirect()->route('dashboard.roles-setting.index')->with([
            'action' => 'Update',
            'message' => 'Role successfully update'
        ]);
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

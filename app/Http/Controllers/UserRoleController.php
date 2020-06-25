<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the permissions for this controller
         */
        $this->middleware('permission:user-role-list|user-role-create|user-role-edit|user-role-delete|user-role-status', ['only' => ['index','store']]);
        $this->middleware('permission:user-role-show', ['only' => ['show']]);
        $this->middleware('permission:user-role-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-role-status', ['only' => ['changeStatus']]);
        $this->middleware('permission:user-role-delete', ['only' => ['destroy']]);
    }

    /**
     * Show the index view
     * @method GET
     */
    public function index()
    {
        $userRoles = Role::all();
        return view('userRole.index', compact('userRoles'));
    }

    /**
     * Show the create view
     * @method GET
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('userRole.create', compact('permissions'));
    }

    /**
     * Show the edit view with the item information
     * @param Role $role
     * @method GET
     */
    public function edit(Role $role)
    {
        if ($role->id > 3) {
            $permissions = Permission::all();
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                ->all();
            return view('userRole.edit', compact('role', 'permissions', 'rolePermissions'));
        }

        return redirect()->route('userRole.index');
    }

    /**
     * Show the edit view with the item information
     * @param Role $role
     * @method GET
     */
    public function show(Role $role)
    {
        $permissions = Permission::orderBy('name', 'desc')->get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('userRole.show', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Receive the form information and creates the item
     * @param $request
     * @method POST
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'       => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permission' => ['required']
        ])->validate();

        $role = Role::create([
            'name'   => strtoupper($request->name),
            'status' => $request->status
        ]);

        $role->syncPermissions($request->input('permission'));

        return redirect()
            ->route('userRole.edit', $role)
            ->with('success', trans('messages.roleCreated'));
    }

    /**
     * Receive the form information and updates the item
     * @param $request
     * @param Role $role
     * @method PATCH
     */
    public function update (Request $request, Role $role)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignoreModel($role)]
        ])->validate();

        $role->update([
            'name'   => strtoupper($request->name),
            'status' => $request->status
        ]);

        $role->syncPermissions($request->input('permission'));

        return redirect()
            ->route('userRole.edit', compact('role'))
            ->with('success', trans('messages.roleUpdated'));
    }

    /**
     * Delete the item
     * @param Role $role
     * @method PATCH
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()
            ->route('userRole.index')
            ->with('success', trans('messages.roleDeleted'));
    }

    /**
     * Change the status of the item
     * @param Role $role
     * @method POST
     */
    public function changeStatus(Role $role)
    {
        $status = ($role->status == 1) ? 0 : 1;

        $role->update([
            'status' => $status
        ]);

        return redirect()
            ->route('userRole.index')
            ->with('success', trans('messages.roleUpdated'));
    }
}

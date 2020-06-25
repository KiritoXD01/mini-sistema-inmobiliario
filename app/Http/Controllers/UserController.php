<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the permissions for this controller
         */
        $this->middleware('permission:user-list|user-create|user-edit|user-delete|user-status', ['only' => ['index','store']]);
        $this->middleware('permission:user-show', ['only' => ['show']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-status', ['only' => ['changeStatus']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Show the index view
     * @method GET
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the create view
     * @method GET
     */
    public function create()
    {
        $roles = Role::where('status', true)->pluck('name')->all();
        return view('user.create', compact('roles'));
    }
}

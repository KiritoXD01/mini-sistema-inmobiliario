<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the index view
     * @method GET
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }
}

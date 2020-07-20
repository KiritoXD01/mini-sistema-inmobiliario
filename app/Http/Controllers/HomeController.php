<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $properties = Property::count();
        return view('home', compact('users', 'properties'));
    }

    /**
     * Change the application language
     * @param $language
     */
    public function changeLanguage($language)
    {
        session(['locale' => $language]);
        return redirect()->back();
    }
}

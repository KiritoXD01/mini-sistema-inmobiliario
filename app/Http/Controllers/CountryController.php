<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the permissions for this controller
         */
        $this->middleware('permission:country-list|country-create|country-edit|country-delete|country-status', ['only' => ['index','store']]);
        $this->middleware('permission:country-show', ['only' => ['show']]);
        $this->middleware('permission:country-create', ['only' => ['create','store']]);
        $this->middleware('permission:country-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:country-status', ['only' => ['changeStatus']]);
        $this->middleware('permission:country-delete', ['only' => ['destroy']]);
    }

    /**
     * Show the index view
     * @method GET
     */
    public function index()
    {
        $countries = Country::all();
        return view('country.index', compact('countries'));
    }

    /**
     * Show the create view
     * @method GET
     */
    public function create()
    {
        return view('country.create');
    }

    /**
     * Show the edit view with the item information
     * @param Country $country
     * @method GET
     */
    public function edit(Country $country)
    {
        return view('country.edit', compact('country'));
    }

    /**
     * Display the show view with the item information in readonly mode
     * @param Country $country
     * @method GET
     */
    public function show(Country $country)
    {
        return view('country.show', compact('country'));
    }
}

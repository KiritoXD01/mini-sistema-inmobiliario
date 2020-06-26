<?php

namespace App\Http\Controllers;

use App\Exports\CountryExport;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

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

    /**
     * Receive the form information and creates the item
     * @param Request $request
     * @method POST
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:countries,name'],
            'iso'  => ['required', 'string', 'max:3', 'unique:countries,iso'],
        ])->validate();

        $data               = $request->all();
        $data['iso']        = strtoupper($data['iso']);
        $data['created_by'] = auth()->user()->id;

        $country = Country::create($data);

        return redirect()
            ->route('country.edit', compact('country'))
            ->with('success', trans('messages.countryCreated'));
    }

    /**
     * Receive the form information and updates the item
     * @param $request
     * @param Country $country
     * @method PATCH
     */
    public function update(Request $request, Country $country)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('countries')->ignoreModel($country)],
            'iso'  => ['required', 'string', 'max:3', Rule::unique('countries')->ignoreModel($country)],
        ])->validate();

        $data        = $request->all();
        $data['iso'] = strtoupper($data['iso']);

        $country->update($data);

        return redirect()
            ->route('country.edit', compact('country'))
            ->with('success', trans('messages.countryUpdated'));
    }

    /**
     * Delete the item
     * @param Country $country
     * @method DELETE
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()
            ->route('country.index')
            ->with('success', trans('messages.countryDeleted'));
    }

    /**
     * Change the status of the item
     * @param Country $country
     * @method POST
     */
    public function changeStatus(Country $country)
    {
        $country = Country::find($country->id);
        $country->update([
            'status' => ($country->status) ? 0 : 1
        ]);

        return redirect()
            ->route('country.index')
            ->with('success', trans('messages.countryDeleted'));
    }

    /**
     * Verifies that the name provided upon import is unique and valid
     * @param Request $request
     * @method GET
     */
    public function checkName(Request $request)
    {
        $nameExists = Country::where('name', $request->name)->exists();
        return response()->json(['name' => $nameExists]);
    }

    /**
     * Verifies that the iso provided upon import is unique and valid
     * @param Request $request
     * @method GET
     */
    public function checkISO(Request $request)
    {
        $isoExists = Country::where('iso', $request->iso)->exists();
        return response()->json(['iso' => $isoExists]);
    }

    /**
     * import users from modal form
     * @param Request $request
     * @method POST
     */
    public function import(Request $request)
    {
        for ($i = 0; $i < count($request->name); $i++)
        {
            Country::create([
                'name' => $request->name[$i],
                'iso'  => strtoupper($request->iso[$i])
            ]);
        }

        return redirect()
            ->route('country.index')
            ->with('success', trans('messages.countryImported'));
    }

    /**
     * export users to excel file
     * @method GET
     */
    public function export()
    {
        return Excel::download(new CountryExport, 'countries.xlsx');
    }
}

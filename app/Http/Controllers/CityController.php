<?php

namespace App\Http\Controllers;

use App\Exports\CityExport;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class CityController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the permissions for this controller
         */
        $this->middleware('permission:city-list|city-create|city-edit|city-delete|city-status', ['only' => ['index','store']]);
        $this->middleware('permission:city-show', ['only' => ['show']]);
        $this->middleware('permission:city-create', ['only' => ['create','store']]);
        $this->middleware('permission:city-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:city-status', ['only' => ['changeStatus']]);
        $this->middleware('permission:city-delete', ['only' => ['destroy']]);
    }

    /**
     * Show the index view
     * @method GET
     */
    public function index()
    {
        $cities = City::all();
        $countries = Country::where('status', true)->get();
        return view('city.index', compact('cities', 'countries'));
    }

    /**
     * Show the create view
     * @method GET
     */
    public function create()
    {
        $countries = Country::where('status', true)->get();
        return view('city.create', compact('countries'));
    }

    /**
     * Show the edit view with the item information
     * @param City $city
     * @method GET
     */
    public function edit(City $city)
    {
        $countries = Country::where('status', true)->get();
        return view('city.edit', compact('city', 'countries'));
    }

    /**
     * Display the show view with the item information in readonly mode
     * @param City $city
     * @method GET
     */
    public function show(City $city)
    {
        return view('city.show', compact('city'));
    }

    /**
     * Receive the form information and creates the item
     * @param Request $request
     * @method POST
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'       => ['required', 'string', 'max:255', 'unique:cities,name'],
            'country_id' => ['required', 'numeric']
        ])->validate();

        $data = $request->all();
        $data['created_by'] = auth()->user()->id;

        $city = City::create($data);

        return redirect()
            ->route('city.edit', compact('city'))
            ->with('success', trans('messages.cityCreated'));
    }

    /**
     * Receive the form information and updates the item
     * @param $request
     * @param City $city
     * @method PATCH
     */
    public function update(Request $request, City $city)
    {
        Validator::make($request->all(), [
            'name'       => ['required', 'string', 'max:255', Rule::unique('cities')->ignoreModel($city)],
            'country_id' => ['required', 'numeric']
        ])->validate();

        $city->update($request->all());

        return redirect()
            ->route('city.edit', compact('city'))
            ->with('success', trans('messages.cityUpdated'));
    }

    /**
     * Delete the item
     * @param City $city
     * @method DELETE
     */
    public function destroy(City $city)
    {
        $city->delete();
        return redirect()
            ->route('city.index')
            ->with('success', trans('messages.cityDeleted'));
    }

    /**
     * Change the status of the item
     * @param City $city
     * @method POST
     */
    public function changeStatus(City $city)
    {
        $city = City::find($city->id);
        $city->update([
            'status' => ($city->status) ? 0 : 1
        ]);

        return redirect()
            ->route('city.index')
            ->with('success', trans('messages.cityUpdated'));
    }

    /**
     * Verifies that the name provided upon import is unique and valid
     * @param Request $request
     * @method GET
     */
    public function checkName(Request $request)
    {
        $nameExists = City::where('name', $request->name)->exists();
        return response()->json(['name' => $nameExists]);
    }

    /**
     * import items from modal form
     * @param Request $request
     * @method POST
     */
    public function import(Request $request)
    {
        for ($i = 0; $i < count($request->name); $i++)
        {
            City::create([
                'name'       => $request->name[$i],
                'country_id' => $request->country_id[$i],
                'created_by' => auth()->user()->id
            ]);
        }

        return redirect()
            ->route('city.index')
            ->with('success', trans('messages.cityImported'));
    }

    /**
     * export items to excel file
     * @method GET
     */
    public function export()
    {
        return Excel::download(new CityExport, 'cities.xlsx');
    }
}

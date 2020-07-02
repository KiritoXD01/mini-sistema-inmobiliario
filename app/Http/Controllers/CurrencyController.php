<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CurrencyController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the permissions for this controller
         */
        $this->middleware('permission:currency-list|currency-create|currency-edit|currency-delete|currency-status', ['only' => ['index','store']]);
        $this->middleware('permission:currency-show', ['only' => ['show']]);
        $this->middleware('permission:currency-create', ['only' => ['create','store']]);
        $this->middleware('permission:currency-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:currency-status', ['only' => ['changeStatus']]);
        $this->middleware('permission:currency-delete', ['only' => ['destroy']]);
    }

    /**
     * Show the index view
     * @method GET
     */
    public function index()
    {
        $currencies = Currency::all();
        return view('currency.index', compact('currencies'));
    }

    /**
     * Show the create view
     * @method GET
     */
    public function create()
    {
        return view('currency.create');
    }

    /**
     * Show the edit view with the item information
     * @param Currency $currency
     * @method GET
     */
    public function edit(Currency $currency)
    {
        return view('currency.edit', compact('currency'));
    }

    /**
     * Display the show view with the item information in readonly mode
     * @param Currency $currency
     * @method GET
     */
    public function show(Currency $currency)
    {
        return view('currency.show', compact('currency'));
    }

    /**
     * Receive the form information and creates the item
     * @param Request $request
     * @method POST
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:currencies,name'],
            'rate' => ['required', 'numeric']
        ])->validate();

        $data               = $request->all();
        $data['name']       = strtoupper($data['name']);
        $data['created_by'] = auth()->user()->id;

        $currency = Currency::create($data);

        return redirect()
            ->route('currency.edit', compact('currency'))
            ->with('success', trans('messages.currencyCreated'));
    }

    /**
     * Receive the form information and updates the item
     * @param Request $request
     * @param Currency $currency
     * @method PATCH
     */
    public function update(Request $request, Currency $currency)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('currencies')->ignoreModel($currency)],
            'rate' => ['required', 'numeric']
        ])->validate();

        $data = $request->all();
        $data['name'] = strtoupper($data['name']);

        $currency->update($data);

        return redirect()
            ->route('currency.edit', compact('currency'))
            ->with('success', trans('messages.currencyUpdated'));
    }

    /**
     * Delete the item
     * @param Currency $currency
     * @method DELETE
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()
            ->route('currency.index')
            ->with('success', trans('messages.currencyDeleted'));
    }

    /**
     * Change the status of the item
     * @param Currency $currency
     * @method POST
     */
    public function changeStatus(Currency $currency)
    {
        $currency = Currency::find($currency->id);
        $currency->update([
            'status' => ($currency->status) ? 0 : 1
        ]);

        return redirect()
            ->route('currency.edit', compact('currency'))
            ->with('success', trans('messages.currencyUpdated'));
    }
}

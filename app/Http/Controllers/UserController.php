<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
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
        $roles = Role::where('status', true)->pluck('name')->all();
        return view('user.index', compact('users', 'roles'));
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

    /**
     * Show the edit view with the item information
     * @param User $user
     * @method GET
     */
    public function edit(User $user)
    {
        $roles = Role::where('status', true)->pluck('name', 'name')->all();
        $data = [
            'roles' => $roles,
            'user'  => $user
        ];

        if ($user->hasRole("SELLER"))
        {
            $properties = Property::whereNotIn('id', $user->propertySellers->pluck('property_id'))
                                    ->where('status', true)
                                    ->get();

            $data['properties'] = $properties;
        }

        return view('user.edit', $data);
    }

    /**
     * Display the show view with the item information in readonly mode
     * @param User $user
     * @method GET
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Receive the form information and creates the item
     * @param Request $request
     * @method POST
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email:rfc', 'max:255', 'unique:users,email,{email}'],
            'password'  => ['required', 'string', 'min:8', 'confirmed']
        ])->validate();

        $data = $request->all();
        $data['email']      = strtolower($data['email']);
        $data['created_by'] = auth()->user()->id;
        $data['password']   = bcrypt($data['password']);
        $data['code']       = Str::random(8);

        $user = User::create($data);
        $user->assignRole($data['role']);

        return redirect()
            ->route('user.edit', compact('user'))
            ->with('success', trans('messages.userCreated'));
    }

    /**
     * Receive the form information and updates the item
     * @param $request
     * @param User $user
     * @method PATCH
     */
    public function update(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email:rfc', 'max:255', Rule::unique('users')->ignoreModel($user)],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed']
        ])->validate();

        $data             = $request->all();
        $data['email']    = strtolower($data['email']);
        $data['password'] = (empty($request->password)) ? $user->password : bcrypt($data['password']);

        $user->update($data);
        $user->syncRoles($data['role']);

        return redirect()
            ->route('user.edit', compact('user'))
            ->with('success', trans('messages.userUpdated'));
    }

    /**
     * Delete the item
     * @param User $user
     * @method DELETE
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()
            ->route('user.index')
            ->with('success', trans('messages.userDeleted'));
    }

    /**
     * Change the status of the item
     * @param User $user
     * @method POST
     */
    public function changeStatus(User $user)
    {
        $user = User::find($user->id);
        $user->update([
            'status' => ($user->status) ? 0 : 1
        ]);

        return redirect()
            ->route('user.index')
            ->with('success', trans('messages.userUpdated'));
    }

    /**
     * Verifies that the email provides upon import is unique and valid
     * @param Request $request
     * @method GET
     */
    public function checkEmail(Request $request)
    {
        $emailExists = User::where('email', strtolower($request->email))->exists();
        return response()->json(['email' => $emailExists]);
    }

    /**
     * import users from modal form
     * @param Request $request
     * @method POST
     */
    public function import(Request $request)
    {
        for ($i = 0; $i < count($request->email); $i++)
        {
            $user = User::create([
                'firstname'   => $request->firstname[$i],
                'lastname'    => $request->lastname[$i],
                'email'       => strtolower($request->email[$i]),
                'phonenumber' => (!empty($request->phonenumber[$i]) && isset($request->phonenumber[$i])) ? $request->phonenumber[$i] : "",
                'created_by'  => auth()->user()->id,
                'password'    => bcrypt($request->password[$i]),
                'code'        => Str::random(8)
            ]);

            $user->assignRole($request->role[$i]);
        }

        return redirect()
            ->route('user.index')
            ->with('success', trans('messages.userImported'));
    }

    /**
     * export users to excel file
     * @method GET
     */
    public function export()
    {
        return Excel::download(new UserExport, 'users.xlsx');
    }
}

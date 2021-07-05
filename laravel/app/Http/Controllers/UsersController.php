<?php

namespace App\Http\Controllers;

use App\User;
use App\Mail\NewUserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortColumn = $request->get('sortColumn', null);
        $sortOrder = $request->get('sortOrder', null);

        if (isset($sortColumn) && $sortColumn != NULL && isset($sortOrder) && $sortOrder != NULL) {

            return view ('users.index', ['users' => User::where('id', '>', 0)->orderBy($sortColumn, $sortOrder)->paginate(10), 'fieldsOnDatabase' => User::$fieldsOnDatabase]);

        } else {

            return view ('users.index', ['users' => User::where('id', '>', 0)->paginate(10), 'fieldsOnDatabase' => User::$fieldsOnDatabase]);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', ['fieldsOnDatabase' => User::$fieldsOnDatabase]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateUser();

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'isAdmin' => $request['isAdmin'],
            'active' => $request['active'],
        ]);
        Mail::to($request['email'])->send(new NewUserMail($user));

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', ['user' => $user, 'fieldsOnDatabase' => User::$fieldsOnDatabase]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user, 'fieldsOnDatabase' => User::$fieldsOnDatabase]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedAttributes = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id . ',id',
            'isAdmin' => 'boolean',
            'active' => 'boolean',
        ]);

        $user->update($validatedAttributes);

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user->isAdmin) {

            User::where('id', $id)->delete();

            return redirect(route('users.index'))->with('success','User deleted successfully.');

        }else{
            return redirect(route('users.index'))->with('success','Admin users can not be deleted.');
        }
    }

    /**
     * Validates the submitted fields.
     *
     * @return \Illuminate\Http\Response
     */
    protected function validateUser()
    {
        return request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'isAdmin' => 'required|boolean',
        ]);
    }
}

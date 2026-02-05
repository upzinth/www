<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    function index()
    {
        $users = User::all();
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone_number = $request->input('phone_number');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->latitude = $request->input('latitude');
        $user->longitude = $request->input('longitude');

        $usernameFromForm = strtolower($request->input('username'));
        $usernameFromDB = strtolower($user->username);

        if ($usernameFromForm != $usernameFromDB) {
            if (User::where('username', $usernameFromForm)->exists()) {
                $validator->errors()->add('username', 'This username is already taken');
                return back()->withErrors($validator)->withInput();
            }
            $user->username = $usernameFromForm;
        }

        $emailFromForm = strtolower($request->input('email'));
        $emailFromDB = strtolower($user->email);

        if ($emailFromForm != $emailFromDB) {
            if (User::where('email', $emailFromForm)->exists()) {
                $validator->errors()->add('email', 'This email is already taken');
                return back()->withErrors($validator)->withInput();
            }
            $user->email = $emailFromForm;
        }

        $user->update();

        return redirect(route('users.index'))->with('status', 'User updated!');
    }

    function updateRole(Request $request)
    {
        $userId = (int) $request->get('userId');
        $role = $request->get('role');
        $isChecked = filter_var($request->get('isChecked'), FILTER_VALIDATE_BOOLEAN);

        $user = User::findOrFail($userId);
        if ($role == 'admin') {
            $user->is_admin = $isChecked;
        } else if ($role == 'agent') {
            $user->is_agent = $isChecked;
        }
        $user->update();
        return response([(int) $userId, $role,  $isChecked]);
    }
}
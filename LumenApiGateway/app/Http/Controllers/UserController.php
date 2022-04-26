<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponser;


    public function __construct(
    )
    {
    }

    public function index()
    {
        $user = User::all();
        return $this->validResponse($user);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ];
        $this->validate($request, $rules);
        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);
        $user = User::create($fields);
        return $this->validResponse($user, Response::HTTP_CREATED);
    }

    public function show($user)
    {
        $user = User::findOrFail($user);
        return $this->validResponse($user);
    }

    public function update(Request $request, $user)
    {
        $rules = [
            'name' => 'max:255',
            'email' => 'email|unique:user,email'.$user,
            'password' => 'min:8|confiemed'
        ];
        $this->validate($request, $rules);
        $user = User::findOrFail($user);
        $user->fill($request->all());

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($user->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->save();
        return $this->validResponse($user);
    }

    public function destroy($user)
    {
        $user = User::findOrFail($user);
        $user->delete();
        return $this->validResponse($user);
    }
}

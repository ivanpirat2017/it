<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\User_role;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request)
    {

        $messages = [
            'name' => 'имя',
            'surname' => 'фамилия',
            'adress' => 'адрес',
            'password' => 'пароль',
            'tell' => 'номер телефона',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'adress' => 'required',
            'tell' => 'required|digits:11|unique:users',
            'password' => 'required|min:5',
        ]);
        $validator->setAttributeNames($messages);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $request['id_role'] = 1;
        if (User::count() == 0) {
            User_role::create([
                'role_name' => 'buyer'
            ]);
            User_role::create([
                'role_name' => 'worker'
            ]);
            User_role::create([
                'role_name' => 'admin'
            ]);
            $request['id_role'] = 3;
        }
        User::create($request->all());

        return response()->json()->setStatusCode(204);
    }
    public function edit(Request $request)
    {

        $messages = [
            'name' => 'имя',
            'surname' => 'фамилия',
            'adress' => 'адрес',
            'password' => 'пароль',
            'tell' => 'номер телефона',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'adress' => 'required',
        ]);
        $validator->setAttributeNames($messages);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        Auth::user()->edit($request);
        return response()->json()->setStatusCode(204);
    }
    public function editRoleId(Request $request)
    {
        if ( Auth::user()->id_role != 3) {
            return  response()->json([
                'data' => false
            ], 412);
        }
        User::find($request->id)->editRole($request);
        return $request;
        return response()->json()->setStatusCode(204);
    }
    public function login(Request $request)
    {

        $messages = [
            'tell' => 'номер телефона',
            'password' => 'пароль',

        ];
        $validator = Validator::make($request->all(), [
            'tell' => 'required|digits:11',
            'password' => 'required',
        ]);
        $validator->setAttributeNames($messages);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($user = User::where('tell', $request->tell)->first()) {
            if ($request->password == $user->password) {
                return response()->json([
                    'data' => [
                        'token' => $user->generateToken(),
                    ],
                ]);
            }
        }

        return response()->json([
            'errors' => [
                'tell' => [
                    'Неверный номер телефона или пароль',
                ]
            ],
        ], 401);
    }

    public function logout()
    {
        Auth::user()->api_token = null;
        Auth::user()->save();
    }
    function authCheck()
    {
        return  response()->json([
            'data' => UserResource::make(Auth::user())
        ]);
    }
    function authAdminCheck(Request $request)
    {
        if (Auth::user()->id_role== 2||Auth::user()->id_role== 3) {
            return  response()->json([
                'data' => Auth::check()
            ], 200);
        }
        return response()->json([
            'error' => [
                'code' => 401,
                'message' => 'not admin',
            ]
        ], 401);
    }
}

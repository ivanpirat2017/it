<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{

    public function index($id)
    {
        return response()->json(['data' => Service::find($id)], 200);
    }

    public function create(Request $request)
    {
        if (Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
            return  response()->json([
                'data' => false
            ], 412);
        }
        if (Service::count() == 0) {
            Type::create([
                'name' => 'Наши услуги'
            ]);
            Type::create([
                'name' => 'ПОЧЕМУ ВЫБИРАЮТ IT-Центр'
            ]);
            Type::create([
                'name' => 'slider'
            ]);
        }
        $path = ' ';
        if (request()->hasFile('image')) {
            $path = Storage::url($request->file('image')->store('servicesimg'));
        }
        Service::create(['name' => $request->name, 'del' => false,'description' => $request->description, 'image' => $path, 'id_type' => $request->id_type,]);
        return response()->json([], 204);
    }


    public function show($id)
    {
        return response()->json(['data' => Service::where('id_type', '=', $id)->where('del', '=', true)->get()], 200);
    }
    public function showAdmin($id)
    {
        return response()->json(['data' => Service::where('id_type', '=', $id)->orderBy('id', 'desc')->get()], 200);
    }

    public function edit(Request $request)
    {
        if (Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
            return  response()->json([
                'data' => false
            ], 412);
        }
        if (request()->hasFile('image')) {
            $request->image = Storage::url($request->file('image')->store('servicesimg'));
        } else {
            $request->image  = null;
        }
        Service::find($request->id)->edit($request);
        return response()->json(['data' => Service::find($request->id)], 200);
    }

    public function destroy(Request $request)
    {
        if (Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
            return  response()->json([
                'data' => false
            ], 412);
        }

        Service::find($request->id)->del($request);
    }
}

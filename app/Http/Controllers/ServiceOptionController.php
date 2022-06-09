<?php

namespace App\Http\Controllers;

use App\Models\Service_option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

class ServiceOptionController extends Controller
{

    public function create(Request $request)
    {
        if (Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
            return  response()->json([
                'data' => false
            ], 412);
        }

        Service_option::create([
            'price' => $request->price,
            'title' => $request->title,
            'id_service' => $request->id_service,
            'delivery' => (bool)$request->delivery,
        ]);
        return response()->json(null, 204);
    }


    public function show($id)
    {
        return response()->json(['data' => Service_option::where('id_service', $id)->get()], 200);
    }
    public function del(Request $request)
    {
        if (Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
            return  response()->json([
                'data' => false
            ], 412);
        }
        Service_option::find($request->id)->delete();
        return response()->json([null], 204);
    }
    public function edit(Request $request)
    {
        if (Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
            return  response()->json([
                'data' => false
            ], 412);
        }
        Service_option::find($request->id)->edit($request);
        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{

    public function create(Request $request)
    { if (Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
        return  response()->json([
            'data' => false
        ], 412);
    }
        Type::create($request->all());
        return response()->json(null, 204);
    }


    public function show()
    {
        return response()->json(['data' => Type::select('id', 'name')->get()], 200);
    }

    public function edit(Request $request)
    { if (Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
        return  response()->json([
            'data' => false
        ], 412);
    }

       Type::find($request->id)->edit($request);

        return response()->json(null, 204);
    }

    public function destroy(Request $request)
    {
        //
    }
}

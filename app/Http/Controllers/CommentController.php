<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(Request $request)
    {

        Comment::create([
            'id_user' => Auth::user()->id,
            'id_service' => $request->id_service,
            'text_comment' => $request->text_comment,
            'approved' => 0,
            'del' => 0,
        ]);
        return response()->json(null, 204);
    }


    public function show($id)
    {
        return response()->json(['data' => CommentResource::collection(Comment::where('id_service', $id)->where('approved', true)->get())], 200);
    }
    public function showAdmin()
    {
        if ( Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
            return  response()->json([
                'data' => false
            ], 412);
        }
        return response()->json(['data' => CommentResource::collection(Comment::where('approved', false)->where('del', false)->get())], 200);
    }

    public function edit(Request $request)
    {
        if ( Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
            return  response()->json([
                'data' => false
            ], 412);
        }
        Comment::find($request->id)->edit($request);
        return response()->json(null, 204);
    }
}

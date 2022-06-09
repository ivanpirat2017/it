<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentSearchResource;
use App\Http\Resources\ServiceOptionsSearchResource;
use App\Http\Resources\UserResource;
use App\Models\Comment;
use App\Models\Service_option;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    function searchAmdimRole()
    {
        if (Auth::user()->id_role != 3) {
            return  response()->json([
                'data' => false
            ], 412);
        }
        $qwery = $_GET['qwery'];
        $user =  User::orWhere('name', 'like',  '%' . $qwery . '%')
            ->orWhere('surname', 'like',  '%' . $qwery . '%')
            ->orWhere('tell', 'like',  '%' . $qwery . '%')
            ->orWhere('adress', 'like',  '%' . $qwery . '%')
            ->orWhereHas('role', function ($item) use ($qwery) {
                return   $item->Where('role_name', 'like',  '%' . $qwery . '%');
            })
            ->get();

        return response()->json(['data' =>  UserResource::collection($user)], 200);
    }
    function searchData()
    {
        $qwery = trim($_GET['qwery']);
        if ($qwery == '') {
            return response()->json(['data' => [
                'ServiceOption' => [],

            ]], 200);
        }
        $options = Service_option::orWhere('title', 'like',  '%' . $qwery . '%')
            ->orWhere('price', 'like',  '%' . $qwery . '%')
            ->get();
        return response()->json(['data' => [
            'ServiceOption' => ServiceOptionsSearchResource::collection($options),
        ]], 200);
    }
}

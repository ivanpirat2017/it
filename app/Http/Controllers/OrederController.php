<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Order_statuse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use stdClass;

class OrederController extends Controller
{
    function Create(Request $request)
    {
        if (Order_statuse::count() == 0) {
            Order_statuse::create([
                'name_status' => 'создан'
            ]);
            Order_statuse::create([
                'name_status' => 'обработан'
            ]);
            Order_statuse::create([
                'name_status' => 'ожидайте мастера'
            ]);
            Order_statuse::create([
                'name_status' => 'мастер выехал'
            ]);
            Order_statuse::create([
                'name_status' => 'заказ выполнен'
            ]);
            Order_statuse::create([
                'name_status' => 'заказ отменен'
            ]);
            Order_statuse::create([
                'name_status' => 'забрать в пункте выдачи'
            ]);
        }

        Order::create([
            'id_user' => Auth::user()->id,
            'code' => Str::random(8),
            'id_order_statuse' => 1,
            'json_cart' => $request->json_cart,
            'price' => $request->price
        ]);
        return response()->json([], 204);
    }
    function GetOrserUserId()
    {
        return response()->json(['data' =>  OrderResource::collection(Order::where('id_user', '=', Auth::user()->id)->orderBy('id', 'desc')->get())], 200);
    }
    function GetOrsersAdmin()
    {
        if (Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
            return  response()->json([
                'data' => false
            ], 412);
        }
        return response()->json(['data' => OrderResource::collection(Order::get())], 200);
    }
    public function edit(Request $request)
    {
        if ($request->del) {
            $request['id_order_statuse'] = 6;
            Order::find($request->id)->edit($request);
            return response()->json([], 204);
        }
        if (Auth::user()->id_role != 3 && Auth::user()->id_role != 2) {
            return  response()->json([
                'data' => false
            ], 412);
        }
        Order::find($request->id)->edit($request);
        return response()->json([], 204);
    }
}

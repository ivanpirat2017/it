<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    function getCart(Request $request )
   {
   if(is_null($request->carts)){
    return response()->json(['data' => [
        'carts'=> [],
        'sum'=> 0,
    ] ], 200);
   }
    $carts = [];
    $sum=0;
    foreach (json_decode( $request->carts) as $value) {
        $cart =DB::table('services')->where('id',$value->id_service)->select('id','name')->first();
        $cart->options = DB::table('service_options')->whereIn('id',$value->service_options)->select('id','title','price')->get();
        $sum += DB::table('service_options')->whereIn('id',$value->service_options)->sum('price');
        array_push( $carts, $cart);
    }

    return response()->json(['data' => [
        'carts'=> $carts,
        'sum'=> $sum,
    ] ], 200);
   }
}

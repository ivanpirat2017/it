<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Service_option;
use Illuminate\Support\Facades\DB;
use stdClass;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_user',
        'code',
        'id_order_statuse',
        'json_cart',
        'price',
    ];
    protected $with = ['status_id','user_id'];
    function status_id()
    {
        return $this->hasOne(Order_statuse::class, 'id', 'id_order_statuse');
    }
    function user_id()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    public function json_cart_decode($items)
    {
        $carts = [];
        $orderdata = (object) new stdClass();
        $sum = 0;
        foreach (json_decode($items) as $value) {
            $cart = DB::table('services')->where('id', $value->id_service)->select('id', 'name')->first();
            $cart->options = DB::table('service_options')->whereIn('id', $value->service_options)->get();
            $sum += DB::table('service_options')->whereIn('id', $value->service_options)->sum('price');
            array_push($carts, $cart);
        }
        $orderdata    =  array(
            'cart' => $carts,
            'sum' => $sum,
        );
        return  $orderdata;
    }
    public function edit($request)
    {
        $request->id_order_statuse ? $this->id_order_statuse = $request->id_order_statuse : null;
        $this->save();
    }
}

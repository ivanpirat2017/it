<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_option extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'price',
        'id_service',
    ];


    public function edit($request)
    {
        $request->title?  $this->title = $request->title :null ;
        $request->price? $this->price = $request->price :null;
        $request->id_service? $this->id_service = $request->id_service :null;
        $this->save();
    }
}

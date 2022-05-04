<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_statuse extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_status',
    ];
    public function edit($request)
    {
        $this->name_status = $request->name_status;
        $this->save();
    }
}

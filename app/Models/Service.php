<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Service_option;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description',
        'image',
        'id_type',
        'del'
    ];
    protected $with = ['type_id', 'get_options'];
    function type_id()
    {
        return $this->hasOne(Type::class, 'id', 'id_type');
    }
    public function get_options()
    {
        return  $this->hasMany(Service_option::class, 'id_service', 'id');
    }
    public function edit($request)
    {
        $request->name ?  $this->name = $request->name : null;
        $request->description ? $this->description = $request->description : null;
        $request->image ? $this->image = $request->image : null;
        $request->id_type ? $this->id_type = $request->id_type : null;
        $this->save();
    }
    public function del($request)
    {
        $this->del = $request->del;
        $this->save();
    }
}

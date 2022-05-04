<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_user',
        'id_service',
        'text_comment',
        'approved',
        'del',
    ];
    protected $with =['get_user','get_service'];
    public function get_user()
    {
      return  $this->hasOne(User::class,'id','id_user') ;
    }
    public function get_service()
    {
      return  $this->hasOne(Service::class,'id','id_service') ;
    }
    public function edit($request)
    {
        $request->text_comment ?  $this->text_comment = $request->text_comment : null;
        $request->approved ? $this->approved = $request->approved : null;
        $request->del ? $this->del = $request->del : null;
        $this->save();
    }
}

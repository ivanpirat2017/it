<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'tell',
        'adress',
        'password',
        'id_role',
        'api_token',
    ];
    protected $with = ['role'];
    function role()
    {
        return $this->hasOne(User_role::class, 'id', 'id_role');
    }

    public function edit($request)
    {
        $request->name ?  $this->name = $request->name : null;
        $request->surname ? $this->surname = $request->surname : null;
        $request->adress ? $this->adress = $request->adress : null;
        $request->password ? $this->password = $request->password : null;
        $this->save();
    }
    public function editRole($request)
    {
        $request->id_role ?  $this->id_role = $request->id_role : null;
        $this->save();
    }
    function   generateToken()
    {
        if ($this->api_token == null) {
            $this->api_token =  Str::random(60);
            $this->save();
        }
        return  $this->api_token;
    }
}

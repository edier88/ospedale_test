<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "tb_usuarios"; // Especifico el nombre de la tabla
    public $timestamps = false;

    protected $fillable = [
        /*
        'name',
        'email',
        'password',
        */
        "nombre",
        "documento",
        "password",
        "genero",
        "fecha_nacimiento",
        "telefono",
        "eps_id",
        "rol_id",
        "create_at_datetime",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        //'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /*
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    */
    
    public function eps(){ // Creo un metodo para ser llamado por Eloquent, la tabla "tb_usuarios" al tener una relación con la tabla "tb_eps", se me devolverá la eps de dicho usuario
        return $this->belongsTo(Eps::class, 'eps_id'); // Campo de la tabla que tiene la relación y el campo relacionado
    }

    public function rol(){ // Creo un metodo para ser llamado por Eloquent, la tabla "tb_usuarios" al tener una relación con la tabla "tb_roles", se me devolverá el rol de dicho usuario
        return $this->belongsTo(Rol::class, 'rol_id'); // Campo de la tabla que tiene la relación y el campo relacionado
    }
    
}

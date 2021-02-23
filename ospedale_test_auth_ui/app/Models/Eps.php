<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eps extends Model
{
    use HasFactory;

    protected $table = "tb_eps"; // Especifico el nombre de la tabla
    public $timestamps = false;
    
    protected $fillable = [ // Se especifican los campos que se pueden cargar a la tabla, si alguien intenta guardar un registro con "id", por ejemplo, ese campo se ignorará y guardará el registro sólo con los campos especificados
        'nombre'
    ];

    public function usuarios(){
        return $this->hasMany(User::class); // Un Rol puede tenerlo muchos usuarios
    }
}

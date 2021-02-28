<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Eps;
use App\Models\Rol;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $epss = Eps::all();
        $roles = Rol::all();
        $users = $this->mostrarUsuarios();

        // Paso la información a la vista:
        return view('home', [
            'users' => json_decode($users),
            'epss' => $epss,
            'roles' => $roles            
            //'users' => $users
        ]);
    }

    public function updateUser(Request $request){

        // Valido los campos enviados por axios, si esto es incorrecto, se enviará un XHR response de error (422, Unprocessable Entity)
        /* $request->validate([
            "id" => "required",
            "nombre" => "required",
            "documento" => "required",
            "password" => "required",
            "genero" => "required",
            "fecha_nacimiento" => "required",
            "telefono" => "required",
            "eps" => "required",
            "rol" => "required"
        ]); */

        $request->validate([
            "nombre" => ["required",'regex:/^[a-zñÑáéíóúÁÉÍÓÚ]+$/i'],
            "documento" => ["required",'regex:/^\d{6,12}$/'],
            "password" => ["required",'regex:/^.{8,}$/'],
            "genero" => ["required",'regex:/^(M)$|^(F)$/'],
            "fecha_nacimiento" => ["required",'regex:/^[1-2][0-9]{3}-[0-9]{2}-[0-9]{2}$/'],
            "telefono" => ["required",'regex:/^\+[0-9]{6,15}$|^[0-9]{6,15}$/'],
            "eps" => ["required",'regex:/^\d{1,3}$/'],
            "rol" => ["required",'regex:/^\d{1,3}$/']
        ]);

        $response = User::where('id', $request->id)
                        ->update([
                            "nombre" => $request->nombre,
                            "documento" => $request->documento,
                            "password" => Hash::make($request->password),
                            "genero" => $request->genero,
                            "fecha_nacimiento" => $request->fecha_nacimiento,
                            "telefono" => $request->telefono,
                            "eps_id" => $request->eps,
                            "rol_id" => $request->rol
                        ]);
        return json_encode($response);
    }

    public function createUser(Request $request){
        
        // Valido los campos enviados por axios, si esto es incorrecto, se enviará un XHR response de error (422, Unprocessable Entity)
        $arrayRequest = [
            "nombre" => $request->nombre,
            "documento" => $request->documento,
            "password" => $request->password,
            "genero" => $request->genero,
            "fecha_nacimiento" => $request->fecha_nacimiento,
            "telefono" => $request->telefono,
            "eps" => $request->eps,
            "rol" => $request->rol
        ];

        
        $arrayValidate = [
            "nombre" => ["required",'regex:/^[a-zñÑáéíóúÁÉÍÓÚ]+$/i'],
            "documento" => ["required",'regex:/^\d{6,12}$/', 'unique:tb_usuarios'],
            "password" => ["required",'regex:/^.{8,}$/'],
            "genero" => ["required",'regex:/^(M)$|^(F)$/'],
            "fecha_nacimiento" => ["required",'regex:/^[1-2][0-9]{3}-[0-9]{2}-[0-9]{2}$/'],
            "telefono" => ["required",'regex:/^\+[0-9]{6,15}$|^[0-9]{6,15}$/'],
            "eps" => ["required",'regex:/^\d{1,3}$/'],
            "rol" => ["required",'regex:/^\d{1,3}$/']
        ];

        // Esta es otra forma de hacer la validacion de campos, se valida y el resultado de la validación se guarda en una variable
        $response = Validator::make($arrayRequest, $arrayValidate);
        
        // De esta forma podemos manipular las respuesta XHR a enviar, con la clase "Response". 
        //Si no se quiere hacer esto, se puede validar los campos de manera más sencilla como está en el método "updateUser" de esta misma clase
        if($response->fails()){
            return Response::json([
                'response' => false,
                'errors' => $response->getMessageBag()->toArray()
            ], 422);
        }

        $response = User::create([
            "nombre" => $request->nombre,
            "documento" => $request->documento,
            "password" => Hash::make($request->password),
            "genero" => $request->genero,
            "fecha_nacimiento" => $request->fecha_nacimiento,
            "telefono" => $request->telefono,
            "eps_id" => $request->eps,
            "rol_id" => $request->rol,
            "create_at_datetime" => date('Y-m-d H:i:s')
        ]);
        
        // De esta forma podemos manipular las respuesta XHR a enviar, con la clase "Response"
        return Response::json(['success' => true], 200);
    }

    public function mostrarUsuarios($id = null){
        
        if ($id){
            $response = User::find($id);
        } else{
            // Haciendo uso de Eloquent con Joins:
            //$users = User::join('tb_roles', 'tb_usuarios.rol_id', '=', 'tb_roles.id')->join('tb_eps', 'tb_usuarios.eps_id', '=', 'tb_eps.id')->select('tb_usuarios.*', 'tb_roles.nombre AS nombreRol', 'tb_eps.nombre AS nombreEps')->get();
            
            // Haciendo uso de Eloquent y las relaciones definidas en los modelos:
            $users = User::with(['eps', 'rol'])->get();

            // Calculo la edad del paciente y le asigno un color para poner en la tabla dependiendo de su edad
            $response = $this->calcularEdad($users);
        }
        return json_encode($response);
    }

    public function removeUser($id){
        $user = User::find($id);
        $result = $user->delete();
        
        return json_encode($result);
        //return $users;
    }

    // Función que calcula la edad del usuario y le asigna un color, tipo clase bootstrap para tablas, dependiendo de su edad
    private function calcularEdad($users){
        $years = 0;
        $colorRow = "";
        $today = date('Y-m-d');
        $todayArr = explode("-", $today);
        foreach ($users as $user) {
            $userBirth = explode("-", $user->fecha_nacimiento);
            $years = $todayArr[0] - $userBirth[0];
            if ( (($todayArr[1]+1) < $userBirth[1]) || (($todayArr[1]+1) == $userBirth[1] && $todayArr[2] < $userBirth[2]) ){
                $years--; 
            }
            $user->edad = $years;

            if($years < 18){
                $colorRow = "table-success";
            } elseif ($years > 50) {
                $colorRow = "table-danger";
            } else{
                $colorRow = "table-light";
            }
            $user->colorEdad = $colorRow;
        }
        return $users;
    }
}

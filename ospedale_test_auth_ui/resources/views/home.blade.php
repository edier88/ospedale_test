@extends('layouts.app')

@section('content')
<!--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
-->

<div class="container">
    <div class="row justify-content-center">
        <table class="table table-striped">
            <thead>
                <tr class="table-active">
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Genero</th>
                    <th scope="col">Fecha de Nacimiento</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">EPS</th>
                    <th scope="col">ROL</th>
                    <th scope="col">Fecha Creacion</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody id="bodyTable">
                @forelse ($users as $user)
                    <tr class={{$user->colorEdad}}>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->nombre }}</td>
                        <td>{{ $user->documento }}</td>
                        <td>{{ $user->genero }}</td>
                        <td>{{ $user->fecha_nacimiento }}</td>
                        <td>{{ $user->edad }}</td>
                        <td>{{ $user->telefono }}</td>
                        <td>{{ $user->eps->nombre }}</td>
                        <td>{{ $user->rol->nombre }}</td>
                        <td>{{ $user->create_at_datetime }}</td>
                        <td>
                            <div class="row justify-content-center">
                                <div class="col">
                                    <button class="btn btn-success btn-sm" type="button" onclick="mostrarUser({{$user->id}});"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm" type="button" onclick="removeUser({{$user->id}});"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <p>NO HAY USUARIOS PARA MOSTRAR</p>
                @endforelse
            </tbody>
        </table>
        <button type="button" id="buttonModalCreate" class="btn btn-primary" data-toggle="modal" data-target="#createModal">Crear Usuario</button>
    </div>
</div>

<!-- Inicio modal para Editar usuarios -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="id_edit">
                <div class="form-group">
                    <label for="nombre_edit" class="col-form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre_edit">
                </div>
                <div class="form-group">
                    <label for="documento_edit" class="col-form-label">Documento:</label>
                    <input type="text" class="form-control" id="documento_edit">
                </div>
                <div class="form-group">
                    <label for="pass_edit" class="col-form-label">Password:</label>
                    <input type="password" class="form-control" id="pass_edit">
                </div>
                <div class="form-group">
                    <label for="genero_edit" class="col-form-label">Genero:</label>
                    <select name="genero_edit" id="genero_edit" class="form-control">
                        <option value="" disabled selected>Seleccione un genero</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fechaNacimiento_edit" class="col-form-label">Fecha de Nacimiento:</label>
                    <input type="text" class="form-control" id="fechaNacimiento_edit">
                </div>
                <div class="form-group">
                    <label for="telefono_edit" class="col-form-label">Telefono:</label>
                    <input type="text" class="form-control" id="telefono_edit">
                </div>
                <div class="form-group">
                    <label for="eps_edit" class="col-form-label">EPS:</label>
                    <select name="eps_edit" id="eps_edit" class="form-control">
                        <option value="" disabled selected>Seleccione la EPS</option>
                        @forelse ($epss as $eps)
                            <option value="{{$eps->id}}">{{$eps->nombre}}</option>
                        @empty
                            <option value="">ERROR</option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <label for="rol_edit" class="col-form-label">Rol:</label>
                    <select name="rol_edit" id="rol_edit" class="form-control">
                        <option value="" disabled selected>Seleccione un Rol</option>
                        @forelse ($roles as $rol)
                            <option value="{{$rol->id}}">{{$rol->nombre}}</option>
                        @empty
                            <option value="">ERROR</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="buttonUpdate" class="btn btn-success">Actualizar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Final modal para Editar usuarios -->

<!-- Inicio modal para crear usuarios -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nombre_create" class="col-form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre_create">
                </div>
                <div class="form-group">
                    <label for="documento_create" class="col-form-label">Documento:</label>
                    <input type="text" class="form-control" id="documento_create">
                </div>
                <div class="form-group">
                    <label for="pass_create" class="col-form-label">Password:</label>
                    <input type="password" class="form-control" id="pass_create">
                </div>
                <div class="form-group">
                    <label for="genero_create" class="col-form-label">Genero:</label>
                    <select name="genero_create" id="genero_create" class="form-control">
                        <option value="" disabled selected>Seleccione un genero</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fechaNacimiento_create" class="col-form-label">Fecha de Nacimiento:</label>
                    <input type="text" class="form-control" id="fechaNacimiento_create">
                </div>
                <div class="form-group">
                    <label for="telefono_create" class="col-form-label">Telefono:</label>
                    <input type="text" class="form-control" id="telefono_create">
                </div>
                <div class="form-group">
                    <label for="eps_create" class="col-form-label">EPS:</label>
                    <select name="eps_create" id="eps_create" class="form-control">
                        <option value="" disabled selected>Seleccione la EPS</option>
                        @forelse ($epss as $eps)
                            <option value="{{$eps->id}}">{{$eps->nombre}}</option>
                        @empty
                            <option value="">ERROR</option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <label for="rol_create" class="col-form-label">Rol:</label>
                    <select name="rol_create" id="rol_create" class="form-control">
                        <option value="" disabled selected>Seleccione un Rol</option>
                        @forelse ($roles as $rol)
                            <option value="{{$rol->id}}">{{$rol->nombre}}</option>
                        @empty
                            <option value="">ERROR</option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <span id="response_create"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="buttonCreate" class="btn btn-success">Crear</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Final modal para crear usuarios -->
@endsection

@section('view_scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
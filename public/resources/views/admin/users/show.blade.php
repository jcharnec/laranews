@extends('layouts.master')
@section('titulo', "Detalles del usuario $user->name")

@section('contenido')
<div class="row">
    <table class="col-8 table table-striped table-bordered">
        <tr>
            <td>ID</td>
            <td>{{$user->id}}</td>
        </tr>
        <tr>
            <td>Nombre</td>
            <td>{{$user->name}}</td>
        </tr>
        <tr>
            <td>Correo</td>
            <td><a href="mailto:{{ $user->email }}">{{$user->email}}</a></td>
        </tr>
        <tr>
            <td>Fecha de creación</td>
            <td>{{ $user->created_at }}</td>
        </tr>
        <tr>
            <td>Fecha de verificación</td>
            <td>{{ $user->verified_at ?? 'Sin verificar' }}</td>
        </tr>
        <tr>
            <td>Roles</td>
            <td>
                @foreach($user->roles as $rol)
                <span class="d-inline-block w-50">- {{ $rol->role}}</span>
                <form class="d-inline-block p-1" method="POST"
                    action="{{ route('admin.user.removeRole') }}">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="role_id" value="{{ $rol->id }}">
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
                <br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Añadir rol</td>
            <td>
                <form method="POST" action="{{ route('admin.user.setRole') }}">
                    @csrf
                    <input type="hidden" name="_method" value="post">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <select class="form-control w-50 d-inline" name="role_id">
                        @foreach($user->remainingRoles() as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->role }}</option>
                        @endforeach
                    </select>
                    <input type="submit" class="btn btn-success px-3 ml-1" value="Añadir">
                </form>
            </td>
        </tr>
    </table>
    <figure class="col-4">
        <img class="rounded img-fluid"
            src="{{ asset('storage/images/users/default.png') }}" 
            alt="Imagen de usuario {{$user->name}}">
        <figcaption class="figure-caption text-center">{{ $user->name }}</figcaption>
    </figure> 
</div>
@endsection
@section('enlaces')
    @parent
    <a href="{{ route('admin.users') }}" 
        class="btn btn-primary m-2">Lista de usuarios</a>
@endsection
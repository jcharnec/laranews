@extends('layouts.master')
@section('titulo', 'Contactar con LaraBikes')
@section('contenido')
<div class="container row">
    <div class="col-md-7 my-2 border p-4">
        <form method="POST" action="{{route('contacto.email')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group row">
                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                <input name="email" type="email" class="up form-control" id="inputEmail" placeholder="Email" maxlength="255" required="required" value="{{old('email')}}">
            </div>
            <div class="form-group row">
                <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
                <input name="nombre" type="text" class="up form-control" id="inputNombre" placeholder="Nombre" maxlength="255" required="required" value="{{old('nombre')}}">
            </div>
            <div class="form-group row">
                <label for="inputAsunto" class="col-sm-2 col-form-label">Asunto</label>
                <input name="asunto" type="text" class="up form-control" id="inputAsunto" placeholder="Asunto" maxlength="255" required="required" value="{{old('asunto')}}">
            </div>
            <div class="form-group row">
                <label for="inputMensaje" class="col-sm-2 col-form-label">Mensaje</label>
                <textarea name="mensaje" class="up form-control" id="inputMensaje" maxlength="2048" required="required">{{old('mensaje')}}</textarea>
            </div>
            <div class="form-group row my-4">
                <label for="inputImagen" class="form-label">Fichero (pdf):</label>
                <input name="fichero" type="file" class="form-control-file"
                accept="application/pdf" id="inputFichero">
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-success m-2 mt-5">Enviar</button>
                <button type="reset" class="btn btn-secondary m-2 mt-5">Borrar</button>
            </div>
        </form>
    </div>
    <div class="col-md-5">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d47756.809513288754!2d2.0175253!3d41.5735601!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2ses!4v1720001205648!5m2!1ses!2ses" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>
@endsection

@section('enlaces')
@parent
<a href="{{route('bikes.index')}}" class="btn btn-primary m-2">Garaje</a>
@endsection

@extends('layouts.BootStrap')
@section('title','mititulo')
@section('BootStrapBody')
<main role="main" class="container">
    <div class="starter-template">
        <h1>ParkinSoft</h1>
        <h3>Sistema de Seguimiento de la Afección de la voz en pacientes de parkinson</h3>
        <p class="lead"><br>Por favor ingrese sus credenciales</p>
    </div>
    <form class="form-signin">
        <img class="mb-4" src="../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Por Favor Ingrese sus credenciales</h1>
        <label for="inputEmail" class="sr-only">Usuario</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Usuario" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
            <label>
            <input type="checkbox" value="remember-me"> Recuerdame
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
        <p class="mt-5 mb-3 text-muted">Higia Soft 2019</p>
    </form>
</main>
@endsection
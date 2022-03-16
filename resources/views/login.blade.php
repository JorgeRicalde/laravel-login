@extends('template.base')

@section('classes_body', 'login-page dark-mode')

@section('title', 'Login')

@section('body')
    <div class="container card px-xl-5 py-xl-5" style="background-color: rgba(52, 58, 64, 0.8)">
        <div class="row ">
            <div class="col-12 col-md-6 align-self-center">
                <div class="d-none d-md-flex ">
                    <img src="https://www.processmaker.com/wp-content/uploads/2021/09/laravel-workflow-tutorial.png"
                        class="img-fluid img-thumbnail">
                </div>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div class="login-box ">
                    {{-- Logo --}}
                    <div class="login-logo ">
                        <div class="badge badge-light text-dark">
                            <b>LOGIN API</b>
                        </div>
                    </div>

                    {{-- Card Box --}}
                    <div class="card card-outline card-primary">

                        {{-- Card Header --}}
                        <div class="card-header">
                            <h3 class="card-title float-none text-center">
                                Iniciar Sesión
                            </h3>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body login-card-body">
                            <form id="frmLogin">
                                {{ csrf_field() }}

                                {{-- Email field --}}
                                <div class="input-group mb-3">
                                    <input type="email" name="email" class="form-control" value="" placeholder="Email"
                                        autofocus>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope "></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Password field --}}
                                <div class="input-group mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Contraseña">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Login field --}}
                                <div class="row">
                                    <div class="col">
                                        <button type=submit class="btn btn-block btn-flat bg-dark ">
                                            <span class="fas fa-sign-in-alt"></span>
                                            <span id="btnSubmitText">Ingresar</span>
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/login.js') }}"></script>
@stop

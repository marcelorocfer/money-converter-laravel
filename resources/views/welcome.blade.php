@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card card-body">
                    <h3 class="card-title text-center">
                        Sistema de Conversão de Moedas
                    </h3>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}" class="btn btn-light">Home</a>
                        @else

                        <h5 class="card-title text-center mb-4">Faça login ou cadastre!</h5>
                            <a href="{{ route('login') }}" class="btn btn-light mb-3">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-light">Cadastrar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

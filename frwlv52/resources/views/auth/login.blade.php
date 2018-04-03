@extends('plantillas.loging')

@section('content')
<div class="w_login">
    <form class="form-horizontal" name="login" role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}
        <div class="w_img">
            <img src="/img/tigotrainers.svg" alt="">
        </div>
        <div class="w_loginfield">
            <input type="number" name="cedula" min="0" class="form-control" placeholder="Usuario" value="">
        </div>
        <div class="w_loginfield">
            <input type="password" name="password" class="form-control" placeholder="Contraseña" value="">
        </div>
        <button type="submit" class="btn btn-primary loginBtn">Ingresar</button>
        <div class="w_loginmsg">
        @if ( session()->has('errorlogin') )
            {{ session()->get('errorlogin') }}
        @endif
        </div>
    </form>
</div>
@endsection
@section('script')
<script> getLogin(); </script>
@endsection
@extends('plantillas.app')
@section('content')

<div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-4">
        <div class="">Formulario</div>
        <select class="form-control" name="tipo" id="tipo">
          <option value="1">Todos</option>
          <option value="2">Dealers</option>
          <option value="3">Canales Propios</option>
          <option value="4">Entrenadores</option>
          <option value="5">Contact</option>
          <option value="8">Piloto assesment</option>
          <option value="6">Tecnicos</option>
        </select>
      </div>
      <div class="col-xs-12 col-md-3">
        <div class="">Desde</div>
  	    <input type="text" class="form-control" id="from" value="{{ date('Y-m-d') }}">
      </div>
      <div class="col-xs-12 col-md-3">
      	<div class="">Hasta</div>
      	<input type="text" class="form-control" id="to" value="{{ date('Y-m-d') }}">
      </div>
      <div class="col-xs-12 col-md-2">
        <br/>
  	     <a href="javascript:void(0)" class="btn btn-outline-primary wdownload" >Descargar</a>
      </div>
    </div>
</div>
<br/>

<div class="w_history"></div>
@endsection
@section('script')
<script> getDHistoricoAcompanamientos("{{ trans('app.msg00002') }}"); </script>
<script> getHistoricoAcompanamientos("{{ trans('app.msg00002') }}"); </script>
@endsection

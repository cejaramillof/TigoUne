@extends('plantillas.app')
@section('content')

<div class="input-group input-daterange">
	<input type="text" class="form-control" id="from" value="{{ date('Y-m-d') }}">
	<div class="input-group-addon">Hasta</div>
	<input type="text" class="form-control" id="to" value="{{ date('Y-m-d') }}">
	<a href="javascript:void(0)" class="btn btn-outline-primary wdownload" >Descargar</a>
</div>

<div class="w_history"></div>
@endsection
@section('script')
<script> getHistoricoAcompanamientos("{{ trans('app.msg00002') }}"); </script>
@endsection
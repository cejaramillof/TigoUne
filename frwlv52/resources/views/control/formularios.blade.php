@extends('plantillas.app')

<?php $json = json_decode( $formulario[0] -> configuracion ); ?>

@section('content')
<div class="w_form">
	<h2>{{ $formulario[0] -> titulo }}</h2>

	@foreach( $json -> { 'campos' } AS $c )
		@if( $c -> {'tipo'} == 'instructions' )
			{!! Process::getInstructions( $c ) !!}
		@endif
	@endforeach

	{!! Process::getCalendario( ) !!}

	@foreach( $json -> { 'campos' } AS $c )
		@if( $c -> {'tipo'} == 'radio' )
			{!! Process::getRadio( $c ) !!}
		@elseif( $c -> {'tipo'} == 'checkbox' )
			{!! Process::getCheckbox( $c ) !!}
		@elseif( $c -> {'tipo'} == 'cedula' )
			{!! Process::getCedula( $c ) !!}
		@elseif( $c -> {'tipo'} == 'textarea' )
			{!! Process::getTextArea( $c ) !!}
		@elseif( $c -> {'tipo'} == 'slider' )
			{!! Process::getSlider( $c ) !!}
		@elseif( $c -> {'tipo'} == 'title' )
			{!! Process::getTitulo( $c ) !!}
		@elseif( $c -> {'tipo'} == 'number' )
			{!! Process::getNumber( $c ) !!}
		@elseif( $c -> {'tipo'} == 'text' )
			{!! Process::getText( $c ) !!}
		@elseif( $c -> {'tipo'} == 'time' )
			{!! Process::getTime( $c ) !!}
		@elseif( $c -> {'tipo'} == 'grupoa' )
			{!! Process::getGrupoA( $c -> {'grupo'} ) !!}
		@endif
	@endforeach

	<h4>Su ubicación es</h4>
	<div class="w_geocoder"></div>

	<div class="btn btn-primary process" attr-token="{{ Process::setCifrar( $formulario[0] -> id ) }}">Enviar</div>
	<div class="w_load"></div>
</div>
@endsection

@section('script')
<script>
	getAccionesFormulario();
</script>
@endsection
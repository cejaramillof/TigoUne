<div class="form-group">
	<div class="w_alert"></div>
	<label for="">{{ trans('app.placeholdercedulaeva') }}</label>
	<input type="number" name="txtCedula" id="txtCedula" class="form-control" placeholder="{{ trans('app.placeholdercedulaeva') }}" attr-type="di" >
</div>
<div class="form-group">
	<div class="w_alert"></div>
	<label for="">{{ trans('app.placeholdernombreevaluado') }}</label>
	<input type="text" name="txtNombre" id="txtNombre" class="form-control" placeholder="{{ trans('app.placeholdernombreevaluado') }}" attr-type="text" >
</div>
<div class="form-group">
	<div class="w_alert"></div>
	{{ trans('app.placeholdercargoevaluado') }}
	<select name="txtCanal" id="txtCanal" class="form-control" attr-type="select">
		@foreach( $canal AS $c )
			<option value="{{ $c -> canal }}">{{ $c -> canal }}</option>
		@endforeach
	</select>
</div>
<div class="form-group">
	<div class="w_alert"></div>
	{{ trans('app.placeholderplazaevaluado') }}
	<select name="txtPlaza" id="txtPlaza" class="form-control" attr-type="select">
		@foreach( $plaza AS $c )
			<option value="{{ $c -> plaza }}">{{ $c -> plaza }}</option>
		@endforeach
	</select>
</div>
<div class="btn btn-primary processuser">Enviar</div>
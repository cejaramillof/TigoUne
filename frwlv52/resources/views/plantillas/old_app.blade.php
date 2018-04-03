<?php
$rand = Process::getCadenaAleatoria( date('Ymd his'),0,20 );
$raiz = [];
$html = '';
$a = 0;
for( $i = 0; $i < count($nav); $i++ ):
	$status = true;
	for( $j = 0; $j < count($raiz) && $status; $j++ ):
		if( $raiz[$j]['id'] == $nav[$i] -> idTipoFormulario ):
			$status = false;
		endif;
	endfor;

	if( $status ):
		$raiz[$a]['id'] = $nav[$i] -> idTipoFormulario;
		$raiz[$a]['titulo'] = $nav[$i] -> tipoFormulario;        
		$a ++;
	endif;

endfor;

for( $j = 0; $j < count($raiz); $j++ ):

	$html .= '<a class="nav-link nav-dropdown-toggle" href="#">'.$raiz[$j]['titulo'].'</a>';
	$html .= '<ul class="nav-dropdown-items">';
		for( $i = 0; $i < count($nav); $i++ ):
			if( $nav[$i] -> idTipoFormulario ==  $raiz[$j]['id'] ):
				$html .= '<li class="nav-item"><a class="nav-link w_link" href="'.url('/marcacion/'.$nav[$i] -> url ).'" >'.$nav[$i] -> titulo.'</a></li>';
			endif;
		endfor;
	$html .= '</ul>';

endfor;
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<!-- <link rel="shortcut icon" href="img/favicon.png"> -->
	<link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">

	<title>Control</title>
	<meta name="prfill" content="{!! csrf_token() !!}">
	{!! Html::style('/css/font-awesome.min.css') !!}
	{!! Html::style('/css/simple-line-icons.css') !!}
	{!! Html::style('/css/style.css?ver='.$rand) !!}
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

<header class="app-header navbar">
	<button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">☰</button>
	<a class="navbar-brand" href="#"></a>
	<ul class="nav navbar-nav d-md-down-none">
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="d-md-down-none">{{ Auth::user() -> nombre_empleado }}</span>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item" href="{{ url('/salir') }}"><i class="fa fa-lock"></i>Salir</a>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link navbar-toggler sidebar-toggler" href="#">☰</a>
		</li>
	</ul>
</header>

<div class="app-body">
	<div class="sidebar">
		<nav class="sidebar-nav">
			<ul class="nav">
				<li class="nav-item nav-dropdown">{!! $html !!}</li>
				<li class="nav-item"><a class="nav-link w_link" href="javascript:void(0)" onclick="getFormularioCargaUsuarios()">Carga de asesores</a></li>
				<li class="nav-item"><a class="nav-link w_link" href="{{ url('/historico' ) }}">Histórico</a></li>
				<li class="nav-item"><a class="nav-link w_link" href="{{ url('/salir' ) }}">Salir</a></li>
			</ul>
		</nav>
	</div>

	<main class="main">
		<div class="container-fluid">
			@yield('content')
		</div>
	</main>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div>




<div class="w_message"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
{!! Html::script('/js/tether.min.js') !!}
{!! Html::script('/js/bootstrap.min.js') !!}    
{!! Html::script('/js/app.js') !!}
{!! Html::script('/js/control.js?ver='.$rand) !!}
@yield('script')
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-61639896-5"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-61639896-5');
</script>
</body>
</html>






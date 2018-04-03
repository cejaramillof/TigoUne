<?php $rand = Process::getCadenaAleatoria( date('Ymd his'),0,20 ); ?>
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
@yield('content')
<div class="w_message"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
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
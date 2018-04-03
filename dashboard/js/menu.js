$(document).ready(function () {    
	$("#webcontent").load("pages/general.html");

	$("#general-btn").click(function () {
		$("#webcontent").load("pages/general.html");
	});
	$("#matriz-comercial-btn").click(function () {
		$("#webcontent").load("pages/matriz/comercial.html");
	});
	$("#matriz-tecnica-btn").click(function () {
		$("#webcontent").load("pages/matriz/tecnica.html");
	});
	$("#matriz-servicio-btn").click(function () {
		$("#webcontent").load("pages/matriz/servicio.html");
	});
	$("#digital-comercial-btn").click(function () {
		$("#webcontent").load("pages/digital/comercial.html");
	});
	$("#digital-tecnica-btn").click(function () {
		$("#webcontent").load("pages/digital/tecnica.html");
	});
	$("#digital-servicio-btn").click(function () {
		$("#webcontent").load("pages/digital/servicio.html");
	});
	$("#convergencia-btn").click(function () {
		$("#webcontent").load("pages/convergencia.html");
	});
	$("#acompanamientos-btn").click(function () {
		$("#webcontent").load("pages/acompanamientos.html");
	});  
	$('#toggleNavColor').click(function () {
		$('nav').toggleClass('navbar-dark navbar-light');
		$('nav').toggleClass('bg-dark bg-light');
		$('body').toggleClass('bg-dark bg-light');
	});
});

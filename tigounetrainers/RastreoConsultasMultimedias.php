<?php
    Class RastreoConsultas {

        private $usuario = "entren8_tut";
        private $contrasena = "t=S(?j=Al#e@";
        private $servidor = "localhost";
        private $basededatos = "tigotrai_trnrsdb";
        private $conexion;
        private $db;

        public function __construct() {

        }

        public function conectarBD() {
            // establecer conexion
            $this->conexion = mysqli_connect($this->servidor, $this->usuario, $this->contrasena) or die ("Problemas de conexion a la base de datos");
            
            // Seleccionar Base de Datos
            $this->db = mysqli_select_db($this->conexion, $this->basededatos ) or die ("Problemas de conexion a la base de datos");
        }

        public function fechaActual() {            
	        return date("Y-m-d h:i:s");
        }

        public function cerrarConexionBD() {
            // Cierre de conexion a Base de Datos
            mysqli_close($this->conexion );
        }

        public function agregarRastroConsulta($cedula, $url) {
            $this->conectarBD();
            $consulta = "INSERT INTO "
                            . "rastreo_consultas_multimedias (Login, URL, Fecha_Consulta)"
                            . "VALUES ('$cedula', '$url', '" . $this->fechaActual() . "')";
            mysqli_query($this->conexion, $consulta ) or die ( "Problemas con el query " . $consulta);
            $this->cerrarConexionBD();
        }
    }
  
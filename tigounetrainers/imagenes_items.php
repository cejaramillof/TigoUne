<? 
    class Img_Items {
        public function __construct() {
            
        }
        
        public function mostrar_imagen($tipo_imagen){
            if($tipo_imagen == '1'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/evoluciona-02.svg';
            }else if($tipo_imagen == '2'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/h_comerciales-02.svg';
            }else if($tipo_imagen == '3'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/pospago-02.svg';
            }else if($tipo_imagen == '4'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/prepago-02.svg';
            }else if($tipo_imagen == '5'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/recursos-02.svg';
            }else if($tipo_imagen == '6'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/promociones-02.svg';
            }else if($tipo_imagen == '7'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/h_comerciales_home-02.svg';
            }else if($tipo_imagen == '8'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/individuales-02.svg';
            }else if($tipo_imagen == '9'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/paquetes-02.svg';
            }else if($tipo_imagen == '10'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/recursos-02.svg';
            }else if($tipo_imagen == '11'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/promociones-02.svg';
            }else if($tipo_imagen == '12'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/sis_informacion-02.svg';
            }else if($tipo_imagen == '13'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/h_comerciales-02.svg';
            }else if($tipo_imagen == '14'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/evoluciona-02.svg';
            }else if($tipo_imagen == '15'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/promociones-02.svg';
            }else if($tipo_imagen == '16'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/click_software-02.svg';
            }else if($tipo_imagen == '17'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/recursos-02.svg';
            }else if($tipo_imagen == '18'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/red_coaxial-02.svg';
            }else if($tipo_imagen == '19'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/red_cobre-02.svg';
            }else if($tipo_imagen == '20'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/servi_dth-02.svg';
            }else if($tipo_imagen == '21'){ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/wifi-02.svg';
            }else{ 
                $imagen_item = 'https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/red_cobre-02.svg';
            }
            
            return $imagen_item;
        }
    }  
?>
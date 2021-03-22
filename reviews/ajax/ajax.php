<?php
namespace REVIEWS;
class AJAX_REQ {
	/*--Initialisation pour la request AJAX pour synchronisation de l evaluation et la Notes --*/
public $request;
public function __construct(){

}
 public function send_request($data){
 	 $this->request = $data;
 	
          
 }
 public function get_response(){
 	 return $this->request ;
 	
          
 }

  

  public function wpdocs_theme_name_scripts() {
   wp_enqueue_style( 'all-min-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css' );
  wp_enqueue_style( 'brands-min-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/brands.min.css' );
  wp_enqueue_style( 'fontawesome-min-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/fontawesome.min.css' );

}
 public function load_css(){
      $this->wpdocs_theme_name_scripts();
     add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );
 }

}
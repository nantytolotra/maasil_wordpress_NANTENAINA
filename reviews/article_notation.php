<?php
use REVIEWS\AJAX_REQ as AJAX_REQ_APP;

class Articles_Notation{
	/*--- Decalaration de chaque IP utilisateur : type string (var user_ip) --*/
	public $user_ip;
	/*--- Decalaration de chaque ID Post : type string (var post_id) --*/
	public $post_id;
 	/*--- Decalaration de chaque ID Nombre d' Etoiles : type string (var nb_etoiles) --*/
  public $nb_etoiles;
 
  
  public function __construct(AJAX_REQ_APP $request){
          $this->user_ip = $request->request["user_ip"];
          $this->post_id =$request->request["post_id"];
          $this->nb_etoiles =$request->request["nb_etoiles"];
          
   }
} 


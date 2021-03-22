<?php
/**
 * Plugin Name: Notation Articles 
 * Plugin URI: #
 * Description: The very first plugin that I have ever created.
 * Version: 1.0
 * Author: Your Name
 * Author URI: #
 */
require_once(WP_PLUGIN_DIR.'/reviews/ajax/ajax.php');
require_once(WP_PLUGIN_DIR.'/reviews/article_notation.php');
require_once(WP_PLUGIN_DIR.'/reviews/evaluation.php');
require_once(WP_PLUGIN_DIR.'/reviews/notes.php'); 
use REVIEWS\AJAX_REQ as AJAX_REQ_APP;





 
function theme_name_scripts() {
   $front_end_url = plugins_url('/reviews/ajax/js/frontend_ajax.js');
   wp_enqueue_script( 'script-name',$front_end_url , array('jquery'), '1.0.0', true );
  wp_localize_script( 'script-name', 'MyAjax', admin_url( 'admin-ajax.php' ));   
}

 function my_action_callback() {
 if(!is_user_logged_in()){
           echo array("message" => "Veuillez vous connecter!");
           die;
 }else{
        $ajax_req_app = new AJAX_REQ_APP();
  $whatever = $_POST['whatever'] ;
  $evaluate = array("nb_etoiles" => $whatever[0] ,"post_id" => $whatever[1] , "user_ip" => $whatever[2] );
   
  $ajax_req_app->load_css();
  $ajax_req_app->send_request($evaluate); 
  $article_notation = new Articles_Notation($ajax_req_app);

  $eval = new Evaluation();

  $eval->set_Eval( $article_notation);
    
  $eval->create_table();
  
  $eval->update_eval();
  
  $notes = new Notes(); 


  $data_sync = $eval->render_eval_output($whatever[0] ,$notes->get_all_note_by_id($whatever[1]) );
  
  echo $data_sync;
  
  die();  
 }
 
}
  add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
  add_action( 'wp_ajax_my_action', 'my_action_callback' );


add_filter( 'the_content', 'article_notation_show' );
function article_notation_show ( $content ) {
    $ajax_req_app = new AJAX_REQ_APP();
    $ajax_req_app->load_css();
   global $post;
	$notes = new Notes();  
  
  $notes->set_Note($post->ID);
   
  $note_content ="<p class='note'>"; 
  $note_content .= $notes->get_all_note_by_id($post->ID);
  $note_content .= "notes </p>";
  $eval = new Evaluation();

 $content .="<div id='icon-star-".$post->ID."'><i style='color:gray;' class='fa fa-star' data-name='1' aria-hidden='true'></i><i style='color: gray;' class='fa fa-star icon-star-2' aria-hidden='true' data-name='2'></i><i style='color: gray;' class='fa fa-star icon-star-3' data-name='3' aria-hidden='true'></i><i style='color: gray;' class='fa fa-star icon-star-4' data-name='4' aria-hidden='true'></i><i style='color: gray;' class='fa fa-star icon-star-5' data-name='5' aria-hidden='true'></i></div><div id='not-login-".$post->ID."'></div><style>.fa-star:hover{color :  #0073aa;}</style>";

  $content .='<script>
  jQuery("#post-'.$post->ID.' .entry-meta").append("'.$note_content.'")
  jQuery("#icon-star-'.$post->ID.' i").mouseenter(function(e){
                jQuery(e.currentTarget).attr("style",  "color:#0073aa")
                
    })
    jQuery("#icon-star-'.$post->ID.' i").mouseleave(function(e){
                jQuery(e.currentTarget).attr("style",  "color:gray")
                
    })
    jQuery("#icon-star-'.$post->ID.' i").click(function(e){
              console.log(e.currentTarget.dataset.name)

              load_ajax(e.currentTarget.dataset.name , '.$post->ID.' , '.get_current_user_id().')
     
      })
  </script>';

  // $contenu .="<script> console.log(".$ajax_req_app->ajax_front_end().") </script>" ;
  

   return $content;
}

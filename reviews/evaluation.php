<?php
class Evaluation  {
	   /**-- Pour l' attribution de notes : type int (var notes) --**/
	   private $note ;
	   private $eval_note;
    
	   /*-- Mettre à jours la notation de visiteurs pour chaque articles--**/

       public function set_Eval(Articles_Notation $articles_notation){
       	$note = 1;
       
       	$data_notation = json_encode($articles_notation);
        $this->eval_note = array( 'nb_etoiles' => $articles_notation->nb_etoiles , 'user_ip' =>$articles_notation->user_ip ,  'post_id' => $articles_notation->post_id , 'note' => $note ) ;           
         
       }
       public function add_eval(){
        
         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');   
           global $wpdb;
              $insert_sql = $wpdb->prepare("INSERT INTO `wp_evaluation`  VALUES (NULL , %s, %s, %s, %s)" ,$this->eval_note['user_ip'] , $this->eval_note['note'] , $this->eval_note['nb_etoiles'],$this->eval_note['post_id'] );
              $wpdb->query($insert_sql); 
       }
       public function update_eval(){
        
          require_once(ABSPATH . 'wp-admin/includes/upgrade.php');   
           global $wpdb;
    
          $data_eval = $wpdb->get_results("SELECT * FROM `wp_evaluation` WHERE `post_id` ='{$this->eval_note['post_id']}' AND `user_ip` = '{$this->eval_note['user_ip']}'" );
            echo $sql;
          if(empty($data_eval)){
              $this->add_eval(); 
            
          }
        
        }
          
          
           
       
       public function create_table(){
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            global $wpdb;
            
            $tablename = 'wp_evaluation';
            if ($wpdb->get_var("SHOW TABLES LIKE '$tablename'") == NULL){
             $sql  = 'CREATE TABLE wp_evaluation(
                id INT(20) AUTO_INCREMENT,
                user_ip VARCHAR(255),
                note VARCHAR(255),
                nb_etoiles VARCHAR(255),
                post_id VARCHAR(255),
                PRIMARY KEY(id))';

    
         dbDelta($sql);

            } 
       
       }
       public function get_Eval(){
           // $eval_note = get_post_meta($this->post_id );
             return $this->eval_note;
       }

       public function render_eval_output($eval , $notes){
          $content_notes = [];
          for($i=1; $i < intval($eval) + 1 ; $i++){
              $content_notes[$i] .= "<i style='color:#0073aa;' class='fa fa-star icon-star-".$i."' data-name='".$i."' aria-hidden='true'>" ;
          }
          
          if(count($content_notes) < 5){
          
             for($j = count($content_notes) + 1 ; $j < 6 ; $j++){
              $content_notes[$j] .= "<i style='color:gray;' class='fa fa-star  icon-star-".$j."' data-name='".$j."' aria-hidden='true'>";    
             }

          }
          $content_notes[6] .= "<p>".intval($eval)." Etoiles attribués</p>";
          $content_notes[7] .="<span class='note_p' style='display:none;' > ".$notes."notes</span>";
          return json_encode($content_notes);
          


       }

}

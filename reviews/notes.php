<?php
class Notes {
 private $notes_eval_total;
 private $select_notes;
 private $post_id;
 
 public function set_Note($id){
         if($eval == NULL){
             $this->notes_eval_total = "Not Found";         
         }
        
        $this->select_notes = $this->query_select_notes($id) ;
 }
 public function query_select_notes($id){
       global $wpdb;
       
       $select_note = $wpdb->get_results('SELECT * FROM `wp_evaluation` WHERE `post_id` = '.$id  );
       return $select_note;
   
 }
 public function get_Note(){
         return count($this->select_notes);
   
 }
 public function get_all_note_by_id($id){

        return count($this->query_select_notes($id));
   
 }

}

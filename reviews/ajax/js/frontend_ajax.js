function load_ajax(nb_etoiles , post_id , user_ip ){
jQuery(document).ready(function($) {
  var params = [nb_etoiles , post_id , user_ip ]
  var data = {
    action: 'my_action',
  //  security : MyAjax.security,
    whatever: params
  };

  $.post(MyAjax, data, function(response) {
  //alert('Got this from the server: ' + response);
    
    if(response == 0){
           jQuery("#not-login-"+post_id).html("<p>Veuillez vous connectez!</p>")
           console.log("#icon-star-"+post_id +'connectez')
           console.log(jQuery("#icon-star-"+post_id))
     }else{
           jQuery("#icon-star-"+post_id).html(Object.values(JSON.parse(response)))		
        
  		  jQuery("#post-"+post_id+" .entry-meta .note").html(Object.values(JSON.parse(response))[6])
   		  jQuery("#post-"+post_id+" .entry-meta .note .note_p").attr("style" , "display:block")
    	  console.log(Object.values(JSON.parse(response))[6])
    	  console.log(jQuery("#post-"+post_id+" .entry-meta .note"))

     }
    

  });

});
}

<?php 
 /**
 * 
 */
 class BookingSession 
 {
 	
 	public function __construct()
 	{
 		session_start();
 	}
 
  # cheeck authentication 
  public function checkAuth ()
  {
  	if( isset($_SESSION['login']) && $_SESSION['login'] ){
  		return true;
  	} else {
  		return false;
  	}
  }

  # logout 
  public function logout (){
  	if(session_destroy()){
  		return true;
  	}
  	return false;
  }
 }
 new BookingSession();

?>
<?php 
  /**
  * User Home 
  */
  include '../inc/session.php';
  class Home 
  {
  	
  	public function __construct()
  	{
      $auth = BookingSession::checkAuth();
      if( !$auth ) {
        header('location:/');
        exit;
      }
  		$this->userHome();
  	}

  	# home or dashboard 
  	public function userHome(){
  		include '../views/user-home.php';
      exit();
  	}
  }
  new Home;
?>
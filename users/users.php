<?php 
/**
* 
*/
include 'model.php';
include '../inc/session.php';
class Users
{

	private $model;
	
	function __construct()
	{	
		# model class instance
		$this->model = new UsersModel();
    # check action
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : false;

    switch ($action) {
    	case 'login':
    		# login 
    		$this->login($_POST);
    		break;
    	case 'logout':
    		# logout
    		$this->logout();
    		break;
    	default:
    		header('location:/');
    		exit();
    		break;
    }
	}

	# login 
	public function login($postData = false)
	{
		$output = [];
		$output['status'] = false;
		$output['msg'] = 'Opps! Something went wrong';
		if ( $postData ) {
			$credentials = array(
				'email'    => $postData['email'],
				'password' => md5($postData['password'])
			);

			if ( !empty($credentials) ) {
	      $res = $this->model->checkLogin($credentials);
	      if ( $res ) {
	      	$users = $res->fetch_object();
	      	$_SESSION['users'] = $users;
	      	$_SESSION['name']  = $users->name;
	      	$_SESSION['email'] = $users->email;
	      	$_SESSION['id']    = $users->id;
	      	$_SESSION['login'] = true;
	      	$output['status']  = true;
	      	$output['msg']     = "Success! Logedin.";
	      } else {
	      	$output['msg'] = 'Opps! Credentials mismatch';
	      }
			} else {
				$output['msg'] = "Fillup Credentials";
			}
		}		
		echo json_encode($output);
		die();
	}

	# logout 
	public function logout()
	{
		$output['status'] = false;
		$check = BookingSession::logout();
		if( $check ){
			$output['status'] = true;
		}
		echo json_encode($output);
	}
}
new Users;
?>
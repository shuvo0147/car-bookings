<?php 
 /**
 * UserModel class 
 */

 # include db confiq
 // require_once __FILE__.'bookings/inc/db_confiq.php';
 // include 'users.php';
 include '../inc/db-config.php';

 class UsersModel extends DBConfiq
 {

 	private $newConn = null;
 	private $usersTbl = 'users';
 	private $bookingsTbl = 'bookings'; 
 	private $destinationTbl = 'destination';
 	private $carsTbl = 'cars';

 	public function __construct()
 	{
 		parent::__construct();
 	}

 	# check authentication 
 	public function checkLogin($credentials)
 	{
 		if ( !empty($credentials) ) {
	 		$query = "SELECT id,name,email,role,created_at FROM " . $this->usersTbl . " WHERE email ='" . $credentials['email'] . "' AND password='" . $credentials['password'] . "' LIMIT 0,1";
	 		$result = $this->conn->query($query);
	 		if( $result->num_rows > 0 ){
	 			return $result;
	 		}
 		}

 		return false;
 	}

 	# get all cars 

 	public function getCars()
 	{
 		$sql = "SELECT * FROM " . $this->carsTbl . " ORDER BY created_at DESC";
 		$result = $this->conn->query($sql);
 		if ( $result->num_rows > 0 ) {
 			return $result->fetch_all(MYSQLI_ASSOC);
 		}
 		return false;
 	}

 	# get Destinations 
 	public function getDestinations()
 	{
 		$sql = "SELECT * FROM " . $this->destinationTbl . " ORDER BY `created_at` DESC";
 		$result = $this->conn->query($sql);
 		if ( $result->num_rows > 0 ) {
 			return $result->fetch_all(MYSQLI_ASSOC);
 		} 
 		return false;
 	}

 	# get all bookings 
 	public function getAllBookings($userId)
 	{
 		$sql = "SELECT u.id,u.name,u.email,b.id as bookId,b.*,
 		(SELECT name FROM ".$this->carsTbl." as c WHERE c.id =b.car_number LIMIT 1) carName,
 		(SELECT name FROM ".$this->destinationTbl." as d WHERE d.id =b.destination LIMIT 1) destiName,
 		 (SELECT name FROM " . $this->destinationTbl . " as p WHERE p.id = b.pickup_from LIMIT 1) pickName
 		 FROM " . $this->bookingsTbl . " as b JOIN " . $this->usersTbl . " as u ON b.user_id = u.id WHERE b.user_id =" . $userId . " ORDER BY b.booked_at DESC LIMIT 20";
 		$result = $this->conn->query($sql);
 		if( $result->num_rows > 0 ){
 			return $result;
 		}
 		return false;
 	}

 	# check booking exist or not 
 	public function checkBook($data,$userId = false)
 	{
 		$sql ="SELECT * FROM bookings WHERE car_number =".$data['car']." AND ( booking_time < return_time AND
        '".$data['booked']."' BETWEEN booking_time AND return_time  OR
        '".$data['returned']."' BETWEEN booking_time AND return_time )";
    if ( $userId ) {
      $sql .= " AND user_id <> ".$userId." LIMIT 0,1";
    }
 	  $check = $this->conn->query($sql);
		if ( $check->num_rows > 0 ) {
			return false;	
		}
	  return true;
 	}

 	# bookings 
 	public function bookings($postData = false)
 	{
 		if ( $postData ) {
 			$sql = "INSERT INTO " . $this->bookingsTbl . " (`user_id`, `destination`, `car_number`, `booking_time`, `return_time`, `pickup_from`, `passengers`, `booked_at`) VALUES ('".$postData['userId']."','".$postData['destination']."','".$postData['car_number']."','".$postData['booking_time']."','".$postData['return_time']."','".$postData['pickup_from']."','".$postData['passengers']."','".$postData['booked_at']."') "; 
 			$result = $this->conn->query($sql);
 			if ( $result ) {
 				return true;
 			}
 		}
 		return false;
 	}

 	# booking by ID 
 	public function getBookingById($bookingId,$userId)
 	{
 		$sql = "SELECT * FROM " .$this->bookingsTbl ." WHERE user_id =" . $userId . " AND id =" . $bookingId . " LIMIT 1";
 		$result = $this->conn->query($sql);
 		if ( $result->num_rows >0 ) {
 			return $result->fetch_object();
 		}
 		return false;
 	}

 	# update booking 
 	public function updateBooking($param,$userId)
 	{
 		$sql = "UPDATE " . $this->bookingsTbl . " SET destination=" .$param['destination'] .",car_number =". $param['car'] .",booking_time='" . $param['booked'] . "',return_time='" . $param['returned'] . "',pickup_from=" . $param['pickup'] . ",passengers=" . $param['passengers'] . " WHERE id=".$param['id'] . " AND user_id=".$userId."";
 		$result = $this->conn->query($sql);
 		if ( $result ) {
 		 	return true;
 		} 
 		return false;
 	}

 	# delete booking 
 	public function deleteBooking($id,$userId)
 	{
 		$sql = "DELETE FROM " . $this->bookingsTbl . " WHERE id=" . $id . " AND user_id=" . $userId;
 		return $this->conn->query($sql);
 	}
 }
 # invoke class  
 new UsersModel;
?>

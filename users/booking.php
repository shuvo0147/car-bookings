<?php 
/**
*  Bookking listview class 
*/
include '../inc/session.php';
include 'model.php';
class Booking 
{
  private $model;
  private $userId;
  public function __construct()
  {
    #check authentication
    $auth = BookingSession::checkAuth();
    if( !$auth ) {
      header('location:/');
      exit;
    }

    # loged in user id 
    $this->userId = isset($_SESSION['id']) ? $_SESSION['id'] : false;
    #init user model
    $this->model = new UsersModel();
    # request action 
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : false;
    switch ($action) {
      case 'add-booking':
        $this->addBooking();
        break;
      case 'booking':
        $this->saveBooking($_POST);
        break;
      case 'edit-booking':
        $bookingId = isset($_GET['bookId']) ? $_GET['bookId'] : false;
        $this->editBooking($bookingId);
        break;
      case 'update-booking':
        $this->updateBooking($_POST);        
        break;
      case 'delete-booking':
        $this->deleteBooking($_POST);        
        break;      
      default:
        $this->bookingList();
        break;
    }
	}

  # view page of booking 
  public function bookingList()
  {
  	$userId  = $this->userId;
  	if ( $userId ) {
  		$data = [];
	  	$booking = $this->model->getAllBookings($userId);
	  	if( $booking ){
        $i = 0;
	  		while( $row = $booking->fetch_assoc() ){
          $data[$i]['id']       = $row['bookId'];
          $data[$i]['name']     = $row['name'];
          $data[$i]['email']    = $row['email'];
          $data[$i]['cars']     = $row['carName'];
          $data[$i]['destination'] = $row['destiName'];
          $data[$i]['pickup']   = $row['pickName'];
          $data[$i]['booked']   = date('Y-m-d H:i',strtotime($row['booking_time']));
          $data[$i]['returned'] = date('Y-m-d H:i',strtotime($row['return_time']));
          $data[$i]['bookedAt'] = $row['booked_at'];
          $i++;
        }
	  	} 
  		include '../views/booking-list.php';
	  	exit();
  	}
  }

  # booking view
  public function addBooking()
  {

    $cars = $this->model->getCars();
    $destinations = $this->model->getDestinations();
  	include('../views/booking-add.php');
  	exit();
  }
  
  # save booking  
  public function saveBooking($postData = false)
  {
    $output = [];
    $userId = $this->userId;
    $output['status'] = false;
    $output['msg'] = "Opps! Something went wrong. ";

    if ( $userId ) {
      # booked empty 
      if ( $postData ) {
        # check booking exist 
        $check = $this->model->checkBook($postData);
        if ( $check ) {
          # process booking data
          $bookings = array(
            'userId'      => $userId,
            'destination'  => $postData['destination'],
            'car_number'   => $postData['car'], 
            'booking_time' => $postData['booked'],
            'return_time'  => $postData['returned'],
            'pickup_from'  => $postData['pickup'],
            'passengers'   => $postData['passengers'],
            'booked_at'    => date('Y-m-d h:i:s')
          );

          # save booking 
          $res = $this->model->bookings($bookings);
          if( $res ) {
            $output['status'] = true;
            $output['msg']    = "<strong>Success!</strong> Save bookings.";
          } else {
            $output['msg'] = "<strong>Opps!</strong> Failed to save."; 
          }
        } else {
          $output['msg'] = "<strong>Opps!</strong>Already booked.<hr><p>Please try again with diffrent time.</p>"; 
        }
      } 
    } 
    echo json_encode($output);
  }

  # edit booking 
  public function editBooking($bookingId)
  {
    $userId = $this->userId;
    if ( $userId ) {
      if ( $bookingId ) {
        $cars   = $this->model->getCars();
        $destinations = $this->model->getDestinations();
        $bookings = $this->model->getBookingById($bookingId,$userId);
        if ( $bookings ) {
          include '../views/booking-edit.php';
          exit();
        } else {
          include '../views/booking-edit.php';
          exit();
        }
      } else {
        $this->bookingList();    
      }
    }
  }

  # update booking 
  public function updateBooking($postData)
  {
    $output = [];
    $userId = $this->userId;
    $output['status'] = false;
    $output['msg'] = "Opps! Something went wrong.";
    if ( $userId ) {
      $check = $this->model->checkBook($postData,$userId);
      if ( $check ) {
        $res = $this->model->updateBooking($postData,$userId);
        if ( $res ) {
          $output['status'] = true;
          $output['msg'] = "Success! Update save.";
        } else {
          $output['msg'] = "Opps! Update failed.";
        }
      } else {
        $output['msg'] = "<strong>Opps!</strong>Already booked.<hr><p>Please try again with diffrent time.</p>";
      }
    }
    echo json_encode($output);
  }

  # delete booking 
  public function deleteBooking($postData)
  {
    $output = [];
    $userId = $this->userId;
    $output['status'] = false;
    $output['msg']    = "Opps! Something went wrong";
    if( $userId ) {
      $res = $this->model->deleteBooking($postData['id'],$userId);
      if ( $res ) {
        $output['status'] = true;
        $output['msg']    ="Success! Delete booking.";
      } else {
        $output['msg'] = "Opps! Delete failed";
      }
    }
    echo json_encode($output);
  }
}
new Booking();

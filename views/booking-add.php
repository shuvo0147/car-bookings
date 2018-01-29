<?php include '../layout/header.php'; ?>
<?php include '../layout/navbar.php'; ?>
  <div class="row mt-3">
  	<div class="col-md-10">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/users/home.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Add Bookings</li>
			  </ol>
			</nav>
			<div class="addActionMsg p-1"></div>
			<form class="border p-3" id="bookingForm">
			  <div class="form-row">
			    <div class="form-group col-md-6">
			      <label for="inputEmail4">Destination</label>
			      <select class="form-control" name="destination">
			      	<option value="">Choose</option>
			      	<?php if( $destinations ) { ?>
			      		<?php foreach ($destinations as $key => $desti) { ?>
			      		<option value="<?php echo $desti['id']; ?>"><?php echo $desti['name']; ?></option>
			      		<?php } ?>
			      	<?php } ?>
			      </select>
			    </div>
			    <div class="form-group col-md-6">
			      <label for="inputPassword4">Cars</label>
			      <select class="form-control" name="car">
			      	<option value="">Choose</option>
			      	<?php if ( $cars ) { ?>
			      		<?php foreach ($cars as $car) { ?>
			      			<option value="<?php echo $car['id']; ?>"><?php echo $car['name'].' ('.$car['number'].')' ?></option>
			      		<?php } ?>
			      	<?php } ?>
			      </select>
			    </div>
			  </div>
			  <div class="form-row">
			    <div class="form-group col-md-6">
			      <label for="inputEmail4">Booking Time</label>
			      <input type="text" name="booked" id="datetimepicker" class="form-control datePicker" value="" id="inputCity">	
			    </div>
			    <div class="form-group col-md-6">
			      <label for="inputPassword4">Return Time</label>
			      <input type="text" name="returned" class="form-control datePicker" value="" id="inputCity">			    
			    </div>
			  </div>
			  <div class="form-row">
			    <div class="form-group col-md-6">
			      <label for="inputEmail4">Pickup</label>
			      <select class="form-control" name="pickup">
			      	<option value="">Choose</option>
			      	<?php if( $destinations ) { ?>
			      		<?php foreach ($destinations as $key => $desti) { ?>
			      		<option value="<?php echo $desti['id']; ?>"><?php echo $desti['name']; ?></option>
			      		<?php } ?>
			      	<?php } ?>
			      </select>
			    </div>
			    <div class="form-group col-md-6">
			      <label for="inputPassword4">Passengers</label>
			      <input class="form-control" name="passengers" type="number">
			    </div>
			  </div>
			  <button type="submit" id="bookingBtn" class="btn btn-info btm-md">Submit</button>
			</form>
  	</div>
  </div>
<?php include '../layout/footer.php'; ?>


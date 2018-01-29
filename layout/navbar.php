<nav class="navbar navbar-expand-md navbar-light bg-light">
	  <a class="navbar-brand" href="/users/home.php"><h2>Booking</h2></a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    </ul>
	  <ul class="navbar-nav ml-auto">
	  	<li class="nav-item">
	  		<a class="nav-link" href="/users/booking.php">
	  			<i class="fa fa-car" aria-hidden="true"></i> 
	  		Bookings</a>
	  	</li>
	  	<li class="nav-item">
	  		<a class="nav-link" href="#">
	  			<i class="fa fa-user-circle" aria-hidden="true"></i>
          <?php echo  isset($_SESSION['name']) ? $_SESSION['name']:'Demo' ?>
	  		</a> 
	  	</li>
	    <li class="nav-item">
	      <a class="nav-link" href="javascript:void(0)" id="logoutBtn">
	      	<i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
	    </li>
	  </ul>
  </div>
</nav>

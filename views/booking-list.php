<?php include '../layout/header.php'; ?>
<?php include '../layout/navbar.php'; ?>
  <div class="row mt-3">
  	<div class="col-md-12">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/users/home.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Bookings</li>
			  </ol>
			</nav>
			<div class="row mb-3">
				<div class="col-md-2">
					<a href="/users/booking.php?action=add-booking" class="btn btn-info text-white"><i class="fa fa-plus"></i> Add New</a>
				</div>
				<div class="col-md-10">
					<div class="actionMsg pt-1"></div>
				</div>
			</div>
			<table class="table-sm table-bordered table">
				<thead class="thead-light">
					<tr>
						<th>SL.</th>
						<th>Destination</th>
						<th>Pickup</th>
						<th>Cars</th>
						<th>Booked Time</th>
						<th>Returned Time</th>
						<th>Booked</th>
						<th>Status</th>
						<th class="text-right">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if( !empty($data) ) {  ?>
						<?php foreach ($data as $i => $value) { ?>
							<tr>
								<td> <?php echo $i+1; ?></td>
								<td> <?php echo $value['destination'];?> </td>
								<td> <?php echo $value['pickup'];?> </td>
								<td> <?php echo $value['cars'];?></td>
								<td> <?php echo $value['booked']; ?></td>
								<td> <?php echo $value['returned']; ?></td>
								<td> <?php echo $value['bookedAt']; ?></td>
								<td> <label class="badge badge-success">Booked</label></td>
								<td class="text-right"> 
									<a href="/users/booking.php?action=edit-booking&bookId=<?php echo $value['id'];?>" class="btn btn-outline-info btn-sm">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</a> 
									<a href="#" data-id="<?php echo $value['id'];?>" class="btn btn-outline-danger btn-sm deleteBtn">
										<i class="fa fa-times-circle" aria-hidden="true"></i>
									</a>
								</td>
							</tr>
						<?php } ?>
					<?php } else { ?>
					 <tr><td colspan="9" class="text-center">No booking found.</td></tr> 
					 <?php } ?>
				</tbody>
				<tfoot>
					
				</tfoot>
			</table>
  	</div>
  </div>
<?php include '../layout/footer.php'; ?>


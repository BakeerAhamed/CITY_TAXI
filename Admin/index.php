<?php require 'header.php';?>
<?php require '../config/config.php';?>

<?php
// Database connection settings
$host = 'localhost'; // Your database host
$db = 'CityTaxi_db'; // Your database name
$user = 'root'; // Your database user
$pass = ''; // Your database password

$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to count users
$sql = "SELECT COUNT(*) as user_count FROM users";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$userCount = $row['user_count'];




// Query to count Vehicles
$sql = "SELECT COUNT(*) as vehicle_count FROM vehicles"; 
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$vehicle_count = $row['vehicle_count'];


// Query to count Bookings
$sql = "SELECT COUNT(*) as booking_count FROM bookings"; 
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$booking_count = $row['booking_count'];

// Close connection
$conn->close();




?>



<div class="container-fluid">         
  <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Users</h5>
                
                <p class="card-text">Number of Users: <?php echo $userCount; ?></p>
              
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Vehicles</h5>
                <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
                <p class="card-text">Number of Vehicles: <?php echo $vehicle_count; ?></p>
              
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Bookings</h5>
                <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
                <p class="card-text">Number of Bookings: <?php echo $booking_count; ?></p>
              
              </div>
            </div>
          </div>

  </div>           
</div>
<?php require 'footer.php';?>

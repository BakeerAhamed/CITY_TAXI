<?php require 'header.php'; ?>
<?php require '../config/config.php'; ?>

<?php
// Fetch all vehicles from the database
$query = "SELECT bid, passenger_id, vehicle_id, pickup_location, dropoff_location,pickup_time,dropoff_time,distance_km,cost,status FROM bookings";
$result = $pdo->query($query);
$vehicles = $result->fetchAll(PDO::FETCH_ASSOC);

// Update the vehicle status if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleId = $_POST['vehicle_id']; // Get the vehicle ID from the form
    $newStatus = 'Busy'; // Set the new status to 'Busy'
    
    // Update the vehicle's status in the database
    $updateQuery = "UPDATE bookings SET status = :status WHERE bid = :bid";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute(['status' => $newStatus, 'bid' => $vehicleId]);

    // Redirect to the same page to refresh the vehicle status
    header("Location: manage_bookings.php");
    exit();
}
?>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4 d-inline">Booking Management Details</h5>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">passenger_id</th>
                                    <th scope="col">vehicle_id</th>
                                    <th scope="col">pickup_location</th>
                                    <th scope="col">dropoff_location</th>
                                    <th scope="col">pickup_time</th>
                                    <th scope="col">dropoff_time</th>
                                    <th scope="col">distance_km</th>
                                    <th scope="col">cost</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($bookings)): ?>
                                    <?php foreach ($bookings as $index => $bookings): ?>
                                        <tr>
                                            <th scope="row"><?php echo $index + 1; ?></th>
                                            <td><?php echo htmlspecialchars($bookings['passenger_id']); ?></td>
                                            <td><?php echo htmlspecialchars($bookings['vehicle_id']); ?></td>
                                            <td><?php echo htmlspecialchars($bookings['pickup_location']); ?></td>
                                            <td><?php echo htmlspecialchars($bookings['dropoff_location']); ?></td>
                                            <td><?php echo htmlspecialchars($bookings['pickup_time']); ?></td>
                                            <td><?php echo htmlspecialchars($bookings['dropoff_time']); ?></td>
                                            <td><?php echo htmlspecialchars($bookings['distance_km']); ?></td>
                                            <td><?php echo htmlspecialchars($bookings['cost']); ?></td>
                                            <td><?php echo htmlspecialchars($bookings['status']); ?></td>
                                            <td>
                                                <!-- Form to update the vehicle status to 'Busy' -->
                                                <?php if ($bookings['status'] != 'Busy'): ?>
                                                    <form action="manage_bookings.php" method="POST">
                                                        <input type="hidden" name="vehicle_id" value="<?php echo $bookings['bid']; ?>">
                                                        <button type="submit" class="btn btn-warning">Set as Busy</button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted">Busy</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No vehicles found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require 'footer.php'; ?>

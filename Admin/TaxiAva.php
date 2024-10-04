<?php require 'header.php'; ?>
<?php require '../config/config.php'; ?>

<?php
// Fetch available vehicles from the database
$query = "SELECT Driver, vehicle_model, vehicle_plate_no, No_of_Seat, vehicle_Status FROM vehicles WHERE vehicle_Status = 'available'";
$result = $pdo->query($query);
$vehicles = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4 d-inline">Taxi Availability Details</h5>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Driver</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Vehicle No</th>
                                    <th scope="col">No of Seat</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($vehicles)): ?>
                                    <?php foreach ($vehicles as $index => $vehicle): ?>
                                        <tr>
                                            <th scope="row"><?php echo $index + 1; ?></th>
                                            <td><?php echo htmlspecialchars($vehicle['Driver']); ?></td>
                                            <td><?php echo htmlspecialchars($vehicle['vehicle_model']); ?></td>
                                            <td><?php echo htmlspecialchars($vehicle['vehicle_plate_no']); ?></td>
                                            <td><?php echo htmlspecialchars($vehicle['No_of_Seat']); ?></td>
                                            <td><?php echo htmlspecialchars($vehicle['vehicle_Status']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No available vehicles found</td>
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

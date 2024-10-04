<?php

include '../config/config.php';
include '../models/KmRate.php'; 

// Create an instance of RateClass
$rateClass = new RateClass($pdo);

// Retrieve the current kmRate
$response = $rateClass->getKmRate();
$currentKmRate = $response['success'] ? $response['kmRate'] : ''; // Set currentKmRate to the fetched value or an empty string

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the kmRate from the form
    $kmRate = $_POST['kmRate'];

    // Call the updateKmRate method
    $response = $rateClass->updateKmRate($kmRate);

    // Return the response
    echo json_encode($response);
}
?>

<?php require 'header.php';?>
<main>
    <div class="container-fluid">
        <!---Area---->
                    <div class="row">
                    <div class="col">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title mb-5 d-inline">Update KM Rate</h5>
                        <form method="POST" action="kmrate.php" enctype="multipart/form-data">
                              <!-- Per Kilometer Charges input -->
                            <div class="col-md-6 form-outline mb-4 mt-4">
                                <label for="">Per Kilometer Charges</label>
                            <input type="number" name="kmRate" value="<?php echo htmlspecialchars($currentKmRate); ?>" class="form-control" placeholder="" />
                            </div>
                            <!-- Submit button -->
                            <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Update</button>
                        </form>
                        </div>
                         </div>
                       </div>
                     </div>

        <!---Area---->
    </div>
</main>
<?php require 'footer.php';?>
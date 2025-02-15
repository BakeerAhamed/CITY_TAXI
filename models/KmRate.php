<?php

class RateClass {
    private $pdo;

    // Constructor to establish a database connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to update the kmRate
    public function updateKmRate($kmRate) {
        // Validate the input
        if (!is_numeric($kmRate)) {
            return ['success' => false, 'message' => 'Invalid kmRate.'];
        }

        try {
            // Prepare the SQL statement to update the kmRate
            $stmt = $this->pdo->prepare("UPDATE taxi_rates SET kmRate = :kmRate where id='1'"); // Adjust the table name and condition
            $stmt->execute(['kmRate' => $kmRate]);

            // Check if the update was successful
            if ($stmt->rowCount() > 0) {
                header('Location:kmrate.php');
                exit;
            } else {
                return ['success' => false, 'message' => 'No changes made or record not found.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Update failed: ' . $e->getMessage()];
        }
    }
    //-------------------------------------------------------------------------------------------------------------------------------------//
     // Method to get the current kmRate
     public function getKmRate() {
        try {
            // Prepare the SQL statement to select the kmRate
            $stmt = $this->pdo->prepare("SELECT kmRate FROM taxi_rates where id='1'"); // Adjust the table name and condition
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if a result was found
            if ($result) {
                return ['success' => true, 'kmRate' => $result['kmRate']];
            } else {
                return ['success' => false, 'message' => 'No rate found.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Failed to retrieve kmRate: ' . $e->getMessage()];
        }
    }
}
?>

<?php
class Booking {
    private $pdo;

    // Constructor to establish a database connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to create a new booking
    public function createBooking($passengerId, $vehicleId, $pickupLocation, $dropoffLocation, $pickupTime, $dropoffTime, $distanceKm, $cost, $status = 'Pending') {
        if (empty($passengerId) || empty($vehicleId) || empty($pickupLocation) || empty($dropoffLocation) || empty($pickupTime) || empty($distanceKm) || empty($cost)) {
            return ['success' => false, 'message' => 'All fields must be provided'];
            header("Location: booking.php"); // Redirect back to booking page
        }
        try {
            $stmt = $this->pdo->prepare("INSERT INTO bookings (passenger_id, vehicle_id, pickup_location, dropoff_location, pickup_time, dropoff_time, distance_km, cost, status) 
                                          VALUES (:passenger_id, :vehicle_id, :pickup_location, :dropoff_location, :pickup_time, :dropoff_time, :distance_km, :cost, :status)");

            // Bind parameters
            $stmt->bindParam(':passenger_id', $passengerId);
            $stmt->bindParam(':vehicle_id', $vehicleId);
            $stmt->bindParam(':pickup_location', $pickupLocation);
            $stmt->bindParam(':dropoff_location', $dropoffLocation);
            $stmt->bindParam(':pickup_time', $pickupTime);
            $stmt->bindParam(':dropoff_time', $dropoffTime);
            $stmt->bindParam(':distance_km', $distanceKm);
            $stmt->bindParam(':cost', $cost);
            $stmt->bindParam(':status', $status);

            // Execute the statement
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Booking created successfully!'];
            } else {
                return ['success' => false, 'message' => 'Failed to create booking.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function getBookingDetails($passengerId) {
        try {
            // Prepare the SQL statement to fetch booking details for the specific passenger
            $stmt = $this->pdo->prepare("SELECT
                                            bookings.bid,
                                            bookings.passenger_id,
                                            users.email,
                                            users.username,
                                            users.ContactNO,
                                            bookings.vehicle_id,
                                            bookings.pickup_location,
                                            bookings.dropoff_location,
                                            bookings.pickup_time,
                                            bookings.dropoff_time,
                                            bookings.distance_km,
                                            bookings.cost,
                                            bookings.status,
                                            bookings.created_at,
                                            bookings.updated_at
                                        FROM 
                                            bookings
                                        INNER JOIN 
                                            users ON bookings.passenger_id = users.id
                                        WHERE 
                                            bookings.passenger_id = :passenger_id  AND status != 'Dropped'"); // Use :passenger_id here
                                            
            // Bind the passenger ID correctly
            $stmt->bindParam(':passenger_id', $passengerId, PDO::PARAM_INT); // Use :passenger_id here
        
            // Execute the statement
            $stmt->execute();
        
            // Fetch all booking details as an associative array
            $bookingDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            // Check if any booking details were found
            if ($bookingDetails) {
                return ['success' => true, 'data' => $bookingDetails]; // Return the booking details
            } else {
                return ['success' => false, 'message' => 'No bookings found for this passenger.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()]; // Return error message
        }
    }
    

    public function cancelBooking($bid) {
        try {
            // Prepare the SQL statement to update booking status to 'Cancelled' only if it's currently 'Pending'
            $stmt = $this->pdo->prepare("UPDATE bookings 
                                         SET status = 'Dropped' 
                                         WHERE bid = :bid AND status = 'Pending'");
            
            // Bind the booking ID parameter
            $stmt->bindParam(':bid', $bid, PDO::PARAM_INT);
            
            // Execute the update query
            $stmt->execute();
    
            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Booking has been successfully cancelled.'];
            } else {
                return ['success' => false, 'message' => 'Booking could not be cancelled. Either it was not found or its status is not "Pending".'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()]; // Return error message
        }
    }
    
    
}
?>

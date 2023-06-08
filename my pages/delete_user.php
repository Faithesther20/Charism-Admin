<?php
include "connection.php";
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the userId parameter from the request
    $userId = $_POST["userId"];

    // Your database connection code here

    // Prepare the DELETE statement
    $query = "DELETE FROM users WHERE userId = ?";

    // Prepare and bind the parameters
    $statement = $mysqli->prepare($query);
    $statement->bind_param("i", $userId);

    // Execute the DELETE statement
    if ($statement->execute()) {
        // Return a success response
        http_response_code(200);
        // echo "User deleted successfully";
        
    } else {
        // Return an error response
        http_response_code(500);
        echo "Error deleting user";
    }
    echo '<script>window.location.reload();</script>';

    // Close the statement and database connection
    $statement->close();
    $mysqli->close();
} else {
    // Return an error response if the request method is not POST
    http_response_code(405);
    echo "Method Not Allowed";
}
?>

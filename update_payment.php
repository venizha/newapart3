<?php
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
  

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Your database connection parameters
    $dbhost = 'localhost';
    $dbname = 'postgres';
    $dbuser = 'postgres';
    $dbpass = 'Keerthi23';

    // Create a database connection
    $conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    if (!$conn) {
        die("Connection failed. Error: " . pg_last_error());
    }

    // Insert payment details into the payments table
    $insertPaymentQuery = "INSERT INTO payments ( name, email, phone) VALUES ($1, $2, $3)";
    $insertPaymentResult = pg_query_params($conn, $insertPaymentQuery, array( $name, $email, $phone));

    if ($insertPaymentResult) {
        echo "<script>alert('Payment details inserted successfully.');</script>";
    } else {
        echo "<script>alert('Failed to insert payment details: " . pg_last_error($conn) . "');</script>";
    }

    // Close database connection
    pg_close($conn);
}
?>

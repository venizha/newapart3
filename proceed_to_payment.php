<?php
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenantId = $_POST['tenant-id'];
    $billType = $_POST['bill-type'];
    $paidAmount = $_POST['paid-amount'];
    $cardNumber = $_POST['card-number'];
    $expiryDate = $_POST['expiry-date'];
    $cvv = $_POST['cvv'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Database connection parameters
    $dbhost = 'localhost';
    $dbname = 'postgres';
    $dbuser = 'postgres';
    $dbpass = 'Keerthi23';

    // Create a database connection
    $conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    if (!$conn) {
        die("Connection failed. Error: " . pg_last_error());
    }

    // Determine the table and column names based on the bill type
    switch ($billType) {
        case 'water':
            $tableName = 'water_bills';
            $amountColumn = 'amount';
            break;
        case 'electricity':
            $tableName = 'electricity_bills';
            $amountColumn = 'amount';
            break;
        case 'maintenance':
            $tableName = 'maintenance_fees';
            $amountColumn = 'amount';
            break;
        case 'rent':
            $tableName = 'tenants';
            $amountColumn = 'rent_amt';
            break;
        default:
            echo "Invalid bill type.";
            exit;
    }

    // Fetch the current amount from the database
    $query = "SELECT $amountColumn FROM $tableName WHERE tenant_id = $1";
    $result = pg_query_params($conn, $query, array($tenantId));
    if ($result) {
        $row = pg_fetch_assoc($result);
        $currentAmount = $row[$amountColumn];

        // Calculate the new amount
        $newAmount = $currentAmount - $paidAmount;
        $paymentStatus = ($newAmount <= 0) ? 'Paid' : 'Not Paid';

        // Update the amount and payment status in the database
        $updateQuery = "UPDATE $tableName SET $amountColumn = $1, payment_status = $2 WHERE tenant_id = $3";
        $updateResult = pg_query_params($conn, $updateQuery, array($newAmount, $paymentStatus, $tenantId));

        if ($updateResult) {
            // Insert payment details into a payments table (assuming you have one)
            $insertPaymentQuery = "INSERT INTO payments (tenant_id, bill_type, paid_amount, card_number, expiry_date, cvv, name, email, phone) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)";
            $insertPaymentResult = pg_query_params($conn, $insertPaymentQuery, array($tenantId, $billType, $paidAmount, $cardNumber, $expiryDate, $cvv, $name, $email, $phone));

            if ($insertPaymentResult) {
                echo "<script>alert('Payment processed successfully.');</script>";
            } else {
                echo "<script>alert('Failed to insert payment details: " . pg_last_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Failed to update amount and payment status: " . pg_last_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Failed to fetch current amount: " . pg_last_error($conn) . "');</script>";
    }

    // Close database connection
    pg_close($conn);
}
?>


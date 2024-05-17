<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        /* Your receipt styling here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .receipt-container {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        .receipt-details p {
            margin: 5px 0;
        }
        .download-button {
            text-align: center;
        }
        .download-button a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .download-button a:hover {
            background-color: #0056b3;
        }
        /* Add more styles as needed */
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1>Payment Receipt</h1>
            <p>Thank you for your payment!</p>
        </div>
        <div class="receipt-details">
            <p><strong>Received From:</strong> Dhivya</p>
            <p><strong>Received By:</strong> Easy Apart</p>
            <p><strong>Total Amount:</strong> $3500.00</p>
            <!-- Add more details as needed (e.g., currency, transaction ID) -->
        </div>
        <div class="download-button">
            <a href="receipt.pdf" download>Download Receipt</a>
        </div>
    </div>
</body>
</html>
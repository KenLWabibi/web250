<?php
session_start(); // Start the session if you need to use it for other purposes (e.g., user login status)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch form data
    $VIN = $_POST['VIN'];
    $Make = $_POST['Make'];
    $Model = $_POST['Model'];
    $Asking_Price = $_POST['Asking_Price'];

    // Ensure all required fields are provided
    if (empty($VIN) || empty($Make) || empty($Model) || empty($Asking_Price)) {
        die("Missing required fields.");
    }

    // Connect to the database
    include '../config_db.php';

    // Prepare the SQL query to insert the car into the database
    $stmt = $mysqli->prepare("INSERT INTO inventory (VIN, Make, Model, Asking_Price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $VIN, $Make, $Model, $Asking_Price);

    if ($stmt->execute()) {
        // Redirect to the homepage with a success message
        header("Location: ../index.php?added=true");
    } else {
        // Error message if insertion fails
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $mysqli->close();
}
?>

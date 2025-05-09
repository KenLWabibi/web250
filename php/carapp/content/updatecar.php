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

    // Update the car's information in the database
    $stmt = $mysqli->prepare("UPDATE inventory SET Make = ?, Model = ?, Asking_Price = ? WHERE VIN = ?");
    $stmt->bind_param("ssds", $Make, $Model, $Asking_Price, $VIN);

    if ($stmt->execute()) {
        // Success message
        header("Location: ../index.php?updated=true");
    } else {
        // Error message
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>

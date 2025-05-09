<?php
include '../config_db.php';

if (isset($_GET['VIN'])) {
    $vin = $_GET['VIN'];

    $stmt = $mysqli->prepare("DELETE FROM inventory WHERE VIN = ?");
    $stmt->bind_param("s", $vin);

    if ($stmt->execute()) {
        header("Location: ../index.php?deleted=true");
        exit;
    } else {
        echo "<p>Error deleting car: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>No VIN provided.</p>";
}

$mysqli->close();
?>

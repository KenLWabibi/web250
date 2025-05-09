<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Keen Whale's Auto Sales 🐋 Home</title>
    <link href="styles/index.css" rel="stylesheet">
    <script src="https://lint.page/kit/67ff88.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="main-sections">
<?php include 'components/header.php'; ?>
    <main>
        <section="form-section">
            <h2>Add to Our Inventory</h2>
            <form method="post" action="content/insertcar.php">
                <!-- CSRF token (implement this server-side) -->
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                
                <label for="VIN_add">VIN</label>
                <input type="text" id="VIN_add" name="VIN" placeholder="VIN" required>
                
                <label for="Make_add">Make</label>
                <input type="text" id="Make_add" name="Make" placeholder="Make" required>
                
                <label for="Model_add">Model</label>
                <input type="text" id="Model_add" name="Model" placeholder="Model" required>
                
                <label for="Asking_Price_add">Asking Price</label>
                <input type="number" id="Asking_Price_add" name="Asking_Price" step="0.01" placeholder="Asking Price" required>
                
                <button type="submit">Add Car</button>
            </form>
        </section>

        <section class="table-section">
            <h2>Used Cars Inventory</h2>

            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            include 'config_db.php';

            $query = "SELECT VIN, Make, Model, Asking_Price FROM inventory ORDER BY Make";
            $result = $mysqli->query($query);

            if ($result):
            ?>
                <table class="cars-list">
                    <thead>
                        <tr>
                            <th scope="col">Make</th>
                            <th scope="col">Model</th>
                            <th scope="col">Asking Price</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['Make']) ?></td>
                            <td><?= htmlspecialchars($row['Model']) ?></td>
                            <td>$<?= number_format($row['Asking_Price'], 2) ?></td>
                            <td>
                                <a class="btn-edit" href="index.php?edit=<?= urlencode($row['VIN']) ?>#edit-form">Edit</a>
                                <a class="btn-delete" href="content/deletecar.php?VIN=<?= urlencode($row['VIN']) ?>" onclick="return confirm('Are you sure you want to delete this car?');">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <?php
                if (isset($_GET['added']) && $_GET['added'] === 'true') {
                    echo '<h3 class="confirmation">New car added successfully!</h3>';
                }

                if (isset($_GET['deleted']) && $_GET['deleted'] === 'true') {
                    echo '<h3 class="confirmation">Car deleted successfully!</h3>';
                }

                if (isset($_GET['updated']) && $_GET['updated'] === 'true') {
                    echo '<h3 class="confirmation">Car updated successfully!</h3>';
                }

                if (isset($_GET['edit'])) {
                    $editVIN = $_GET['edit'];
                    $stmt = $mysqli->prepare("SELECT * FROM inventory WHERE VIN = ?");
                    $stmt->bind_param("s", $editVIN);
                    $stmt->execute();
                    $editResult = $stmt->get_result();

                    if ($editResult && $editResult->num_rows > 0) {
                        $car = $editResult->fetch_assoc();
                ?>
                    <h2 id="edit-form">Edit Car</h2>
                    <form method="post" action="content/updatecar.php">
                        <!-- CSRF token (implement this server-side) -->
                        <input type="hidden" name="VIN" value="<?= htmlspecialchars($car['VIN'] ?? '') ?>">

                        <label for="Make_edit">Make</label>
                        <input type="text" id="Make_edit" name="Make" value="<?= htmlspecialchars($car['Make'] ?? '') ?>" placeholder="Make" required>

                        <label for="Model_edit">Model</label>
                        <input type="text" id="Model_edit" name="Model" value="<?= htmlspecialchars($car['Model'] ?? '') ?>" placeholder="Model" required>

                        <label for="Asking_Price_edit">Asking Price</label>
                        <input type="number" id="Asking_Price_edit" name="Asking_Price" step="0.01" value="<?= htmlspecialchars((string)($car['Asking_Price'] ?? '')) ?>" placeholder="Asking Price" required>

                        <button type="submit">Update Car</button>
                    </form>
                <?php
                    }
                    $stmt->close();
                }
                ?>

            <?php else: ?>
                <p style="color: red;">Error fetching inventory: <?= $mysqli->error ?></p>
            <?php endif; ?>

            <?php $mysqli->close(); ?>
        </section>
    </main>

    <?php include 'components/footer.php'; ?>
</div>    
</body>
</html>


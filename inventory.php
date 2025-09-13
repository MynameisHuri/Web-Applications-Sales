<?php 
include 'db.php'; 

// Handle add inventory
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item'], $_POST['quantity'])) {
    $item = $_POST['item'];
    $quantity = max(0, intval($_POST['quantity']));
    $date_added = date("Y-m-d H:i:s");

    // Check if item already exists
    $stmt = $conn->prepare("SELECT id, quantity FROM inventory WHERE item = ?");
    $stmt->bind_param("s", $item);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $current_quantity);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        $new_quantity = $current_quantity + $quantity;
        $update_stmt = $conn->prepare("UPDATE inventory SET quantity = ?, date_added = ? WHERE id = ?");
        $update_stmt->bind_param("isi", $new_quantity, $date_added, $id);
        $update_stmt->execute();
    } else {
        $insert_stmt = $conn->prepare("INSERT INTO inventory (item, quantity, date_added) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("sis", $item, $quantity, $date_added);
        $insert_stmt->execute();
    }

    header("Location: inventory.php?msg=added");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- Message Container -->
<div id="message" class="message"></div>

<div class="top-nav">
    <a href="index.php" class="home-btn" aria-label="Home">
        <i class="fas fa-home"></i>
    </a>
</div>

<h2>Inventory Page</h2>
<button class="add-btn" onclick="openModal('addModal')">+ Add Inventory</button>

<?php 
$sql = "SELECT * FROM inventory ORDER BY id ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Item</th><th>Quantity</th><th>Date Added</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".htmlspecialchars($row['item'])."</td>";
        echo "<td>".$row['quantity']."</td>";
        echo "<td>".$row['date_added']."</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No inventory found.</p>";
}

// Success message
if (isset($_GET['msg']) && $_GET['msg'] === 'added') {
    echo "<script>
        const message = document.getElementById('message');
        message.textContent = 'Inventory successfully added!';
        message.className = 'message added show';
        setTimeout(() => { message.className = 'message'; }, 3000);
    </script>";
}
?>

<!-- Add Modal -->
<div class="modal" id="addModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
        <div class="modal-header">Add Inventory</div>
        <form action="" method="POST">
            <div class="form-group">
                <label for="item">Item</label>
                <input type="text" name="item" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" step="1" min="0" name="quantity" required>
            </div>
            <div class="modal-actions">
                <button type="submit" class="save-btn">Add</button>
                <button type="button" class="cancel-btn" onclick="closeModal('addModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script src="assets/script.js"></script>
</body>
</html>
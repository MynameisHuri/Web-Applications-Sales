<?php
include 'db.php';

// Handle Add Sale
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item'], $_POST['quantity'])) {
    $item = $_POST['item'];
    $quantity = intval($_POST['quantity']);
    $date_tendered = date("Y-m-d");

    // Get current stock from inventory and price from item_maintenance
    $stmt = $conn->prepare("
        SELECT i.quantity, im.price 
        FROM inventory i 
        JOIN item_maintenance im ON i.item = im.item 
        WHERE i.item = ?
    ");
    $stmt->bind_param("s", $item);
    $stmt->execute();
    $stmt->bind_result($stock, $price);
    $stmt->fetch();
    $stmt->close();

    if ($quantity > $stock) {
        $msgClass = "error";
        $msgText = "Cannot sell more than stock on hand!";
    } else {
        $total_sales = $quantity * $price;

        // Insert into sales
        $stmt = $conn->prepare("INSERT INTO sales (item, quantity, total_sales, date_tendered) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sids", $item, $quantity, $total_sales, $date_tendered);
        $stmt->execute();
        $stmt->close();

        // Update inventory
        $stmt = $conn->prepare("UPDATE inventory SET quantity = quantity - ? WHERE item = ?");
        $stmt->bind_param("is", $quantity, $item);
        $stmt->execute();
        $stmt->close();

        $msgClass = "added";
        $msgText = "Sale added successfully!";
    }

    // Redirect with message
    header("Location: sales.php?msg=$msgClass&text=" . urlencode($msgText));
    exit();
}

// Fetch sales
$result = $conn->query("SELECT * FROM sales ORDER BY date_tendered DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Page</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <?php
    // Display success/error message
    if (isset($_GET['msg']) && isset($_GET['text'])) {
        $msgClass = $_GET['msg'];
        $msgText = $_GET['text'];
        echo "<div id='message' class='message $msgClass show'>$msgText</div>";
    }
    ?>

    <div class="top-nav">
        <a href="index.php" class="home-btn" aria-label="Home">
            <i class="fas fa-home"></i>
        </a>
    </div>

    <h2>Sales Page</h2>
    
    <button class="add-btn" onclick="openModal('addModal')">+ Add Sale</button>
    <button class="report-btn" onclick="window.location.href='report.php'">Generate Report</button>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Item</th><th>Quantity</th><th>Total Sales</th><th>Date Tendered</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".htmlspecialchars($row['item'])."</td>";
            echo "<td>".$row['quantity']."</td>";
            echo "<td>₱ ".number_format($row['total_sales'], 2)."</td>";
            echo "<td>".$row['date_tendered']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } 
    else {
        echo "<p>No sales transactions found.</p>";
    }
    ?>

    <!-- Add Sale Modal -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
            <div class="modal-header">Add Sale</div>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="item">Item</label>
                    <select name="item" required>
                        <?php
                        $items = $conn->query("SELECT item, quantity FROM inventory WHERE quantity > 0");
                        while ($row = $items->fetch_assoc()) {
                            echo "<option value='".htmlspecialchars($row['item'])."'>".$row['item']." (Stock: ".$row['quantity'].")</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" min="1" name="quantity" required>
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
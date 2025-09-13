<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Items Maintenance</title>
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

    <h2>Items Maintenance Page</h2>
    
    <button class="add-btn" onclick="openModal('addModal')">+ Add Item</button>

    <?php
    $sql = "SELECT * FROM item_maintenance ORDER BY id ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Item</th><th>Price</th><th>Date Added</th><th>Actions</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr data-id='".$row['id']."' data-item='".htmlspecialchars($row['item'])."' data-price='".$row['price']."' data-date='".$row['date_added']."'>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".htmlspecialchars($row['item'])."</td>";
            echo "<td>₱ " . number_format($row['price'], 0) . "</td>";
            echo "<td>".$row['date_added']."</td>";
            echo "<td>
                    <button class='update-btn' onclick='openUpdateModal(this)'>Update</button>
                    <button class='delete-btn' onclick='openDeleteModal(this)'>Delete</button>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No items found.</p>";
    }
    ?>

    <?php
    // Success message
    if (isset($_GET['msg'])) {
        $text = "";
        $class = "";

        switch ($_GET['msg']) {
            case 'added':
                $text = "Item successfully added!";
                $class = "added";
                break;
            case 'updated':
                $text = "Item successfully updated!";
                $class = "updated";
                break;
            case 'deleted':
                $text = "Item successfully deleted!";
                $class = "deleted";
                break;
        }

        if ($text != "") {
            echo "<script>
                const message = document.getElementById('message');
                message.textContent = '$text';
                message.className = 'message $class show';
                setTimeout(() => { message.className = 'message'; }, 3000);
            </script>";
        }
    }
    ?>

    <!-- Add Modal -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
            <div class="modal-header">Add Item</div>
            <form action="save_item.php" method="POST">
                <div class="form-group">
                    <label for="item_name">Item</label>
                    <input type="text" name="item_name" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" step="1000" name="price" required>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="save-btn">Save</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('addModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal" id="updateModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('updateModal')">&times;</span>
            <div class="modal-header">Update Item</div>
            <form action="update_item.php" method="POST">
                <input type="hidden" name="id" id="update_id">
                <div class="form-group">
                    <label for="update_item">Item</label>
                    <input type="text" name="item_name" id="update_item" required>
                </div>
                <div class="form-group">
                    <label for="update_price">Price</label>
                    <input type="number" step="1000" name="price" id="update_price" required>
                </div>
                <div class="form-group">
                    <label for="update_date">Date Added</label>
                    <input type="text" id="update_date" disabled> <!-- view-only -->
                </div>
                <div class="modal-actions">
                    <button type="submit" class="save-btn">Update</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('updateModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('deleteModal')">&times;</span>
            <div class="modal-header">Delete Item</div>
            <form action="delete_item.php" method="POST">
                <input type="hidden" name="id" id="delete_id">
                <p>Are you sure you want to delete <strong id="delete_item_name"></strong>?</p>
                <div class="modal-actions">
                    <button type="submit" class="delete-btn">Delete</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('deleteModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
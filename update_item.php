<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $item = $_POST['item_name'];
    $price = $_POST['price'];

    // Make sure the SQL has the columns correctly
    $stmt = $conn->prepare("UPDATE item_maintenance SET item=?, price=? WHERE id=?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sdi", $item, $price, $id);

    if ($stmt->execute()) {
        header("Location: items.php?msg=updated");
        exit();
    } 
    else {
        echo "Error updating item: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
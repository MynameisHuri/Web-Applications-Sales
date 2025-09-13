<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM item_maintenance WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: items.php?msg=deleted");
        exit();
    }
    else {
        echo "Error deleting item: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
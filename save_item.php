<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $date_added = date("Y-m-d"); // automatically today

    $stmt = $conn->prepare("INSERT INTO item_maintenance (item, price, date_added) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $item_name, $price, $date_added);

    if ($stmt->execute()) {
        header("Location: items.php?msg=added");
        exit();

    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
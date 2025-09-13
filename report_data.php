<?php
include 'db.php';

$items = isset($_GET['items']) ? explode(',', $_GET['items']) : [];
$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';

$labels = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
$datasets = [];

if(empty($items)) {
    // Load all items by default
    $result = $conn->query("SELECT DISTINCT item FROM item_maintenance ORDER BY item ASC");
    while($row = $result->fetch_assoc()){
        $items[] = $row['item'];
    }
}

// Prepare dataset for each item
foreach($items as $item){
    $data = array_fill(0, 12, 0); // 12 months

    $query = "SELECT MONTH(date_tendered) AS month, SUM(quantity) AS total 
              FROM sales WHERE item = ?";

    $params = [$item];
    if($start && $end){
        $query .= " AND date_tendered BETWEEN ? AND ?";
        $params[] = $start;
        $params[] = $end;
    }

    $query .= " GROUP BY MONTH(date_tendered)";
    
    $stmt = $conn->prepare($query);

    if($start && $end){
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    } else {
        $stmt->bind_param('s', $item);
    }

    $stmt->execute();
    $res = $stmt->get_result();

    while($r = $res->fetch_assoc()){
        $data[intval($r['month'])-1] = intval($r['total']);
    }

    $color = '#' . substr(md5($item), 0, 6); // generate color based on item name

    $datasets[] = [
        'label' => $item,
        'data' => $data,
        'borderColor' => $color,
        'fill' => false,
        'tension' => 0.3
    ];
}

echo json_encode([
    'labels' => $labels,
    'datasets' => $datasets
]);

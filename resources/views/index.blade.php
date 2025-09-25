<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sales Web Application</title>
  
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">

</head>
<body>
  <div class="container">
    <h1>Sales Web Application</h1>
    <a href="{{ route('item.maintenance') }}" class="button">Items</a>
    <a href="{{ route('inventory.index') }}" class="button">Inventory</a>
    <a href="{{ route('sales.index') }}" class="button">Sales</a>
  </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Sales Web Application</title>

  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <h2>Sales<span>App</span></h2>
      </div>

      <nav class="nav-menu">
      <a href="#" class="nav-link">
        <i class="fa-solid fa-grip"></i>
        <span>Dashboard</span>
      </a>


      <nav class="nav-menu">
        <a href="{{ route('item.maintenance') }}" class="nav-link">
          <i class="fa-solid fa-box"></i>
          <span>Items</span>
        </a>

        <a href="{{ route('inventory.index') }}" class="nav-link">
          <i class="fas fa-warehouse"></i>
          <span>Inventory</span>
        </a>

        <a href="{{ route('sales.index') }}" class="nav-link">
          <i class="fa-solid fa-chart-line"></i>
          <span>Sales</span>
        </a>
      </nav>
    </aside>
  </div>
</body>
</html>
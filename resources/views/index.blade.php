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
        <a href="{{ route('dashboard') }}" class="nav-link active">
          <i class="fa-solid fa-grip"></i>
          <span>Dashboard</span>
        </a>

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

    <main class="main-content">
      <!-- Top Bar -->
      <header class="topbar">
        <div class="menu-icon">
          <i class="fa-solid fa-bars"></i>
        </div>

        <div class="search-container">
          <input type="text" placeholder="Search..." class="search-bar">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>

        <div class="top-icons">
          <i class="fa-brands fa-github"></i>
          <i class="fa-regular fa-bell"></i>
        </div>
      </header>

      <!-- Dashboard Content -->
      <section class="dashboard-content">
        <h1>Dashboard</h1>

        <div class="stats">
          <!-- Total Items -->
          <div class="card">
            <i class="fa-solid fa-box"></i>
            <h3>{{ $totalItems ?? 0 }}</h3>
            <p>Total Items</p>
          </div>

          <!-- Total Stocks -->
          <div class="card">
            <i class="fa-solid fa-layer-group"></i>
            <h3>{{ $totalStocks ?? 0 }}</h3>
            <p>Total Stocks</p>
          </div>

          <!-- Total Sales -->
          <div class="card">
            <i class="fa-solid fa-chart-line"></i>
            <h3>₱{{ number_format($totalSales ?? 0, 2) }}</h3>
            <p>Total Sales</p>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>

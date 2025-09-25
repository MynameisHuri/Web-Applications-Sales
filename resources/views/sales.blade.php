<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">

        <div class="top-nav mb-3">
            <a href="{{ route('dashboard') }}" class="home-btn">Back to Dashboard</a>
        </div>

        <h2>Sales Page</h2>

        @if(session('success'))
            <div id="successMessage" class="message added">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div id="errorMessage" class="message deleted">{{ session('error') }}</div>
        @endif

        <div class="text-end mb-3">
            <a href="{{ route('sales.report') }}" class="btn btn-primary mb-3">
                Generate Report
            </a>

            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addSaleModal">
                + Add Sale
            </button>
        </div>

        <table class="table table-bordered text-center table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Total Sales</th>
                    <th>Date Tendered</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->item->name }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>₱ {{ number_format($sale->total_sales) }}</td>
                        <td>{{ \Carbon\Carbon::parse($sale->date_tendered)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addSaleModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('sales.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Sale</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="item_id" class="form-label">Item</label>
                            <select name="item_id" class="form-select" required>
                                <option value="">Select Item</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} (Stock: {{ $item->inventory->quantity ?? 0 }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" min="1" step="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const successMsg = document.getElementById('successMessage');
        if (successMsg) {
            successMsg.classList.add('show');
            setTimeout(() => successMsg.classList.remove('show'), 3000);
        }

        const errorMsg = document.getElementById('errorMessage');
        if (errorMsg) {
            errorMsg.classList.add('show');
            setTimeout(() => errorMsg.classList.remove('show'), 3000);
        }
    </script>
</body>
</html>
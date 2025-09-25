<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">

        <div class="top-nav mb-3">
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Back to Sales</a>
        </div>

        <h2>Sales Report</h2>

        <div class="text-end mb-3">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#filterModal">
                Filter Graph
            </button>
        </div>

        <canvas id="salesChart" height="100"></canvas>
    </div>

    <div class="modal fade" id="filterModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="filterForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Graph</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label">Item(s)</label>
                            <select name="items[]" class="form-select" multiple>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Regenerate</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let salesChart;

        function renderChart(data) {
            const labels = ["January","February","March","April","May","June","July","August","September","October","November","December"];
            const datasets = Object.keys(data).map((itemName, idx) => ({
                label: itemName,
                data: labels.map(month => data[itemName][month] || 0),
                borderColor: `hsl(${idx * 60 % 360}, 70%, 50%)`,
                tension: 0.3,
                fill: false
            }));

            if (salesChart) salesChart.destroy();

            const ctx = document.getElementById('salesChart').getContext('2d');
            salesChart = new Chart(ctx, {
                type: 'line',
                data: { labels, datasets },
                options: { responsive: true, plugins: { legend: { position: 'top' } } }
            });
        }

        function fetchSalesData(formData = null) {
            let url = "{{ route('sales.report.data') }}";

            if (formData) {
                const params = new URLSearchParams();
                formData.forEach((value, key) => params.append(key, value));
                url += `?${params.toString()}`;
            }

            fetch(url)
                .then(res => res.json())
                .then(data => renderChart(data));
        }

        fetchSalesData();

        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetchSalesData(formData);
            const modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
            modal.hide();
        });
    </script>
</body>
</html>
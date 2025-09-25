let salesChart;

// Function to render the chart
function renderChart(labels, datasets) {
    const ctx = document.getElementById('salesChart').getContext('2d');
    if (salesChart) salesChart.destroy();

    salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Sales Per Item' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

// Initial load: fetch sales for current year
document.addEventListener('DOMContentLoaded', () => {
    fetchSalesData();
});

// Handle filter form submission
document.getElementById('filterGraphForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetchSalesData(formData);
});

// Fetch sales data from backend
function fetchSalesData(formData = null) {
    let url = "/sales/report-data"; // make sure this route exists
    let options = { method: 'GET' };

    if (formData) {
        const params = new URLSearchParams();
        formData.forEach((value, key) => params.append(key, value));
        url += `?${params.toString()}`;
    }

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const labels = data.labels; // months
            const datasets = data.datasets.map(ds => ({
                label: ds.label,
                data: ds.data,
                borderColor: ds.color,
                backgroundColor: ds.color,
                tension: 0.3
            }));
            renderChart(labels, datasets);
        })
        .catch(err => console.error(err));
}
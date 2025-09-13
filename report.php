<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sales Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <link rel="stylesheet" href="assets/style.css">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    #salesChart {
        width: 100%;     
        max-width: 1000px; 
        height: 450px;   
        display: block;
        margin: 20px auto;
    }
    </style>

</head>
<body>

    <div class="top-nav">
        <a href="index.php" class="home-btn"><i class="fas fa-home"></i></a>
        <button class="report-btn" onclick="openModal('filterModal')">Filters</button>
    </div>

    <h2>Sales Report</h2>

<canvas id="salesChart"></canvas>

    <!-- Filter Modal -->
    <div class="modal" id="filterModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('filterModal')">&times;</span>
            <div class="modal-header">Filter Sales Report</div>
            <form id="filterForm">
                <div class="form-group">
                    <label for="items">Select Items</label>
                    <select id="items" multiple style="height:100px;">
                        <?php
                        $items = $conn->query("SELECT item FROM item_maintenance ORDER BY item ASC");
                        while($row = $items->fetch_assoc()){
                            echo "<option value='".htmlspecialchars($row['item'])."'>".$row['item']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" required>
                </div>
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="save-btn" id="regenerateBtn">Regenerate</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('filterModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.style.display = "flex";
        }
        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.style.display = "none";
        }
        window.openModal = openModal;
        window.closeModal = closeModal;

        const ctx = document.getElementById('salesChart').getContext('2d');
        window.salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                datasets: []
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Sales Per Item (Current Year)' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        function loadChartData(items = [], start = '', end = ''){
            const xhr = new XMLHttpRequest();
            let params = '';
            if(items.length > 0) params += 'items=' + encodeURIComponent(items.join(',')) + '&';
            if(start) params += 'start=' + start + '&end=' + end;
            xhr.open('GET', 'report_data.php?' + params, true);
            xhr.onreadystatechange = function(){
                if(xhr.readyState === 4 && xhr.status === 200){
                    const data = JSON.parse(xhr.responseText);
                    window.salesChart.data.labels = data.labels;
                    window.salesChart.data.datasets = data.datasets;
                    window.salesChart.update();
                }
            };
            xhr.send();
        }

        loadChartData();

        const filterForm = document.getElementById('filterForm');
        const regenerateBtn = document.getElementById('regenerateBtn');
        regenerateBtn.addEventListener('click', () => {
            const selectedItems = Array.from(
                filterForm.querySelector('#items').selectedOptions
            ).map(opt => opt.value);

            const startDate = filterForm.querySelector('#start_date').value;
            const endDate = filterForm.querySelector('#end_date').value;

            if(selectedItems.length === 0){
                alert("Select at least one item.");
                return;
            }
            if(!startDate || !endDate || startDate > endDate){
                alert("Select a valid start and end date.");
                return;
            }

            loadChartData(selectedItems, startDate, endDate);
            closeModal('filterModal');
        });
    });
    </script>
</body>
</html>
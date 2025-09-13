document.addEventListener("DOMContentLoaded", () => {

    // --- MODAL FUNCTIONS ---
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

    // --- ITEMS / INVENTORY UPDATE MODALS ---
    function populateUpdateModal(row) {
        const id = row.getAttribute("data-id");
        const item = row.getAttribute("data-item");
        const price = row.getAttribute("data-price");
        const date = row.getAttribute("data-date");

        const updateId = document.getElementById("update_id");
        const updateItem = document.getElementById("update_item");
        const updatePrice = document.getElementById("update_price");
        const updateDate = document.getElementById("update_date");

        if (updateId) updateId.value = id;
        if (updateItem) updateItem.value = item;
        if (updatePrice) updatePrice.value = price;
        if (updateDate) updateDate.value = date;

        openModal("updateModal");
    }

    document.querySelectorAll(".update-btn").forEach(btn => {
        btn.addEventListener("click", e => {
            e.stopPropagation();
            const row = btn.closest("tr");
            if (row) populateUpdateModal(row);
        });
    });

    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", e => {
            e.stopPropagation();
            const row = btn.closest("tr");
            if (!row) return;

            const id = row.getAttribute("data-id");
            const item = row.getAttribute("data-item");

            const deleteId = document.getElementById("delete_id");
            const deleteName = document.getElementById("delete_item_name");

            if (deleteId) deleteId.value = id;
            if (deleteName) deleteName.textContent = item;

            openModal("deleteModal");
        });
    });

    // Clickable row to update
    document.querySelectorAll("table tr").forEach(row => {
        row.addEventListener("click", e => {
            if (e.target.tagName.toLowerCase() === 'button') return;
            const id = row.getAttribute("data-id");
            if (!id) return;
            populateUpdateModal(row);
        });
    });

    // --- SALES MODAL: QUANTITY VALIDATION ---
    const itemSelect = document.getElementById('item');
    const qtyInput = document.getElementById('quantity');

    if (itemSelect && qtyInput) {
        itemSelect.addEventListener('change', () => {
            const selected = itemSelect.options[itemSelect.selectedIndex];
            const stock = parseInt(selected.getAttribute('data-stock'));
            qtyInput.max = stock;
            if (parseInt(qtyInput.value) > stock) qtyInput.value = stock;
        });

        qtyInput.addEventListener('input', () => {
            const max = parseInt(qtyInput.max);
            if (parseInt(qtyInput.value) > max) qtyInput.value = max;
        });
    }

    // --- REPORT FILTER MODAL ---
    const filterForm = document.getElementById('filterForm');
    const regenerateBtn = document.getElementById('regenerateBtn');

    if(filterForm && regenerateBtn) {
        regenerateBtn.addEventListener('click', () => {
            const selectedItems = Array.from(
                filterForm.querySelector('#items').selectedOptions
            ).map(opt => opt.value);

            const startDate = filterForm.querySelector('#start_date').value;
            const endDate = filterForm.querySelector('#end_date').value;

            if(selectedItems.length === 0){
                alert("Please select at least one item.");
                return;
            }

            if(!startDate || !endDate || startDate > endDate){
                alert("Please select a valid start and end date.");
                return;
            }

            // AJAX request to fetch filtered data
            const xhr = new XMLHttpRequest();
            const params = `items=${encodeURIComponent(selectedItems.join(','))}&start=${startDate}&end=${endDate}`;
            xhr.open('GET', 'report_data.php?' + params, true);
            xhr.onreadystatechange = function() {
                if(xhr.readyState === 4 && xhr.status === 200){
                    const data = JSON.parse(xhr.responseText);
                    if(window.salesChart){
                        window.salesChart.data.labels = data.labels;
                        window.salesChart.data.datasets = data.datasets;
                        window.salesChart.update();
                    }
                }
            };
            xhr.send();

            closeModal('filterModal');
        });
    }
});
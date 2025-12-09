document.addEventListener("DOMContentLoaded", function() {

    // --- 1. SEARCH & FILTER ---
    window.filterTasks = function() {
        const input = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        if(!input || !statusFilter) return;

        const filterVal = input.value.toLowerCase();
        const statusVal = statusFilter.value;
        const rows = document.querySelectorAll('.task-row');

        rows.forEach(row => {
            const title = row.querySelector('strong').innerText.toLowerCase();
            const status = row.getAttribute('data-status');
            const matchesSearch = title.includes(filterVal);
            const matchesStatus = (statusVal === 'all') || (status === statusVal);
            
            row.style.display = (matchesSearch && matchesStatus) ? "" : "none";
        });
    }

    // --- 2. SORT LOGIC ---
    window.sortTable = function(n) {
        const table = document.getElementById("taskTable");
        let rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        switching = true;
        dir = "asc"; 
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) { shouldSwitch = true; break; }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) { shouldSwitch = true; break; }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++;
            } else {
                if (switchcount == 0 && dir == "asc") { dir = "desc"; switching = true; }
            }
        }
    }

    // --- 3. VIEW DESCRIPTION MODAL ---
    const modal = document.getElementById("descModal");
    const modalTitle = document.getElementById("modalTitle");
    const modalDesc = document.getElementById("modalDesc");

    window.openDescModal = function(title, btnElement) {
        const row = btnElement.closest("tr");
        const descText = row.querySelector(".hidden-desc").innerHTML;
        modalTitle.innerText = title;
        modalDesc.innerHTML = descText ? descText : "No description provided.";
        modal.style.display = "block";
    }

    window.closeDescModal = function() { modal.style.display = "none"; }
    window.onclick = function(event) { if (event.target == modal) modal.style.display = "none"; }
});
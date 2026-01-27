document.addEventListener('DOMContentLoaded', () => {

    /* ===== ELEMENTS ===== */
    const searchInput = document.getElementById('tableSearch');
    const clearBtn    = document.getElementById('clearSearch');
    const table       = document.getElementById('searchTable');
    const checkboxes  = document.querySelectorAll('.column-check');

    // Safety check (prevents JS errors on other pages)
    if (!searchInput || !table) return;

    /* ===== APPLY FILTERS ===== */
    function applyFilters() {
        const searchValue = searchInput.value.toLowerCase();
        const selectedColumns = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => parseInt(cb.value));

        const rows = table.querySelectorAll('tbody tr');

        // Show / Hide Columns
        table.querySelectorAll('tr').forEach(row => {
            row.querySelectorAll('th, td').forEach((cell, index) => {
                cell.style.display = selectedColumns.includes(index) ? '' : 'none';
            });
        });

        // Search Rows
        rows.forEach(row => {
            let rowText = '';
            selectedColumns.forEach(index => {
                rowText += row.cells[index]?.innerText.toLowerCase() + ' ';
            });
            row.style.display = rowText.includes(searchValue) ? '' : 'none';
        });
    }

    /* ===== CLEAR BUTTON ===== */
    function toggleClearButton() {
        clearBtn.style.display = searchInput.value ? 'block' : 'none';
    }

    /* ===== EVENTS ===== */
    searchInput.addEventListener('input', () => {
        applyFilters();
        toggleClearButton();
    });

    clearBtn.addEventListener('click', () => {
        searchInput.value = '';
        searchInput.focus();
        applyFilters();
        toggleClearButton();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', applyFilters);
    });

    /* ===== INIT ===== */
    toggleClearButton();
    applyFilters();

});

// eligibilityModal.js

document.addEventListener('DOMContentLoaded', function () {
    const filter = document.getElementById('eligibilityFilter');
    const search = document.getElementById('eligibilitySearch');
    const table = document.getElementById('eligibilityTable').getElementsByTagName('tbody')[0];

    function filterTable() {
        const filterValue = filter.value;
        const searchValue = search.value.toLowerCase();

        Array.from(table.rows).forEach(row => {
            const eligibilityCell = row.cells[6].textContent.trim(); // Eligibility column
            const rowText = Array.from(row.cells).map(cell => cell.textContent.toLowerCase()).join(' ');
            const matchesFilter = filterValue === 'All' || eligibilityCell === filterValue;
            const matchesSearch = rowText.includes(searchValue);

            row.style.display = (matchesFilter && matchesSearch) ? '' : 'none';
        });
    }

    // Event listeners
    filter.addEventListener('change', filterTable);
    search.addEventListener('input', filterTable);
});

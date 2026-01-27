// genderModal.js

document.addEventListener('DOMContentLoaded', function () {
    const genderFilter = document.getElementById('genderFilter');
    const genderSearch = document.getElementById('genderSearch');
    const table = document.getElementById('genderTable').getElementsByTagName('tbody')[0];

    function filterTable() {
        const filterValue = genderFilter.value;
        const searchValue = genderSearch.value.toLowerCase();

        Array.from(table.rows).forEach(row => {
            const genderCell = row.cells[6].textContent.trim(); // Gender column
            const rowText = Array.from(row.cells).map(cell => cell.textContent.toLowerCase()).join(' ');
            const matchesGender = filterValue === 'All' || genderCell === filterValue;
            const matchesSearch = rowText.includes(searchValue);

            row.style.display = (matchesGender && matchesSearch) ? '' : 'none';
        });
    }

    // Event listeners
    genderFilter.addEventListener('change', filterTable);
    genderSearch.addEventListener('input', filterTable);
});

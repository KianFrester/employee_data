// ageModal.js

document.addEventListener('DOMContentLoaded', function () {
    const ageFilter = document.getElementById('ageFilter');
    const ageSearch = document.getElementById('ageSearch');
    const ageTable = document.getElementById('ageTable').getElementsByTagName('tbody')[0];

    function filterAgeTable() {
        const filterValue = ageFilter.value;
        const searchValue = ageSearch.value.toLowerCase();

        Array.from(ageTable.rows).forEach(row => {
            const ageCell = row.cells[6].textContent.trim(); // Age column
            const rowText = Array.from(row.cells).map(cell => cell.textContent.toLowerCase()).join(' ');
            const matchesFilter = filterValue === 'All' || ageCell === filterValue;
            const matchesSearch = rowText.includes(searchValue);

            row.style.display = (matchesFilter && matchesSearch) ? '' : 'none';
        });
    }

    ageFilter.addEventListener('change', filterAgeTable);
    ageSearch.addEventListener('input', filterAgeTable);
});

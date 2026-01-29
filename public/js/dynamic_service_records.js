document.addEventListener('click', function (e) {

    // Add new service row
    if (e.target.classList.contains('addService')) {
        const container = document.getElementById('serviceContainer');
        const row = container.querySelector('.service-row');
        const clone = row.cloneNode(true);
        clone.querySelectorAll('input, select').forEach(el => el.value = '');
        container.appendChild(clone);
    }

    // Remove service row
    if (e.target.classList.contains('removeService')) {
        const rows = document.querySelectorAll('.service-row');
        if (rows.length === 1) return alert('At least one service record is required.');
        e.target.closest('.service-row').remove();
    }
});
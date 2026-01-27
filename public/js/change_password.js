function togglePw(id, btn) {
        const input = document.getElementById(id);
        const icon = btn.querySelector('i');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
    }

    // Bootstrap validation
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                // check confirm matches
                const np = document.getElementById('new_password');
                const cp = document.getElementById('confirm_password');
                if (np && cp && np.value !== cp.value) {
                    cp.setCustomValidity('Passwords do not match');
                } else if (cp) {
                    cp.setCustomValidity('');
                }

                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
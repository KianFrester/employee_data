document.addEventListener("DOMContentLoaded", () => {
            const flashes = document.querySelectorAll(".flash-message");

            if (!flashes.length) return;

            setTimeout(() => {
                flashes.forEach(el => {
                    el.style.transition = "opacity 0.6s ease, transform 0.6s ease";
                    el.style.opacity = "0";
                    el.style.transform = "translateY(-10px)";

                    setTimeout(() => el.remove(), 600);
                });
            }, 3000);
        });
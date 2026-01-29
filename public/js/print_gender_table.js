document.addEventListener("click", function (e) {

    if (e.target.closest("#printGenderTable")) {

        const table = document.getElementById("genderTable");
        if (!table) {
            alert("Table not found");
            return;
        }

        const newWin = window.open("", "_blank");

        // Get only visible rows
        const visibleRows = Array.from(table.tBodies[0].rows).filter(row =>
            row.style.display !== "none"
        );

        const tableHTML = `
            <table class="table table-bordered text-center" style="width:100%; border-collapse: collapse;">
                <thead style="background-color:#16166c;color:#fff;">
                    ${table.tHead.innerHTML}
                </thead>
                <tbody>
                    ${visibleRows.map(row => row.outerHTML).join("")}
                </tbody>
            </table>
        `;

        newWin.document.write(`
            <html>
            <head>
                <title>Gender Records</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    table { width:100%; border-collapse:collapse; }
                    th, td { border:1px solid #000; padding:5px; font-size:12px; }
                    th { background:#16166c; color:#fff; }
                    body { -webkit-print-color-adjust: exact; }
                </style>
            </head>
            <body>
                <h4 class="text-center mb-3">Gender Records</h4>
                ${tableHTML}
            </body>
            </html>
        `);

        newWin.document.close();
        newWin.focus();
        newWin.print();
    }
});
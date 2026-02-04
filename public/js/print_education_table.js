// public/js/print_education_table.js
document.addEventListener("DOMContentLoaded", function () {
  const btn = document.getElementById("printEducationTable");
  const table = document.getElementById("educationTable");

  if (!btn || !table) {
    console.warn("❌ Education print button or table not found.");
    return;
  }

  btn.addEventListener("click", () => {
    // ✅ get only visible rows (after filter/search)
    const visibleRows = Array.from(table.tBodies[0].rows).filter(
      row => row.style.display !== "none"
    );

    // ✅ rebuild table with only visible rows
    const tableHTML = `
      <table>
        <thead>
          ${table.tHead.innerHTML}
        </thead>
        <tbody>
          ${visibleRows.map(row => row.outerHTML).join("")}
        </tbody>
      </table>
    `;

    // ✅ shared print engine (same as others)
    printWithBolinaoHeader({
      title: "Educational Attainment Records",
      tableHTML,
      headerColor: "#16166c" 
    });
  });
});

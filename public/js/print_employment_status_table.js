document.addEventListener("DOMContentLoaded", function () {
  const btn = document.getElementById("printEmploymentTable");
  const table = document.getElementById("employmentTable");

  if (!btn || !table) return;

  btn.addEventListener("click", () => {
    const visibleRows = Array.from(table.tBodies[0].rows).filter(
      (row) => row.style.display !== "none",
    );

    const tableHTML = `
      <table>
        <thead>${table.tHead.innerHTML}</thead>
        <tbody>${visibleRows.map((r) => r.outerHTML).join("")}</tbody>
      </table>
    `;

    printWithBolinaoHeader({
      title: "Employment Status Records",
      tableHTML,
      headerColor: "#16166c",
    });
  });
});

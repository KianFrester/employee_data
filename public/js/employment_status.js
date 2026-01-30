document.addEventListener("DOMContentLoaded", function () {
  const empFilter = document.getElementById("employmentFilter");
  const empSearch = document.getElementById("employmentSearch");
  const table = document.getElementById("employmentTable");

  if (!empFilter || !empSearch || !table) return;

  const tbody = table.tBodies[0];

  // Find the "Employment Status" column index by header text
  const headers = Array.from(table.tHead.rows[0].cells).map((th) =>
    (th.innerText || "").trim().toLowerCase()
  );

  const EMP_COL_INDEX = headers.findIndex(
    (h) => h === "employment status" || h === "status"
  );

  if (EMP_COL_INDEX === -1) {
    console.error("Employment Status column not found. Check your <th> text.");
    return;
  }

  // Normalize DB values (handles different casing/spaces)
  function normalizeStatus(raw) {
    return String(raw || "")
      .trim()
      .toLowerCase()
      .replace(/\s+/g, " "); // normalize multiple spaces
  }

  function applyFilters() {
    const selected = String(empFilter.value || "All").trim(); // All / Employed / Unemployed / Retired
    const keyword = empSearch.value.trim().toLowerCase();

    const selectedNorm = selected === "All" ? "all" : normalizeStatus(selected);

    Array.from(tbody.rows).forEach((row) => {
      const rowText = row.innerText.toLowerCase();

      const cell = row.cells[EMP_COL_INDEX];
      const statusRaw = (cell?.innerText || "").trim();
      const statusNorm = normalizeStatus(statusRaw);

      const matchFilter =
        selectedNorm === "all" ? true : statusNorm === selectedNorm;

      const matchSearch = keyword === "" ? true : rowText.includes(keyword);

      row.style.display = matchFilter && matchSearch ? "" : "none";
    });
  }

  empFilter.addEventListener("change", applyFilters);
  empSearch.addEventListener("input", applyFilters);

  applyFilters();
});

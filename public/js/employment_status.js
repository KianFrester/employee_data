// public/js/employment_status.js
document.addEventListener("DOMContentLoaded", function () {
  const modalEl = document.getElementById("employmentModal");
  const empFilter = document.getElementById("employmentFilter");
  const empSearch = document.getElementById("employmentSearch");
  const table = document.getElementById("employmentTable");

  if (!empFilter || !empSearch || !table) {
    console.warn("❌ employmentFilter/employmentSearch/employmentTable not found.");
    return;
  }

  const tbody = table.tBodies[0];

  function normalize(text) {
    return String(text || "")
      .replace(/\u00A0/g, " ")     // non-breaking spaces
      .replace(/\s+/g, " ")
      .trim()
      .toLowerCase();
  }

  function findStatusColIndex() {
    const ths = Array.from(table.tHead?.rows?.[0]?.cells || []);
    const headers = ths.map((th) => normalize(th.textContent));

    // Your header is: "Employment Status (Latest)"
    let idx = headers.findIndex((h) => h.includes("employment status"));
    if (idx === -1) idx = headers.findIndex((h) => h === "status");
    if (idx === -1) idx = headers.findIndex((h) => h.includes("employment"));

    // fallback: last column (since status is last in your screenshot)
    if (idx === -1) idx = ths.length - 1;

    return idx;
  }

  let EMP_COL_INDEX = findStatusColIndex();

  function applyFilters() {
    // re-detect column index in case table changed
    EMP_COL_INDEX = findStatusColIndex();

    const selectedRaw = empFilter.value || "All";
    const selected = selectedRaw === "All" ? "all" : normalize(selectedRaw);
    const keyword = normalize(empSearch.value);

    Array.from(tbody.rows).forEach((row) => {
      // ignore "No records found" row
      if (row.cells.length <= 1) {
        row.style.display = "";
        return;
      }

      const statusCell = row.cells[EMP_COL_INDEX];
      const statusText = normalize(statusCell?.textContent);

      const rowText = normalize(row.textContent);

      const matchFilter = selected === "all" ? true : statusText === selected;
      const matchSearch = keyword === "" ? true : rowText.includes(keyword);

      row.style.display = matchFilter && matchSearch ? "" : "none";
    });
  }

  // ✅ normal change/input
  empFilter.addEventListener("change", applyFilters);
  empSearch.addEventListener("input", applyFilters);

  // ✅ IMPORTANT: re-apply every time modal opens (fixes "still not working")
  if (modalEl) {
    modalEl.addEventListener("shown.bs.modal", function () {
      // small delay ensures table is already painted
      setTimeout(applyFilters, 50);
    });
  }

  // ✅ also run once on load
  applyFilters();
});

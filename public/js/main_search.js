/* ===== ELEMENTS ===== */
const searchInput = document.getElementById("tableSearch");
const clearBtn = document.getElementById("clearSearch");
const table = document.getElementById("searchTable");
const checkboxes = document.querySelectorAll(".column-check");

if (!searchInput || !clearBtn || !table) {
  console.warn("main_search.js: missing elements.");
} else {
  /* ===== APPLY FILTERS ===== */
  function applyFilters() {
    const searchValue = searchInput.value.toLowerCase();

    const selectedColumns = Array.from(checkboxes)
      .filter((cb) => cb.checked)
      .map((cb) => parseInt(cb.value, 10));

    const rows = table.querySelectorAll("tbody tr");

    /* Show / Hide Columns */
    table.querySelectorAll("tr").forEach((row) => {
      row.querySelectorAll("th, td").forEach((cell, index) => {
        cell.style.display = selectedColumns.includes(index) ? "" : "none";
      });
    });

    /* Search Rows -> sets data-filtered only */
    rows.forEach((row) => {
      // ignore "No records found" row
      if (row.querySelectorAll("td").length <= 1) return;

      let rowText = "";
      selectedColumns.forEach((index) => {
        rowText += (row.cells[index]?.innerText || "").toLowerCase() + " ";
      });

      const match = rowText.includes(searchValue);
      row.dataset.filtered = match ? "1" : "0";
    });

    /* ✅ VERY IMPORTANT:
       hide all rows first so pagination can re-show only 10 rows on page 1
       (prevents “show all results” bug after search)
    */
    rows.forEach((row) => {
      if (row.querySelectorAll("td").length <= 1) return;
      row.style.display = "none";
    });

    /* ✅ refresh pagination */
    if (typeof window.__paginationRefresh === "function") {
      window.__paginationRefresh();
    }
  }

  /* ===== CLEAR BUTTON VISIBILITY ===== */
  function toggleClearButton() {
    clearBtn.style.display = searchInput.value ? "block" : "none";
  }

  /* ===== EVENTS ===== */
  searchInput.addEventListener("input", () => {
    applyFilters();
    toggleClearButton();
  });

  clearBtn.addEventListener("click", () => {
    searchInput.value = "";
    searchInput.focus();
    applyFilters();
    toggleClearButton();
  });

  checkboxes.forEach((cb) => {
    cb.addEventListener("change", applyFilters);
  });

  /* ===== INIT ===== */
  toggleClearButton();
  applyFilters();
}

/* ===============================
   ELEMENTS
================================ */
const searchInput = document.getElementById("tableSearch");
const clearBtn = document.getElementById("clearSearch");
const table = document.getElementById("searchTable");
const checkboxes = document.querySelectorAll(".column-check");

if (!searchInput || !clearBtn || !table) {
  console.warn("main_search.js: required elements not found.");
} else {
  function toggleClearButton() {
    clearBtn.style.display = searchInput.value.trim() ? "block" : "none";
  }

  // ✅ retry pagination refresh (fixes “pagination not yet loaded”)
  function refreshPaginationWithRetry(tries = 10) {
    if (typeof window.__paginationRefresh === "function") {
      window.__paginationRefresh();
      return;
    }
    if (tries <= 0) return;
    setTimeout(() => refreshPaginationWithRetry(tries - 1), 50);
  }

  function applyFilters() {
    const searchValue = searchInput.value.toLowerCase().trim();

    const selectedColumns = Array.from(checkboxes)
      .filter((cb) => cb.checked)
      .map((cb) => parseInt(cb.value, 10));

    const rows = table.querySelectorAll("tbody tr");

    /* ---- Show / Hide Columns ---- */
    table.querySelectorAll("tr").forEach((row) => {
      row.querySelectorAll("th, td").forEach((cell, index) => {
        cell.style.display = selectedColumns.includes(index) ? "" : "none";
      });
    });

    /* ---- Mark filtered (DO NOT show/hide here) ---- */
    rows.forEach((row) => {
      if (row.querySelectorAll("td").length <= 1) return; // ignore "No records found"

      let rowText = "";
      selectedColumns.forEach((index) => {
        rowText += (row.cells[index]?.innerText || "").toLowerCase() + " ";
      });

      row.dataset.filtered = rowText.includes(searchValue) ? "1" : "0";
    });

    /* ✅ CRITICAL: hide all data rows immediately (prevents "all rows show") */
    rows.forEach((row) => {
      if (row.querySelectorAll("td").length <= 1) return;
      row.style.setProperty("display", "none", "important");
    });

    /* ✅ Now let pagination re-show ONLY the 10 rows of page 1 */
    refreshPaginationWithRetry();
  }

  /* ===============================
     EVENTS
  ================================ */
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

  checkboxes.forEach((cb) => cb.addEventListener("change", applyFilters));

  /* ===============================
     INIT
  ================================ */
  toggleClearButton();
  applyFilters();
}

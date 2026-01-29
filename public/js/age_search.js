document.addEventListener("DOMContentLoaded", function () {
  const ageFilter = document.getElementById("ageFilter");
  const ageSearch = document.getElementById("ageSearch");
  const table = document.getElementById("ageTable");

  if (!ageFilter || !ageSearch || !table) return;

  const tbody = table.tBodies[0];

  // ✅ Adjust if your AGE column is not the last column
  const AGE_COL_INDEX = table.tHead.rows[0].cells.length - 1;

  function inAgeRange(ageNumber, rangeText) {
    if (!rangeText || rangeText === "All") return true;

    // "60+" case
    if (rangeText.includes("+")) {
      const min = parseInt(rangeText.replace("+", ""), 10);
      return ageNumber >= min;
    }

    // "31-40" case
    const [minStr, maxStr] = rangeText.split("-");
    const min = parseInt(minStr, 10);
    const max = parseInt(maxStr, 10);

    if (Number.isNaN(min) || Number.isNaN(max)) return true;
    return ageNumber >= min && ageNumber <= max;
  }

  function applyFilters() {
    const selected = ageFilter.value; // "All", "18-30", "31-40", ...
    const keyword = ageSearch.value.trim().toLowerCase();

    Array.from(tbody.rows).forEach((row) => {
      const cellsText = row.innerText.toLowerCase();

      // read numeric age from the Age column
      const ageCell = row.cells[AGE_COL_INDEX];
      const ageRaw = (ageCell?.innerText || "").trim();
      const ageNum = parseInt(ageRaw, 10);

      const matchRange = Number.isNaN(ageNum) ? false : inAgeRange(ageNum, selected);
      const matchSearch = keyword === "" ? true : cellsText.includes(keyword);

      row.style.display = matchRange && matchSearch ? "" : "none";
    });
  }

  ageFilter.addEventListener("change", applyFilters);
  ageSearch.addEventListener("input", applyFilters);

  // Run once on load
  applyFilters();
});

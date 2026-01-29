document.addEventListener("DOMContentLoaded", function () {
  const ageFilter = document.getElementById("ageFilter");
  const ageSearch = document.getElementById("ageSearch");
  const table = document.getElementById("ageTable");

  if (!ageFilter || !ageSearch || !table) return;

  const tbody = table.tBodies[0];

  // ✅ Find AGE column by header text (so it won't break if columns change)
  const headers = Array.from(table.tHead.rows[0].cells).map((th) =>
    (th.innerText || "").trim().toLowerCase()
  );
  const AGE_COL_INDEX = headers.findIndex((h) => h === "age");

  if (AGE_COL_INDEX === -1) {
    console.error("Age column not found. Check your <th> text says 'Age'.");
    return;
  }

  function normalizeRangeText(txt) {
    return (txt || "")
      .trim()
      .replace("–", "-") // handle en-dash
      .replace("—", "-"); // handle em-dash
  }

  function inAgeRange(ageNumber, rangeText) {
    const r = normalizeRangeText(rangeText);

    if (!r || r === "All") return true;

    // "60+"
    if (r.includes("+")) {
      const min = parseInt(r.replace("+", ""), 10);
      return ageNumber >= min;
    }

    // "31-40"
    const parts = r.split("-").map((p) => parseInt(p.trim(), 10));
    const min = parts[0];
    const max = parts[1];

    if (Number.isNaN(min) || Number.isNaN(max)) return true;
    return ageNumber >= min && ageNumber <= max;
  }

  function extractNumber(text) {
    // ✅ extracts first number anywhere (handles "33 years old", etc.)
    const match = String(text || "").match(/\d+/);
    return match ? parseInt(match[0], 10) : NaN;
  }

  function applyFilters() {
    const selected = normalizeRangeText(ageFilter.value);
    const keyword = ageSearch.value.trim().toLowerCase();

    Array.from(tbody.rows).forEach((row) => {
      const rowText = row.innerText.toLowerCase();

      const ageCell = row.cells[AGE_COL_INDEX];
      const ageRaw = (ageCell?.innerText || "").trim();
      const ageNum = extractNumber(ageRaw);

      const matchRange = !Number.isNaN(ageNum) && inAgeRange(ageNum, selected);
      const matchSearch = keyword === "" ? true : rowText.includes(keyword);

      row.style.display = matchRange && matchSearch ? "" : "none";
    });
  }

  ageFilter.addEventListener("change", applyFilters);
  ageSearch.addEventListener("input", applyFilters);

  // Run once on load
  applyFilters();
});

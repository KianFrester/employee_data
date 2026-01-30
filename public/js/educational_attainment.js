document.addEventListener("DOMContentLoaded", function () {
  const eduFilter = document.getElementById("educationFilter");
  const eduSearch = document.getElementById("educationSearch");
  const table = document.getElementById("educationTable");

  if (!eduFilter || !eduSearch || !table) return;

  const tbody = table.tBodies[0];

  // ✅ Find "Educational Attainment" column index by header text
  const headers = Array.from(table.tHead.rows[0].cells).map((th) =>
    (th.innerText || "").trim().toLowerCase()
  );

  const EDU_COL_INDEX = headers.findIndex(
    (h) => h === "educational attainment" || h === "education"
  );

  if (EDU_COL_INDEX === -1) {
    console.error(
      "Educational Attainment column not found. Check your <th> text."
    );
    return;
  }

  // ✅ Map dropdown codes to possible DB values (supports many formats)
  function normalizeEduValue(raw) {
    const v = String(raw || "").trim().toLowerCase();

    // common db values or labels -> code
    if (v.includes("elem")) return "ELEM";
    if (v.includes("high") || v === "hs") return "HS";
    if (v.includes("college")) return "COLLEGE";
    if (v.includes("voc")) return "VOC";
    if (v.includes("grad")) return "GRAD";
    if (v.includes("n/a")) return "N/A";

    // if db already stores codes exactly
    if (v === "elem") return "ELEM";
    if (v === "hs") return "HS";
    if (v === "college") return "COLLEGE";
    if (v === "voc") return "VOC";
    if (v === "grad") return "GRAD";
    if (v === "n/a") return "N/A";

    return v.toUpperCase(); // fallback
  }

  function applyFilters() {
    const selected = String(eduFilter.value || "All").trim();
    const keyword = eduSearch.value.trim().toLowerCase();

    Array.from(tbody.rows).forEach((row) => {
      const rowText = row.innerText.toLowerCase();

      const eduCell = row.cells[EDU_COL_INDEX];
      const eduRaw = (eduCell?.innerText || "").trim();
      const eduCode = normalizeEduValue(eduRaw);

      const matchFilter = selected === "All" ? true : eduCode === selected;
      const matchSearch = keyword === "" ? true : rowText.includes(keyword);

      row.style.display = matchFilter && matchSearch ? "" : "none";
    });
  }

  eduFilter.addEventListener("change", applyFilters);
  eduSearch.addEventListener("input", applyFilters);

  // run once on load
  applyFilters();
});

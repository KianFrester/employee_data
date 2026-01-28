document.addEventListener("DOMContentLoaded", function () {
  const table = document.getElementById("genderTable");
  const filter = document.getElementById("genderFilter");
  const search = document.getElementById("genderSearch");

  filter.addEventListener("change", filterTable);
  search.addEventListener("keyup", filterTable);

  function filterTable() {
    const genderVal = filter.value.toLowerCase();
    const searchVal = search.value.toLowerCase();

    Array.from(table.tBodies[0].rows).forEach((row) => {
      const genderCell = row.cells[6].textContent.toLowerCase();
      const rowText = row.textContent.toLowerCase();

      const genderMatch = genderVal === "all" || genderCell === genderVal;
      const searchMatch = rowText.includes(searchVal);

      row.style.display = genderMatch && searchMatch ? "" : "none";
    });
  }
});

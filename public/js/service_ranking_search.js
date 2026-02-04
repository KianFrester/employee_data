// public/js/service_ranking_search.js
document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("serviceRankingSearch");
  const table = document.getElementById("serviceRankingTable");
  if (!input || !table) return;

  const tbody = table.tBodies[0];

  input.addEventListener("input", () => {
    const q = input.value.trim().toLowerCase();

    Array.from(tbody.rows).forEach((row) => {
      const text = row.innerText.toLowerCase();
      row.style.display = text.includes(q) ? "" : "none";
    });
  });
});

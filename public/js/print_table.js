function printTable() {
  const table = document.getElementById("searchTable");
  if (!table) return;

  printWithBolinaoHeader({
    title: "Employee Records",
    tableHTML: table.outerHTML,
    headerColor: "#0d6efd"
  });
}

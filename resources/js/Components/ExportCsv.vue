<script setup>
const props = defineProps({
  columns: { type: Array, required: true },
  data: { type: Array, required: true },
  exportTitle:String,
  tableRef:Object
});

const exportCSV = () => {
  if (!props.tableRef) return;

  const tableRef = props.tableRef;

  const rows = Array.from(tableRef.querySelectorAll("tr"));
  const csvContent = rows
    .map((row) => {
      const cells = Array.from(row.querySelectorAll("th, td"));
      cells.pop();

      return cells
        .map((cell) => {
          let text = cell.innerText.trim();
          if (cell.querySelector("input[type=checkbox]")) {
            text = cell.querySelector("input").checked ? "Active" : "Deactive";
          }

          text = text.replace(/"/g, '""');
          if (text.includes(",") || text.includes('"') || text.includes("\n")) {
            text = `"${text}"`;
          }
          return text;
        })
        .join(",");
    })
    .join("\n");

  const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
  const url = URL.createObjectURL(blob);
  const link = document.createElement("a");
  link.setAttribute("href", url);
  link.setAttribute("download", props?.exportTitle+".csv");
  link.click();
};
</script>
<template>
  <button @click="exportCSV" class="royal-btn" id="exportCsv">
          <i class="fa-solid fa-file-csv text-[13px]"></i>
        </button>
</template>

<style scoped>

.royal-btn {
  color: #ef4444;
  padding: 0.1rem 0.1rem;
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: all 0.2s;
}
.royal-btn:hover {
  filter: brightness(1.1);
}
</style>
<script setup>
import * as XLSX from "xlsx";
const props = defineProps({
  columns: { type: Array, required: true },
  data: { type: Array, required: true },
  exportTitle:String,
  tableRef:Object
});

const exportExcel = () => {
    if (!props.tableRef) return;

  const tableRef = props.tableRef;

  const rows = Array.from(tableRef.querySelectorAll("tr"));
  const data = rows.map((row) => {
    const cells = Array.from(row.querySelectorAll("th, td"));
    cells.pop();

    return cells.map((cell) => {
      const checkbox = cell.querySelector("input[type=checkbox]");
      if (checkbox) {
        return checkbox.checked ? "Active" : "Deactive";
      }
      return cell.innerText.trim();
    });
  });

  const ws = XLSX.utils.aoa_to_sheet(data);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

  XLSX.writeFile(wb, props?.exportTitle+".xlsx");
};

</script>
<template>
    <button @click="exportExcel" class="royal-btn" id="exportExcel">
          <i class="fa-solid fa-file-excel text-[13px]"></i>
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
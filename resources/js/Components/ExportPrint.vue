<script setup>
import { ref, computed } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import Switch from "./Switch.vue";
import CopyTable from "./CopyTable.vue";
import ExportCsv from "./ExportCsv.vue";
import ExportExcel from "./ExportExcel.vue";
import ExportPdf from "./ExportPdf.vue";
const props = defineProps({
  columns: { type: Array, required: true },
  data: { type: Array, required: true },
  exportTitle:String,
  tableRef:Object
});



const exportPrint = () => {
   if (!props.tableRef) return;

  const tableRef = props.tableRef;

  // Build headers (skip last column)
  const headers = Array.from(tableRef.querySelectorAll("thead th"))
    .map((th) => th.innerText.trim());
  headers.pop();

  // Build body (skip last column, convert Switch to Active/Deactive)
  const bodyRows = Array.from(tableRef.querySelectorAll("tbody tr")).map(
    (tr) => {
      const cells = Array.from(tr.querySelectorAll("td"));
      cells.pop(); // remove last column
      return cells.map((cell) => {
        const switchInput = cell.querySelector("input[type=checkbox]");
        if (switchInput) return switchInput.checked ? "Active" : "Deactive";
        return cell.innerText.trim();
      });
    }
  );

  // Build HTML table
  let html = "<table border='1' cellspacing='0' cellpadding='5' style='border-collapse: collapse; width: 100%;'>";
  html += "<thead><tr>";
  headers.forEach((h) => (html += `<th style='background:#980106;color:#fff;'>${h}</th>`));
  html += "</tr></thead>";
  html += "<tbody>";
  bodyRows.forEach((row) => {
    html += "<tr>";
    row.forEach((cell) => (html += `<td>${cell}</td>`));
    html += "</tr>";
  });
  html += "</tbody></table>";

  const printWindow = window.open("", "", "width=900,height=700");
  printWindow.document.write(`
    <html>
      <head>
        <title>Print Table</title>
        <style>
          body { font-family: Arial, sans-serif; padding: 20px; }
          th, td { text-align: left; }
          tr:nth-child(even) { background: #f9f9f9; }
        </style>
      </head>
      <body>
        <h2>${props?.exportTitle}</h2>
        ${html}
      </body>
    </html>
  `);

  printWindow.document.close();
  printWindow.focus();
  printWindow.print();
  printWindow.close();
};

</script>



<template>
    <button @click="exportPrint" class="royal-btn" id="exportPrint">
          <i class="fa-solid fa-print text-[13px]"></i>
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
<!-- <script setup>
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
const props = defineProps({
  columns: { type: Array, required: true },
  data: { type: Array, required: true },
  exportTitle:String,
  tableRef:Object
});


const exportPDF = () => {
  if (!props.tableRef) return;

  const tableRef = props.tableRef;

  const doc = new jsPDF("p", "pt", "a4");

  // Add a title
  doc.setFontSize(14);
  doc.text(props?.exportTitle, 40, 30);

  // Build table data manually
  const headers = Array.from(
    tableRef.querySelectorAll("thead th")
  ).map((th) => th.innerText.trim());
  headers.pop(); // remove last column (actions)

  const body = Array.from(tableRef.querySelectorAll("tbody tr")).map(
    (tr) => {
      const cells = Array.from(tr.querySelectorAll("td"));
      cells.pop(); // remove last column
      return cells.map((cell) => {
        const checkbox = cell.querySelector("input[type=checkbox]");
        if (checkbox) return checkbox.checked ? "Active" : "Deactive";
        return cell.innerText.trim();
      });
    }
  );

  // Generate PDF table
  autoTable(doc, {
    head: [headers],
    body: body,
    startY: 50,
    theme: "striped",
    styles: {
      fontSize: 10,
      cellPadding: 4,
    },
    headStyles: {
      fillColor: [158, 1, 5],
      textColor: 255,
    },
  });

  doc.save(props?.exportTitle+".pdf");
};

</script>



<template>
  <button @click="exportPDF" class="royal-btn" id="exportPdf">
          <i class="fa-solid fa-file-pdf text-[13px]"></i>
        </button>
</template>

<style scoped>

.royal-btn {
  color: #D9A250;
  padding: 0.1rem 0.1rem;
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: all 0.2s;
}
.royal-btn:hover {
  filter: brightness(1.1);
}
</style> -->

<template></template>
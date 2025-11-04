<script setup>
import { ref, computed, onMounted } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import Switch from "./Switch.vue";
import CopyTable from "./CopyTable.vue";
import ExportCsv from "./ExportCsv.vue";
import ExportExcel from "./ExportExcel.vue";
import ExportPdf from "./ExportPdf.vue";
import ExportPrint from "./ExportPrint.vue";
import Modal from "./Modal.vue";
const props = defineProps({
  columns: { type: Array, required: true },
  data: { type: Array, required: true },
  edit: String,
  status: String,
  deleteUrl: String,
  exportTitle: String,
  payment: Object,
  filters: { type: Object, default: () => ({}) },
  isInvoice: Boolean,
  hideActionOfID: String,
  canEdit: { type: Boolean, default: true },
  canDelete: { type: Boolean, default: true },
  canCreateSell: { type: Boolean, default: true },
  isTrashed: { type: Boolean, default: false },
  restoreUrl: { type: String, default: null },
  showSearch:{type:Boolean,default:true},
  linkUrl:String,
  showUrl:String,
  addBook:String,
  addFunction:Function
});

const searchRef = ref("");

const currentPage = ref(1);
const pageLength = ref(50);
const lengthOptions = [50, 100,250, 500,1000];

const filteredData = computed(() => {
  let data = props.data;

  // Free-text search
  if (searchRef.value) {
    const term = searchRef.value.toLowerCase();
    data = data.filter((row) =>
      Object.values(row).some((val) => String(val).toLowerCase().includes(term))
    );
  }

  // Column filters from parent
  Object.entries(props.filters).forEach(([key, val]) => {
    if (
      val &&
      key !== "date_from" &&
      key !== "date_to" &&
      key !== "payment_status" &&
      key !== "return_date_from" &&
      key !== "return_date_to"
    ) {
      data = data.filter((row) => {
        const cell = String(row[key] ?? "").toLowerCase();
        const filterVal = String(val).toLowerCase();
        return cell.includes(filterVal);
      });
    }
  });

  if (props.filters.date_from) {
    const fromDate = new Date(props.filters.date_from);
    data = data.filter((row) => new Date(row.date) >= fromDate);
  }
  if (props.filters.date_to) {
    const toDate = new Date(props.filters.date_to);
    data = data.filter((row) => new Date(row.date) <= toDate);
  }

  if (props.filters.return_date_from) {
    const fromDate = new Date(props.filters.return_date_from);
    data = data.filter((row) => new Date(row.return_date) >= fromDate);
  }
  if (props.filters.return_date_to) {
    const toDate = new Date(props.filters.return_date_to);
    data = data.filter((row) => new Date(row.return_date) <= toDate);
  }

  if (props.filters.payment_status) {
    data = data.filter((row) => {
      const paid = parseFloat(row.paid.replace("Rs.", "").trim());
      const total = parseFloat(row.total.replace("Rs.", "").trim());
      if (props.filters.payment_status === "paid") {
        console.log("Paid=" + paid);
        console.log("total=" + total);
        return paid > 0 && paid >= total; // fully paid
      }
      if (props.filters.payment_status === "unpaid") {
        return paid === 0; // unpaid
      }
      if (props.filters.payment_status === "partial") {
        return paid > 0 && paid < total; // partial
      }
      return true; // default (show all if unknown)
    });
  }

  // return data;

  return data;
});

const totalPages = computed(
  () => Math.ceil(filteredData.value.length / pageLength.value) || 1
);

const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * pageLength.value;
  return sortedData?.value.slice(start, start + pageLength.value);
});

const pagesArray = computed(() => {
  let arr = [];
  for (let i = 1; i <= totalPages.value; i++) arr.push(i);
  return arr;
});

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};

const onPageLengthChange = () => {
  currentPage.value = 1; // reset to first page
};

const infoText = computed(() => {
  if (!filteredData.value.length) return "No entries found";
  const start = (currentPage.value - 1) * pageLength.value + 1;
  const end = Math.min(currentPage.value * pageLength.value, filteredData.value.length);
  return `Showing ${start} to ${end} of ${filteredData.value.length} entries`;
});

const deleteData = async (data,permanent = false) => {
  const confirm = await Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!",
  });

  if (confirm.isConfirmed) {
    useForm({}).delete(route(props?.deleteUrl, data),
    {
        data: { permanent },
      onSuccess: () => {
        Swal.fire({
          toast: true,
          position: "top-end",
          icon: "success",
          title: usePage()?.props?.success || "Deleted successfully!",
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
        });
      },
      onError: () => {
        Swal.fire({
          toast: true,
          position: "top-end",
          icon: "error",
          title: "Failed to delete!",
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
        });
      },
    });
  }
};

const tableRef = ref(null);

const sortKey = ref(null); // which column is sorted
const sortOrder = ref("asc"); // asc | desc

const sortedData = computed(() => {
  if (!sortKey.value) return filteredData.value;

  return [...filteredData.value].sort((a, b) => {
    let x = a[sortKey.value];
    let y = b[sortKey.value];

    if (typeof x === "string") x = x.toLowerCase();
    if (typeof y === "string") y = y.toLowerCase();

    if (x < y) return sortOrder.value === "asc" ? -1 : 1;
    if (x > y) return sortOrder.value === "asc" ? 1 : -1;
    return 0;
  });
});

const toggleSort = (colKey) => {
  if (sortKey.value === colKey) {
    sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
  } else {
    sortKey.value = colKey;
    sortOrder.value = "asc";
  }
};

const columnFilters = ref({});

const addBtn=()=>{
  props.addFunction();
}
</script>

<template>
  <div class="w-full rounded-2xl bg-white backdrop-blur-md p-4 shadow-lg relative">
    <div class="mb-3 flex justify-between items-center flex-wrap gap-3">
      <div class="flex items-center gap-3">
        <div class="flex">
          <select
            id="paginationSelect"
            v-model="pageLength"
            @change="onPageLengthChange"
            class="px-2 py-[3px] text-[13px] w-[60px] rounded border border-main/20"
          >
            <option v-for="len in lengthOptions" :key="len" :value="len">
              {{ len }}
            </option>
          </select>
        </div>
        <input
            v-if="showSearch"
          v-model="searchRef"
          @input="onSearch"
          type="text"
          placeholder="Search..."
          class="px-4 py-1 text-[12px] rounded-xl shadow-inner border border-main/20 focus:outline-none focus:ring-1 focus:ring-[#9e0105] text-slate-900 w-50"
        />
      </div>
      <div class="flex gap-2 flex-wrap items-center">
        <CopyTable :exportTitle="exportTitle" :columns="columns" :data="data" />
        <ExportCsv
          :exportTitle="exportTitle"
          :columns="columns"
          :data="data"
          :tableRef="tableRef"
        />
        <ExportExcel
          :exportTitle="exportTitle"
          :columns="columns"
          :data="data"
          :tableRef="tableRef"
        />
        <ExportPdf
          :exportTitle="exportTitle"
          :columns="columns"
          :data="data"
          :tableRef="tableRef"
        />
        <ExportPrint
          :exportTitle="exportTitle"
          :columns="columns"
          :data="data"
          :tableRef="tableRef"
        />
      </div>
    </div>

    <slot />

    <table ref="tableRef" class="display stripe hover w-full">
      <thead>
        <tr>
          
          <th
            class="py-[9px] px-3 cursor-pointer select-none"
            v-for="col in columns"
            :key="col.key"
            @click="toggleSort(col.key)"
          >
            <div class="flex items-center text-[11px]">
              {{ col.label }}
             
            </div>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(row, rIndex) in paginatedData"
          :key="rIndex"
          :class="row['is_returned'] == 1 ? 'line-through' : ''"
        >
          <td class="py-[9px] px-3 cursor-pointer" v-for="col in columns" :key="col.key">
            <template v-if="col.key === 'status'">
              <Switch
                v-if="status"
                :route="route(status, row['actions'])"
                v-model="row.status"
                :onColor="'#fff'"
                :offColor="'#ccc'"
              />
            </template>
            <template v-else-if="col.key === 'student_name'">
              
            </template>
            <template v-else-if="col.key === 'link'">
              <Link :href="linkUrl+'?expense='+row['link']" class="text-blue-800">
                <span class="block">{{ row["link"] }}</span>
              </Link>
            </template>
            <template v-else-if="col.key === 'show'">
              <Link :href="route(showUrl,row['actions'])" class="text-blue-800">
                <span class="block">{{ row["show"] }}</span>
              </Link>
            </template>
            <template v-else-if="col.key === 'image'">
              <img :src="'/storage/' + row['image']" class="h-[40px]" alt="" />
            </template>
            <template v-else-if="col.key === 'student_contact'">
              <span class="block">{{ row["phone"] }}</span>
              <small class="block">{{ row["email"] }}</small>
            </template>
            <template v-else-if="col.key === 'actions'">
             
              <div v-if="isTrashed" class="flex gap-2">
              </div>
              <div v-else>
                <div
                  class="flex gap-2"
                  v-if="row['is_returned'] != 1 && hideActionOfID != row['actions']"
                >
                  <slot name="invoice" :row="row" />
                  <Link
                    v-if="payment && canCreateSell"
                    :href="route(payment) + '?student_id=' + row['actions']"
                    class="royal-payment-btn flex items-center gap-1 px-3 py-2 font-semibold text-white rounded-xl shadow-md transition-all duration-300"
                  >
                    <i class="fa fa-money-bill"></i>
                  </Link>
                  <Link
                    v-if="edit && canEdit"
                    :href="route(edit, row[['actions']])"
                    class="royal-edit-btn h-[25px] w-[30px] flex items-center gap-1 px-3 py-2 font-semibold text-white rounded-lg shadow-md transition-all duration-300"
                  >
                    <i class="fa fa-pen text-[10px]"></i>
                  </Link>

                  <button
                    v-if="deleteUrl && canDelete"
                    @click="deleteData(row[col.key])"
                    class="royal-delete-btn h-[25px] w-[30px] flex items-center gap-1 px-3 py-0 font-semibold text-white rounded-lg shadow-md transition-all duration-300"
                  >
                    <i class="fa fa-trash text-[10px]"></i>
                  </button>

                  <button
                    v-if="addBook"
                    @click="addBtn(row[col.key])"
                    class="royal-delete-btn h-[25px] w-[30px] flex items-center gap-1 px-3 py-0 font-semibold text-white rounded-lg shadow-md transition-all duration-300"
                  >
                    <i class="fa fa-plus text-[10px]"></i>
                  </button>
                </div>
              </div>
            </template>

            <template v-else>
              {{ row[col.key] }}
            </template>
          </td>
        </tr>

        <slot name="customTr" :datas="paginatedData"/>
      </tbody>
    </table>

    <div class="flex justify-between items-center">
         <span class="text-[12px]">
            {{ infoText }}
         </span>
      <div class="mt-4 flex justify-center gap-2 items-center flex-wrap">
        <button
          @click="goToPage(currentPage - 1)"
          :disabled="currentPage === 1"
          class="px-3 py-1 rounded-lg text-[12px] bg-[#D9A250] text-white disabled:bg-gray-300 transition"
        >
          ‹
        </button>
        <button
          v-for="page in pagesArray"
          :key="page"
          @click="goToPage(page)"
          :class="[
            'px-3 py-1 rounded-lg transition text-[12px]',
            page === currentPage
              ? 'bg-[#ef4444] text-white font-bold'
              : 'bg-gray-200 text-gray-700 hover:bg-gray-300',
          ]"
        >
          {{ page }}
        </button>
        <button
          @click="goToPage(currentPage + 1)"
          :disabled="currentPage === totalPages"
          class="px-3 py-1 rounded-lg bg-[#ef4444] text-white text-[12px] disabled:bg-gray-300 transition"
        >
          ›
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
th {
  text-align: left !important;
  font-size: 14px;
}
td {
  font-size: 12px;
}
tbody tr {
  border-bottom: 1px solid #cccccc62;
}

.royal-payment-btn {
  background: linear-gradient(to right, #0f5023, #17a82f);
}
.royal-payment-btn:hover {
  filter: brightness(1.1);
  box-shadow: 0 4px 15px rgba(224, 122, 95, 0.6);
}

.royal-edit-btn {
  background: linear-gradient(to right, #0510e0, #0510e0);
}
.royal-edit-btn:hover {
  filter: brightness(1.1);
  box-shadow: 0 4px 15px rgba(224, 122, 95, 0.6);
}

.royal-delete-btn {
  background: linear-gradient(to right, #ef4444, #ef4444);
}
.royal-delete-btn:hover {
  filter: brightness(1.1);
  box-shadow: 0 4px 15px rgba(176, 54, 59, 0.6);
}

thead {
  background-color: #d6093517;
  /* color: #fff; */
}
</style>
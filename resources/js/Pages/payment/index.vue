<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import AddStudent from "@/Components/AddForm/AddStudent.vue";
import Inventory from "@/Components/Menus/Inventory.vue";
import AddStore from "@/Components/AddForm/AddProductCategory.vue";
import AddProductCategory from "@/Components/AddForm/AddProductCategory.vue";
import AddProduct from "@/Components/AddForm/AddProduct.vue";
const props = defineProps({
    payments: Object,
    product: Object,
    bill:Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Student", key: "student" },
    { label: "Bill No", key: "bill_no" },
    { label: "Receipt Mode", key: "mode" },
    { label: "Receipt Date", key: "date" },
    { label: "Amount", key: "amount" },
    { label: "Remarks", key: "remarks" },
    {label:"Action",key:"cancelPayment"},

];

const tableData = computed(() =>
    props.payments.map((item, index) => ({
        sn: index + 1,
        student: item?.bill?.student?.name,
        bill_no: item?.bill?.bill_no,
        mode: item?.payment_mode?.name ?? null,
        date: item?.payment_date ?? null,
        amount:item?.amount,
        remarks: item?.remarks,
        actions: item.id,
        cancelPayment: item.id,
        status: item.status,
    }))
);
</script>

<template>
    <AppLayout>
        <!-- <template #sidebar>
            <Inventory />
        </template> -->

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Payments' }]" />

            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">

                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'product.update.status'" :edit="'product.edit'" :deleteUrl="'product.delete'">
                    </Table>
                </div>
            </div>

        </template>
    </AppLayout>
</template>
<style scoped>
tr,
td {
    border: 1px solid #e2e8f0;
    padding: 8px;
    text-align: left;
    font-size: 13px;
}
</style>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import SelectAllStudent from '@/Components/Select/SelectAllStudent.vue';
import { computed } from 'vue';
import TableMultiLevel from '@/Components/TableMultiLevel.vue';
import TableBill from '@/Components/TableBill.vue';
const props = defineProps({
    students: Object,
    bills:Object,
})

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Student", key: "student" },
    { label: "Bill ID", key: "billId" },
    { label: "Sub Total", key: "subTotal" },
    { label: "Discount", key: "discount" },
    { label: "Tax", key: "tax" },
    { label: "Total Payable", key: "payable" },
    { label: "Paid", key: "paid" },
    { label: "Balance", key: "balance" },
    { label: "Payment", key: "payment" },

];

const tableData = computed(() =>
    props.bills.map((item, index) => ({
        sn: index + 1,
        student:item?.student?.name,
        billId:item?.bill_no,
        subTotal:"Rs. "+item?.sub_total,
        discount:"Rs. "+item.discount,
        tax:"Rs. "+item?.total_tax,
        payable:'Rs. ' + item?.total_amount,
        paid:'Rs. ' + item?.total_paid,
        balance:'Rs. ' + (item?.total_amount-item?.total_paid <= 0 ? 0 : item?.total_amount-item?.total_paid),
        bills:item.items,
        actions:item.id,
        studentId:item?.student?.id,
        isPaid:item?.total_amount - item?.total_paid <=0 ? true : false

    }))
);
</script>

<template>
    <AppLayout title="Dashboard">
        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Billing' }]" />
            </div>
            <TableBill :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                :edit="'student.edit'" :deleteUrl="'student.delete'">

            </TableBill>
        </template>
    </AppLayout>
</template>

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
    props.students.map((item, index) => ({
        sn: index + 1,
        student:item?.name,
        billId:'-',
        subTotal:'-',
        discount:'-',
        tax:'-',
        payable:'-',
        paid:'-',
        balance:'-',
        bills:item?.bills,
        
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

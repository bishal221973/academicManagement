<script setup>
import { computed } from 'vue';
import Table from '../Table.vue';
const props = defineProps({
    student: Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Bill ID.", key: "bill_no" },
    { label: "Status", key: "status1" },
    { label: "Sub Total", key: "sub_total" },
    { label: "Discount", key: "discount" },
    { label: "Tax", key: "tax" },
    { label: "Total", key: "total" },
    { label: "Paid", key: "paid" },
    { label: "Balance", key: "balance" },
];

const tableData = computed(() =>
    props.student.bills.map((item, index) => ({
        sn: index + 1,
        bill_no: item?.bill_no,
        status1: item?.status,
        sub_total: 'Rs. '+item?.sub_total,
        discount: 'Rs. '+item?.discount,
        tax: 'Rs. '+item?.total_tax,
        total: 'Rs. '+item?.total_amount,
        paid:'Rs. '+0,
        balance:'Rs. '+item?.total_amount,
    }))
);
</script>
<template>
    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                       :edit="'student.edit'" :deleteUrl="'student.delete'">

                    </Table>
</template>
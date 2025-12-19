<script setup>
    import AddCallLog from '@/Components/AddForm/AddCallLog.vue';
import AddCategory from '@/Components/AddForm/AddCategory.vue';
import AddPostalDispatch from '@/Components/AddForm/AddPostalDispatch.vue';
import AddVisitor from '@/Components/AddForm/AddVisitor.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Table from '@/Components/Table.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed } from 'vue';


const props=defineProps({
    postalDispatchs:Object,
    postalDispatch:Object,
})
const columns = [
    { label: "S.N.", key: "sn" },
    { label: "To Title", key: "to_title" },
    { label: "To Phone", key: "phone_number" },
    { label: "Reference", key: "reference" },
    { label: "From Title", key: "from_title" },
    { label: "Date", key: "date" },
    // { label: "No. of Bed", key: "no_of_bed" },
    { label: "Remarks", key: "remarks" },
    // { label: "Total Students", key: "students" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.postalDispatchs.map((item, index) => ({
        sn: index + 1,
        to_title:item?.to_title,
        phone_number:item?.phone_number,
        reference:item?.reference,
        from_title:item?.from_title,
        remarks:item?.remarks,
        date:item?.date,

        actions: item.id,
    }))
);
</script>
<template>
    <AppLayout>
        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Front Office' }, { label: 'Postal Dispatch' }]" />
                <AddPostalDispatch :postalDispatch="postalDispatch"/>
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                         :edit="'postalDispatch.edit'" :deleteUrl="'postalDispatch.delete'">

                    </Table>
                </div>
            </div>

        </template>
    </AppLayout>
    </template>
<script setup>
    import AddVisitor from '@/Components/AddForm/AddVisitor.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Table from '@/Components/Table.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed } from 'vue';


const props=defineProps({
    visitors:Object,
    visitor:Object,
})
const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Purpose", key: "purpose" },
    { label: "Name", key: "name" },
    { label: "Phone", key: "phone" },
    // { label: "No. of Bed", key: "no_of_bed" },
    { label: "Date", key: "date" },
    { label: "In Time", key: "in_time" },
    { label: "Out Time", key: "out_time" },
    // { label: "Total Students", key: "students" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.visitors.map((item, index) => ({
        sn: index + 1,
        purpose:item?.purpose,
        name:item?.name,
        phone:item?.phone,
        date:item?.date,
        in_time:item?.in_time,
        out_time:item?.out_time,

        actions: item.id,
    }))
);
</script>
<template>
    <AppLayout>
        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Front Office' }, { label: 'Visitor Book' }]" />
                <AddVisitor :visitor="visitor"/>
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                         :edit="'visitor.edit'" :deleteUrl="'visitor.delete'">

                    </Table>
                </div>
            </div>

        </template>
    </AppLayout>
    </template>
<script setup>
    import AddCallLog from '@/Components/AddForm/AddCallLog.vue';
import AddCategory from '@/Components/AddForm/AddCategory.vue';
import AddVisitor from '@/Components/AddForm/AddVisitor.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Table from '@/Components/Table.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed } from 'vue';


const props=defineProps({
    callLogs:Object,
    callLog:Object,
})
const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Name", key: "name" },
    { label: "Phone", key: "phone" },
    { label: "Next Follow Date", key: "date" },
    { label: "Call Type", key: "type" },
    // { label: "No. of Bed", key: "no_of_bed" },
    { label: "Remarks", key: "remarks" },
    // { label: "Total Students", key: "students" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.callLogs.map((item, index) => ({
        sn: index + 1,
        name:item?.name,
        phone:item?.phone,
        date:item?.follow_up_date,
        type:item?.call_type,
        remarks:item?.remarks,

        actions: item.id,
    }))
);
</script>
<template>
    <AppLayout>
        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Front Office' }, { label: 'Visitor Book' }]" />
                <AddCallLog :callLog="callLog"/>
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                         :edit="'callLog.edit'" :deleteUrl="'callLog.delete'">

                    </Table>
                </div>
            </div>

        </template>
    </AppLayout>
    </template>
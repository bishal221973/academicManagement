<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import Academic from "@/Components/Menus/Academic.vue";
import AddGroup from "@/Components/AddForm/AddGroup.vue";
const props = defineProps({
    settings: Object,
    groups: Object,
    group: Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Group", key: "group" },
    { label: "Description", key: "description" },
    { label: "Status", key: "status" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.groups.map((item, index) => ({
        sn: index + 1,
        group: item?.name,
        description: item?.description,
        status: item?.status,

        actions: item.id,
    }))
);
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Academic />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Group Management' }]" />
                <AddGroup :group="group" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'group.update.status'" :edit="'group.edit'" :deleteUrl="'group.delete'">

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
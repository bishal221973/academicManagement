<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import AddStudent from "@/Components/AddForm/AddStudent.vue";
import Inventory from "@/Components/Menus/Inventory.vue";
import AddStore from "@/Components/AddForm/AddStore.vue";
const props = defineProps({
    stores: Object,
    store: Object,
    bill:Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Store ID", key: "store_id" },
    { label: "Store", key: "store" },
    { label: "Address.", key: "address" },
    { label: "Status", key: "status" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.stores.map((item, index) => ({
        sn: index + 1,
        store_id: item?.store_id,
        store: item?.name,
        address: item?.address,
        status: item?.status,
        actions: item.id,
    }))
);
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Inventory />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Store Management' },{label:'Store'}]" />
                <AddStore :store="store" :bill="bill" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'store.update.status'" :edit="'store.edit'" :deleteUrl="'store.delete'">

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
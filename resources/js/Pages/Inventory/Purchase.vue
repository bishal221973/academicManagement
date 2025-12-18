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
import AddUnit from "@/Components/AddForm/AddUnit.vue";
import AddSupplier from "@/Components/AddForm/AddSupplier.vue";
import AddPurchase from "@/Components/AddForm/AddPurchase.vue";
const props = defineProps({
    purchases: Object,
    supplier: Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Name", key: "name" },
    { label: "Purchase Date", key: "purchaseDate" },
    { label: "Supplier", key: "supplier" },
    { label: "Purchase Qty", key: "purchaseQty" },
];

const tableData = computed(() =>
    props.purchases.map((item, index) => ({
        sn: index + 1,
        name: item?.product?.product,
        purchaseDate: item?.purchase_date,
        supplier: item?.supplier?.name,
        purchaseQty: item?.purchase_qty,
        actions: item.id,
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
                <Breadcrumb :breadcrumbs="[{ label: 'Inventory Management' },{label:'Purchase Products'}]" />
                <AddPurchase :supplier="supplier" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        >

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
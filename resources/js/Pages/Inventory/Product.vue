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
    products: Object,
    product: Object,
    bill:Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Product Code", key: "p_code" },
    { label: "Product.", key: "product" },
    { label: "Product Category", key: "category" },
    { label: "Unit", key: "unit" },
    { label: "Status", key: "status" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.products.map((item, index) => ({
        sn: index + 1,
        p_code: item?.product_code,
        product: item?.product ?? null,
        category: item?.category?.name ?? null,
        unit:item?.unit?.name,
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
                <Breadcrumb :breadcrumbs="[{ label: 'Store Management' },{label:'Unit'}]" />
                <AddProduct :product="product" />
                <!-- {{ product }} -->
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
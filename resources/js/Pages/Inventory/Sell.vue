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
import POS from "./Pos/POS.vue";
const props = defineProps({
    categories: Object,
    products:Object,
});
</script>

<template>
    <AppLayout>
        <!-- <template #sidebar>
            <Inventory />
        </template> -->

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Inventory Management' },{label:'Sell Products'}]" />
            </div>
            
            <POS :categories="categories" :products="products"/>

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
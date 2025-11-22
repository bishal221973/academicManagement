<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Toggle from '@/Components/Toggle.vue';
import Category from './Category.vue';
import Item from './Item.vue';
import Bill from './Bill.vue';
const props = defineProps({
    categories: Object,
    products: Object,
});

// selected category
const selectedCategory = ref('All');
const selectCategory = (category) => {
    selectedCategory.value = category;
};

// store qty for each product by id
const qty = ref({});

// increase qty
const increase = (id, quantity) => {
    if (!qty.value[id]) qty.value[id] = 0;
    if (qty.value[id] < quantity) {

        qty.value[id]++;
    }
};

// decrease qty
const decrease = (id) => {
    if (!qty.value[id]) return;
    if (qty.value[id] > 1) {
        qty.value[id]--;
    } else {
        delete qty.value[id];
    }
};

// computed list of current ordered products
const orderList = computed(() => {
    return props.products
        .filter(p => qty.value[p.id])
        .map(p => ({
            ...p,
            qty: qty.value[p.id],
            qty1: p.qty,
        }));
});
</script>
<template>
    <div class=" w-full gap-3">
        <div class="flex gap-3">
            <div class="w-full">
                <Category :selectCategory="selectCategory" :categories="categories"
                    :selectedCategory="selectedCategory" />


                <div class="flex mt-3">
                    <div class="w-full flex gap-3 ">
                        <div class="grid grid-cols-12 gap-4" style="width: 100%;">
                            <!-- {{ products[0] }} -->
                            <div v-for="(item, index) in products" :key="item.id"
                                class="bg-white rounded col-span-3 relative shadow">
                                <Item :data="item" :qty="qty" :increase="increase" />
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- CURRENT ORDER PANEL -->
            <Bill :student="student" :orderList="orderList" :increase="increase" :decrease="decrease" />
        </div>
    </div>
</template>

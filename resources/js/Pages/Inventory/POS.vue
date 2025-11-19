<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

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
const increase = (id) => {
    if (!qty.value[id]) qty.value[id] = 0;
    qty.value[id]++;
};

// decrease qty
const decrease = (id) => {
    if (!qty.value[id]) return;
    if (qty.value[id] > 1) {
        qty.value[id]--;
    } else {
        delete qty.value[id]; // remove when reaches 0
    }
};
</script>
<template>
    <div class=" w-full gap-3">
        <div class="flex gap-3">
            <div class="w-full">
                <div style="overflow: scroll;">
                    <div class="w-full py-1 rounded flex gap-3">
                        <button @click="selectCategory('All')"
                            :class="selectedCategory == 'All' ? 'bg-red-500 text-white' : 'bg-white'"
                            class=" px-5 pb-1 rounded-xl">
                            <small>All</small>
                        </button>

                        <button v-for="(item, index) in categories" :key="index" @click="selectCategory(item.name)"
                            :class="selectedCategory == item?.name ? 'bg-red-500 text-white' : 'bg-white'"
                            class=" px-5 pb-1 rounded-xl">
                            <small>{{ item?.name }}</small>
                        </button>
                    </div>
                </div>

                <div class="flex mt-3">
                    <div class="w-full flex gap-3 ">

                        <div class="grid grid-cols-12 gap-4" style="width: 100%;">
                            <div v-for="(item, index) in products" :key="item.id"
                                class="bg-white rounded col-span-3 relative shadow">
                                <img :src="'/blank.jpg'" alt="">

                                <div class="bg-red-300"
                                    style="position: absolute;top: 5px;left: 5px;background-color: red;height: 20px;width: 20px;display: flex;justify-content: center;align-items: center;border-radius: 50%;font-size: 10px;">
                                    {{ item?.qty }}
                                </div>

                                <div class="px-3">
                                    <small><b>{{ item?.product }}</b></small>
                                </div>
                                <div class="flex justify-between px-3 pb-3">
                                    <span>
                                        <small class="text-[10px]">Rs. {{ item?.rate }}</small>
                                    </span>
                                    <button @click="increase(item.id)">
                                        <i class="fa fa-plus text-[10px]"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>
            <div style="width: 400px;">
                <div class="p-3 rounded bg-white shadow">
                    <small><b>Current Order</b></small>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps({
    categories: Object,
    products: Object,
})

const selectedCategory = ref('All');

const selectCategory = (category) => {
    selectedCategory.value = category;
}
</script>
<template>
    <div class=" w-full gap-3">
        <div style="width:calc(100vw - 250px);overflow: scroll;">
            <div class="w-full py-1 rounded flex gap-3">
                <button @click="selectCategory('All')"
                    :class="selectedCategory == 'All' ? 'bg-red-500 text-white' : 'bg-white'"
                    class=" px-5 pb-1 rounded-xl">
                    <small>All</small>
                </button>
                <button :class="selectedCategory == item?.name ? 'bg-red-500 text-white' : 'bg-white'"
                    @click="selectCategory(item.name)" v-for="(item, index) in categories" :key="index"
                    class=" px-5 pb-1 rounded-xl">
                    <small>{{ item?.name }}</small>
                </button>
            </div>

        </div>

        <div class="flex mt-3">
            <div class="w-full flex gap-3">
                <div class="grid grid-cols-12 gap-4" style="width: 100%;">
                    <div v-for="(item, index) in products" :key="item"
                        class="bg-white rounded col-span-3 relative shadow">
                        <!-- {{ item }} -->
                        <img :src="'/blank.jpg'" alt="">
                        <div class="bg-red-300"
                            style="position: absolute;top: 5px;left: 5px;background-color: red;height: 20px;width: 20px;display: flex;justify-content: center;align-items: center;border-radius: 50%;font-size: 10px;">
                            {{ item?.qty }}
                        </div>
                        <div class="p-3">
                            <small><b>{{ item?.product }}</b></small>
                        </div>
                        <hr>
                        <div class="flex justify-between px-5">
                            <button><i class="fa fa-plus"></i></button>
                            <span>0</span>
                            <button><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div style="width: 350px;">
                    <div class="p-3 rounded bg-white shadow">
                        Hello
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
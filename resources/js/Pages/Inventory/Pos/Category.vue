<script setup>
const props = defineProps({
    selectCategory: Function,
    categories: Object,
    selectedCategory:String,
})
</script>
<template>
    <div style="overflow-x: auto;">
        <div class="w-full py-1 rounded flex gap-3">
            <button @click="selectCategory('All')"
                :class="selectedCategory == 'All' ? 'bg-red-500 text-white' : 'bg-white'" class=" px-5 pb-1 rounded-xl">
                <small>All</small>
            </button>

            <button v-for="(item, index) in categories" :key="index" @click="selectCategory(item.name,item.id)"
                :class="selectedCategory == item?.name ? 'bg-red-500 text-white' : 'bg-white'"
                class=" px-5 pb-1 rounded-xl">
                <small>{{ item?.name }}</small>
            </button>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
    data: Object,
    qty: Object,
    increase:Function,
})
</script>
<template>
    <img :src="'/blank.jpg'" alt="">
    <div v-if="qty[data.id]"
        class="absolute top-1 left-1 bg-red-600 text-white h-5 w-5 flex items-center justify-center rounded-full text-[10px]">
        {{ qty[data.id] }}
    </div>

    <div class="px-3">
        <small><b>{{ data?.product }}</b></small>
    </div>
 
    <div class="flex justify-between px-3 pb-3">
        <span class="absolute top-1 right-1 bg-gray-200 h-[15px]  flex justify-center items-center px-2 rounded-xl">
            <small class="text-[10px]">Rs. {{ data?.rate }}</small>
        </span>
        <span>
            <small class="text-[10px]">Qty :</small>
            <small class="text-[10px]">&nbsp;{{ data?.qty }}  {{ data?.unit?.name }}</small>
        </span>
        <button @click="increase(data.id,data?.qty)">
            <i class="fa fa-plus text-[10px]"></i>
        </button>
    </div>
</template>
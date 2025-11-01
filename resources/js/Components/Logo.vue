<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';

const logo=ref("");
onMounted(()=>{
    fetchLogo();
})
const fetchLogo=async()=>{
    const response=await axios.get(route('academy-setup.getLogo'));
    console.log(response)
    logo.value=response.data;
}
</script>
<template>
    <div v-if="logo">
        <img :src="logo" class="h-full" alt="">
    </div>
    
</template>
<script setup>
import Logo from './Logo.vue';
</script>
<template>
    <div class="print:hidden w-full bg-white px-3 py-1 rounded shadow shadow-main/20 flex justify-between items-center">
        <Logo class="h-[50px]"/>
        <div class="flex justify-between gap-3">
            {{ $page?.props?.auth?.user?.name }}
            <img :src="'/user.png'" class="h-[20px] w-[20px]" alt="">
        </div>
    </div>
</template>

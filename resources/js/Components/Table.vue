<script setup>
const props = defineProps({
    headers: {
        type: Array,
        default: () => [],
    },
});
</script>
<template>
    <table class="w-full table-auto border-collapse border border-slate-300">
        <thead>
            <tr>
                <th v-for="(item,index) in headers" :key="index">{{ item }}</th>
            </tr>
        </thead>
        <tbody>
            <slot name="rows"/>
        </tbody>
    </table>
</template>

<style scoped>
thead th{
    border: 1px solid #e2e8f0;
    padding: 8px;
    text-align: left;
    background-color: #f9fafb;
    font-weight: 600;
    font-size: 14px;
}
</style>
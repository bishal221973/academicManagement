<script setup>
const props = defineProps({
    student: Object,
})
</script>
<template>
    <div class="card mb-2">
        <small class="mb-2 bg-gray-100 block px-3 py-1 rounded text-gray-400">General Information</small>

        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Registration Date : </small>
            <small>{{ student?.registration_date }} </small>
        </div>
        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Phone : </small>
            <small>{{ student?.phone }} </small>
        </div>
        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Email : </small>
            <small>{{ student?.email }} </small>
        </div>
        <div class="flex mb-1 px-3">
            <small class="w-[200px]">National ID : </small>
            <small>{{ student?.national_id }} </small>
        </div>
    </div>
    <div class="card mb-2">
        <small class="mb-2 bg-gray-100 block px-3 py-1 rounded text-gray-400">Parent Information</small>

        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Father Name : </small>
            <small>{{ student?.registration_date }} </small>
        </div>
        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Father Phone : </small>
            <small>{{ student?.phone }} </small>
        </div>
        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Father Education : </small>
            <small>{{ student?.email }} </small>
        </div>
        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Father Profession : </small>
            <small>{{ student?.national_id }} </small>
        </div>

        <hr class="my-3">
        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Mother Name : </small>
            <small>{{ student?.registration_date }} </small>
        </div>
        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Mother Phone : </small>
            <small>{{ student?.phone }} </small>
        </div>
        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Mother Education : </small>
            <small>{{ student?.email }} </small>
        </div>
        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Mother Profession : </small>
            <small>{{ student?.national_id }} </small>
        </div>
    </div>

    <div class="card mb-2">
        <small class="mb-2 bg-gray-100 block px-3 py-1 rounded text-gray-400">Address Information</small>

        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Current Address : </small>
            <small>{{ student?.present_address }} </small>
        </div>
        <div class="flex mb-1 px-3">
            <small class="w-[200px]">Permanent Address : </small>
            <small>{{ student?.permanent_address }} </small>
        </div>
    </div>
</template>
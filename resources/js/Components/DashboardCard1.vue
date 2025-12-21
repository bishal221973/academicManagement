<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';

const props = defineProps({
    title: String,
    count: String,
    color: String,
    icon: String
})

onMounted(()=>{
    countStudents();
});

const totalStudents=ref(0);
const countStudents=async()=>{
    const response=await axios.get(route('student.count'));
    totalStudents.value=response.data;
}
</script>
<template>
    <div class=" p-3 rounded-md shadow-md bg-red-100">
        <div class="flex items-center gap-3">
            <div>
                <i class="fa-solid fa-graduation-cap text-[50px] text-red-300"></i>
            </div>
            <div class="block">
                <span class="block text-[12px] text-gray-700 bold uppercase">
                    Students
                </span>
                <span class="text-[20px] bold font-bold text-red-400">
                    {{ String(totalStudents).padStart(4,0) }}
                </span>
            </div>
        </div>
    </div>

</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DashboardCard from '@/Components/DashboardCard1.vue';
import DashboardCard1 from '@/Components/DashboardCard1.vue';
import DashboardCard2 from '@/Components/DashboardCard2.vue';
import DashboardCard3 from '@/Components/DashboardCard3.vue';
import DashboardCard4 from '@/Components/DashboardCard4.vue';
import CourseWiseStudent from '@/Components/CourseWiseStudent.vue';

const props = defineProps({
  courses: {
    type: Array,
    required: true
  }
})
</script>

<template>
    <AppLayout title="Dashboard">
        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Home' }]" />
            </div>
            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-3">
                    <DashboardCard1 
                    title="Students"
                    count="40"
                    color="red" />
                </div>
                 <div class="col-span-3">
                    <DashboardCard2 
                    title="Students"
                    count="40"
                    color="blue" />
                </div>
                <div class="col-span-3">
                    <DashboardCard3 
                    title="Students"
                    count="40"
                    color="green" />
                </div>
                <div class="col-span-3">
                    <DashboardCard4 
                    title="Students"
                    count="40"
                    color="blue" />
                </div>

                <div class="col-span-6">
                    <div class="bg-white shadow rounded p-3">
                        <!-- {{ courses }} -->
                        <CourseWiseStudent :courseStudents="courses"/>
                    </div>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

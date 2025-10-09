<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { ArrowRight } from "lucide-vue-next";
import Configuration from "@/Components/Menus/Configuration.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import AddCourse from "@/Components/AddForm/AddCourse.vue";
import { Move } from "lucide-vue-next";
import { Edit } from "lucide-vue-next";
import { Trash } from "lucide-vue-next";
import Switch from "@/Components/Switch.vue";
const props = defineProps({
    settings: Object,
    courses:Object,
    course:Object,
});


</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Configuration />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Course Management' }]" />
                <AddCourse :course="course"/>
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <div class="flex-1 w-full bg-white p-4">
                        <!-- Main content -->
                         <!-- {{ courses }} -->
                        <Table :headers="['S.N.', 'Course', 'Code', 'Status', 'Action']">
                            <template #rows>
                                <tr v-for="(item,index) in courses" :key="item">
                                <td>{{ index+1 }}</td>
                                <td>{{ item?.name }}</td>
                                <td>{{ item?.code }}</td>
                                <td><Switch v-model="item.status" :route="route('course.update.status',item)" /></td>
                                <td>
                                    <div class="flex">
                                        <Link :href="route('course.edit',item)"><component :is="Edit" class="h-[20px] text-blue-600"/></Link>
                                        <Link><component :is="Trash" class="h-[20px] text-red-600"/></Link>
                                    </div>
                                </td>
                            </tr>
                            </template>
                        </Table>
                    </div>
                </div>
            </div>

        </template>
    </AppLayout>
</template>
<style scoped>
tr,td{
    border: 1px solid #e2e8f0;
    padding: 8px;
    text-align: left;
    font-size: 13px;
}
</style>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import AddStudent from "@/Components/AddForm/AddStudent.vue";
import SelectCourse from "@/Components/Select/SelectCourse.vue";
import SelectSection from "@/Components/Select/SelectSection.vue";
import { useForm } from "@inertiajs/vue3";
import Icard from "@/Components/Icard/Theme1.vue";
import DefaultIcard from "@/Components/DefaultIcard.vue";
const props = defineProps({
    students: Object,
    student: Object,
    students: Object,
});

const filterForm = useForm({
    course_id: '',
    section_id: '',
})

const filterStudent = () => {
    filterForm.get(route('student.icard.index'), {
        preserveState: true,
        onSuccess: () => {

        }
    })
}
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Student />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Student Management' }, { label: 'Student Promotion' }]" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <div class="bg-white p-3 rounded shadow">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-5">
                                <SelectCourse v-model="filterForm.course_id" />
                            </div>
                            <div class="col-span-5">
                                <SelectSection v-model="filterForm.section_id" />
                            </div>
                            <div class="col-span-2">
                                <button @click="filterStudent"
                                    class="bg-blue-600 text-white px-4 py-2 w-full rounded hover:bg-blue-700"
                                    type="submit">
                                    Filter Students
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">

                        <div v-for="item in students" :key="item.id" class="mt-3 w-[200px] h-[320px]">
                            <DefaultIcard :student="item"/>
                           
                        </div>
                    </div>
                    <!-- <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'group.update.status'" :edit="'student.edit'" :deleteUrl="'student.delete'">

                    </Table> -->
                </div>
            </div>

        </template>
    </AppLayout>
</template>
<style scoped>
tr,
td {
    border: 1px solid #e2e8f0;
    padding: 8px;
    text-align: left;
    font-size: 13px;
}
</style>
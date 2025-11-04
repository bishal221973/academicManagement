<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import Hostel from "@/Components/Menus/Hostel.vue";
import AddHostel from "@/Components/AddForm/AddHostel.vue";
import Library from "@/Components/Menus/Library.vue";
import AddLibrary from "@/Components/AddForm/AddLibrary.vue";
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
const props = defineProps({
    books: Object,
    hostel: Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Course", key: "course" },
    { label: "Subject", key: "name" },
    { label: "Qty", key: "qty" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.books.map((student, index) => ({
        sn: index + 1,
        course: student?.course?.name,
        name: student?.name,
        qty: student?.qty + " Books",
        status: student?.status,

        actions: student.id,
    }))
);

const showAddBook = ref(false);

const addFunction = () => {
    showAddBook.value = !showAddBook.value;
    // alert('Hello')
}

const form=useForm({
    course:"",
    subject_id:"",
    subject:"",
    qty:""
})
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Library />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Library Management' }, { label: 'Library' }]" />
                <AddLibrary :hostel="hostel" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'hostel.update.status'" :addBook="'book.add'" :addFunction="addFunction">
                    </Table>
                </div>
            </div>

            <Modal :show="showAddBook" maxWidth="sm" :title="'Purchase Book'" @close="addFunction">
                <div class="mb-3">
                    <label class="text-[14px]">Course *</label>
                    <input type="text" v-model="form.course"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter course name" />
                    <small class="text-red-600">{{ form.errors.course }}</small>
                </div>
                <div class="mb-3">
                    <label class="text-[14px]">Subject *</label>
                    <input type="text" v-model="form.subject"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter subject name" />
                    <small class="text-red-600">{{ form.errors.subject }}</small>
                </div>
                <div class="mb-3">
                    <label class="text-[14px]">Purchase qty *</label>
                    <input type="text" v-model="form.qty"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter quantity" />
                    <small class="text-red-600">{{ form.errors.subject }}</small>
                </div>
            </Modal>
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
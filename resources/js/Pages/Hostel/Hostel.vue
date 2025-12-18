<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import Hostel from "@/Components/Menus/Hostel.vue";
import AddHostel from "@/Components/AddForm/AddHostel.vue";
const props = defineProps({
    hostels: Object,
    hostel: Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Hostel Name", key: "name" },
    { label: "Address", key: "address" },
    { label: "Type", key: "type" },
    { label: "Total Rooms", key: "rooms" },
    // { label: "Total Students", key: "students" },
    { label: "Status", key: "status" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.hostels.map((student, index) => ({
        sn: index + 1,
        name: student?.name,
        url: route('hostel.show', student.id) + "?room_id=" + (student?.rooms?.length ? student.rooms[0].id : ''), address: student?.address,
        type: student?.type,
        rooms: (student?.rooms?.length || 0) + " Rooms",
        // students: (student?.students?.length || 0) + " Students",
        status: student?.status,

        actions: student.id,
    }))
);
</script>

<template>
    <AppLayout>
        <!-- <template #sidebar>
            <Hostel />
        </template> -->

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Hostel Management' }, { label: 'Hostel' }]" />
                <AddHostel :hostel="hostel" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'hostel.update.status'" :edit="'hostel.edit'" :deleteUrl="'hostel.delete'">

                    </Table>
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
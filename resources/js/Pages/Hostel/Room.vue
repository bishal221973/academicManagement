<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import Hostel from "@/Components/Menus/Hostel.vue";
import AddHostel from "@/Components/AddForm/AddHostel.vue";
import AddRoom from "@/Components/AddForm/AddRoom.vue";
const props = defineProps({
    rooms: Object,
    room: Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Hostel Name", key: "hostel" },
    { label: "Room", key: "name" },
    { label: "No. of Bed", key: "no_of_bed" },
    { label: "Type", key: "type" },
    { label: "Price", key: "price" },
    { label: "Total Students", key: "students" },
    { label: "Status", key: "status" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.rooms.map((item, index) => ({
        sn: index + 1,
        hostel: item?.hostel?.name,
        name: item?.name,
        no_of_bed: item?.no_of_bed,
        type: item?.type,
        price: "Rs. " + item?.price,
        students: (item?.students?.length || 0) + " Students",
        status: item?.status,

        actions: item.id,
    }))
);
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Hostel />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Hostel Management' }, { label: 'Rooms' }]" />
                <AddRoom :room="room" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'room.update.status'" :edit="'room.edit'" :deleteUrl="'room.delete'">

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
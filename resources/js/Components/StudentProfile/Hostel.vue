<script setup>
import { computed } from 'vue';
import Table from '../Table.vue';
import TableMultiLevel from '../TableMultiLevel.vue';
import ImageUploader from '../ImageUploader.vue';
import { Link, useForm } from '@inertiajs/vue3';
import HostelBooking from './HostelBooking.vue';
import RenewHostel from '../RenewHostel.vue';
const props = defineProps({
  student: Object,
  features:Object,
});

const form = useForm({
  front: props?.student?.nationality_card_front ? '/storage/' + props?.student?.nationality_card_front : "",
  back: props?.student?.nationality_card_back ? '/storage/' + props?.student?.nationality_card_back : "",
});

const upload = () => {
  form.post(route('student.upload.citizenship', props.student?.id));
};


const columns = [
  { label: "S.N.", key: "sn" },
  { label: "Hostel", key: "hostel" },
  { label: "Status", key: "boolean" },
  { label: "Checkin", key: "checkin" },
  { label: "Checkout", key: "checkout" },
  { label: "Room No.", key: "roomNo" },
  { label: "Bed No.", key: "bed" },
];

// const tableData = computed(() => {
//   if (!props.student?.hostels) return [];

//   const today = new Date();

//   // Split hostels into running and past
//   const running = [];
//   const past = [];

//   props.student.hostels.forEach((item) => {
//     const checkOut = new Date(item.check_out_date);
//     if (checkOut >= today) {
//       running.push(item);
//     } else {
//       past.push(item);
//     }
//   });

//   // Combine so that running hostels come first
//   const sortedHostels = [...running, ...past];

//   // Map to table-friendly format
//   return sortedHostels.map((item, index) => {
//     const checkOut = new Date(item.check_out_date);
//     const isStaying = checkOut >= today;

//     return {
//       sn: index + 1,
//       hostel: item?.hostel?.name,
//       boolean: isStaying ? "Staying" : "Checked Out",
//       checkin: item?.check_in_date,
//       checkout: item?.check_out_date,
//       roomNo: item?.room?.name,
//       bed: item?.bed_no,
//       boolean: isStaying,
//     };
//   });
// });

const tableData = computed(() => {
  if (!props.student?.hostels) return [];

  const today = new Date();

  const running = [];
  const past = [];

  props.student.hostels.forEach((item) => {
    const checkOut = new Date(item.check_out_date);
    if (checkOut >= today) {
      running.push(item);
    } else {
      past.push(item);
    }
  });

  // 🔽 Sort both by latest check_in_date
  const sortByLatest = (a, b) =>
    new Date(b.check_in_date) - new Date(a.check_in_date);

  running.sort(sortByLatest);
  past.sort(sortByLatest);

  const sortedHostels = [...running, ...past];

  return sortedHostels.map((item, index) => {
    const checkOut = new Date(item.check_out_date);
    const isStaying = checkOut >= today;

    return {
      sn: index + 1,
      hostel: item?.hostel?.name,
      status: isStaying ? "Staying" : "Checked Out",
      checkin: item?.check_in_date,
      checkout: item?.check_out_date,
      roomNo: item?.room?.name,
      bed: item?.bed_no,
      boolean: isStaying,
      hostel_id: item?.hostel?.id,
      room_id: item?.room?.id,
      price: item?.room?.price,
    };
  });
});

</script>

<template>
  <div class="flex justify-end">
    <!-- <Link :href="route('hostelStudent.index')+'?phone='+student?.phone" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" v-if="tableData?.length <= 0">Add New</Link> -->
    <!-- <div v-else> -->
    <Link :href="route('hostelStudent.index')+'?phone='+student?.phone" v-if="tableData[0]?.boolean == false" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" >Renew</Link>
    <!-- <RenewHostel :data="tableData[0] ?? null" :student="student" :features="features"/> -->
    <!-- <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" v-if="tableData[0]?.boolean == false">Renew</button> -->
  <!-- </div> -->
  </div>
  <!-- {{ tableData[0]?.boolean }} -->
  <Table :columns="columns" :data="tableData" exportTitle="Student List"></Table>
</template>

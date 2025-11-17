
<script setup>
import { computed } from 'vue';
import Table from '../Table.vue';
import TableMultiLevel from '../TableMultiLevel.vue';
import ImageUploader from '../ImageUploader.vue';
import { useForm } from '@inertiajs/vue3';
import HostelBooking from './HostelBooking.vue';
const props = defineProps({
  student: Object,
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

const tableData = computed(() => {
  if (!props.student?.hostels) return [];

  const today = new Date();

  // Split hostels into running and past
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

  // Combine so that running hostels come first
  const sortedHostels = [...running, ...past];

  // Map to table-friendly format
  return sortedHostels.map((item, index) => {
    const checkOut = new Date(item.check_out_date);
    const isStaying = checkOut >= today;

    return {
      sn: index + 1,
      hostel: item?.hostel?.name,
      boolean: isStaying ? "Staying" : "Checked Out",
      checkin: item?.check_in_date,
      checkout: item?.check_out_date,
      roomNo: item?.room?.name,
      bed: item?.bed_no,
      boolean:isStaying,
    };
  });
});
</script>

<template>
  <!-- <HostelBooking :student="student"/> -->
  
  <Table :columns="columns" :data="tableData" exportTitle="Student List"></Table>
</template>

<script setup>
import SelectComponent from '../SelectComponent.vue';
import AddSection from '../AddForm/AddSection.vue';
import { computed, onMounted, ref, watch } from 'vue';
import AddStudent from '../AddForm/AddStudent.vue';
import AddRoom from '../AddForm/AddRoom.vue';
const props = defineProps({
  modelValue: [String, Number], // the value coming from parent
  hostelId: [String, Number],
  lastRoom:[String,Number]
});

const emit = defineEmits(["update:modelValue"]);

const courseList = ref([]);

const fetchSection = async (hostelId=null) => {
 
  const response = await axios.get(route("room.all"), {
    params: { hostel_id: hostelId ?? props?.hostelId ?? "" }
  });
  courseList.value = response.data.rooms;
};

onMounted(() => {
  fetchSection();
  // alert("Hello")

  Pusher.logToConsole = true;

  var pusher = new Pusher('09a7a9ef059d4f63aa24', {
      cluster: 'ap2'
    });

  const channel = pusher.subscribe("my-channel");

  channel.bind("hostel-room-event", () => {
    fetchSection();
  });
});

const transformData = (data) => {
  if (data && data.length > 0) {
    return data.map((item) => ({
      label: item?.name,
      value: item.id,
    }));
  }
  return [];
};

const formattedServiceData = computed(() => transformData(courseList.value));

watch(() => props.hostelId, (newVal) => {
  // alert(newVal)
  fetchSection(newVal)
  emit("update:modelValue", null);
},{ immediate: true });

watch(() => props.lastRoom, (newVal) => {
  // alert(newVal)
  // fetchSection(newVal)
  emit("update:modelValue", newVal);
},{ immediate: true });
</script>
<template>
    <div class="w-full border-[1px] border-gray-300 rounded-md flex px-3">
        <SelectComponent :options="formattedServiceData" 
        label="Date Format *"
         placeholder="Select student"
          :isForm="true"
          @update:modelValue="val => emit('update:modelValue', val)"
          :modelValue="modelValue" />
        <AddRoom :isSelect="true"/>
    </div>
</template>
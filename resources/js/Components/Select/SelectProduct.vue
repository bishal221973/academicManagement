<script setup>
import SelectComponent from '../SelectComponent.vue';
import AddCourse from '../AddForm/AddCourse.vue';
import { computed, onMounted, ref, watch } from 'vue';
import AddProduct from '../AddForm/AddProduct.vue';
const dateOptions = [
    { label: "AD Date", value: "ad" },
    { label: "BS Date", value: "bs" },
];

const props = defineProps({
  modelValue: [String, Number],
  categoryId:String,
});

const emit = defineEmits(["update:modelValue"]);

const courseList = ref([]);

const fetchData = async () => {
  const response = await axios.get(route("product.get.all")+'?category_id='+props?.categoryId);
  courseList.value = response.data.products;
};

watch(()=>(props?.categoryId),()=>{
  fetchData();
});

onMounted(() => {
  fetchData();

  Pusher.logToConsole = true;

  var pusher = new Pusher('09a7a9ef059d4f63aa24', {
      cluster: 'ap2'
    });

  const channel = pusher?.subscribe("my-channel");

  channel.bind("product-event", () => {
    fetchData();
  });
});

const transformData = (data) => {
  if (data) {
    return data.map((item) => ({
      label: item?.name ?? item?.product,
      value: item.id,
    }));
  }
  return [];
};
const formattedServiceData = computed(() => transformData(courseList.value));
</script>
<template>
    <div class="w-full border-[1px] border-gray-300 rounded-md flex px-3">
        <SelectComponent :options="formattedServiceData" 
        label="Date Format *"
         placeholder="Select Product"
          :isForm="true"
          @update:modelValue="val => emit('update:modelValue', val)"
          :modelValue="modelValue" />
        <AddProduct :isSelect="true"/>
    </div>
</template>
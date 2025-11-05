<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import Theme1 from "./Icard/Theme1.vue";
import Theme2 from "./Icard/Theme2.vue";

const props=defineProps({
    student:Object,
})
const icard = ref(null);



// Fetch iCard from backend
const fetchIcard = async () => {
  try {
    const response = await axios.get(route("icard.default"));
    icard.value = response.data.icard; // {"id":2,"name":"Theme2",...}
    console.log("ICard fetched:", icard.value);
  } catch (error) {
    console.error("Error fetching icard:", error);
  }
};

// Compute the selected theme component

onMounted(fetchIcard);

</script>

<template>
  <div class="mt-3 w-[200px] h-[320px]">
    <!-- {{ student }} -->
      <!-- {{ student }} -->
    <Theme1 v-if="icard?.name == 'Theme1'" :student="student"/>
    <Theme2 v-if="icard?.name == 'Theme2'" :student="student"/>
  </div>
</template>

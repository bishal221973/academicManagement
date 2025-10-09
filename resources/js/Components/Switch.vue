<template>
  <label
    :class="['switch', sizeClass]"
    :style="{ backgroundColor: isChecked ? onColor : offColor }"
  >
    <input type="checkbox" :checked="isChecked" @change="toggle" />
    <span class="slider round"></span>
  </label>
</template>

<script setup>
import { computed } from "vue";
import axios from "axios";
import Swal from "sweetalert2";
const props = defineProps({
  modelValue: { type: Boolean, default: false },
  size: { type: String, default: "md" }, // sm, md, lg
  onColor: { type: String, default: "#fff" },
  offColor: { type: String, default: "#ccc" },
  route: String,
});

const emits = defineEmits(["update:modelValue"]);

const isChecked = computed({
  get: () => props.modelValue,
  set: (val) => emits("update:modelValue", val),
});

const toggle = async (e) => {
  isChecked.value = e.target.checked;
  const newStatus = e.target.checked; // true or false
  isChecked.value = newStatus;

  try {
    await axios.put(props.route, {
      status: newStatus,
    });

    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      },
    });
    Toast.fire({
      icon: "success",
      title: "Status changed successfully !",
    });
  } catch (error) {
    console.error("Failed to update status:", error);
    // Revert toggle on error
    isChecked.value = !newStatus;
  }
};

const changeStatus = async () => {
  await axios.get(route);
};

const sizeClass = computed(() => {
  switch (props.size) {
    case "sm":
      return "h-4 w-8";
    case "lg":
      return "h-8 w-16";
    default:
      return "h-6 w-12"; // md
  }
});
</script>

<style scoped>
.switch {
  display: inline-block;
  height: 15px;
  position: relative;
  width: 20px;
  border-radius: 20px;
}

.switch input {
  display: none;
}

.slider {
  background-color: #ccc;
  bottom: 0;
  cursor: pointer;
  left: 0;
  position: absolute;
  right: -20px;
  top: -4px;
  transition: 0.4s;
  border-radius: 10px;
}

.slider:before {
  background-color: #fff;
  bottom: 2px;
  content: "";
  height: 15px;
  left: 4px;
  position: absolute;
  transition: 0.4s;
  width: 15px;
}

input:checked + .slider {
  background-color: #D9A250;
}

input:checked + .slider:before {
  transform: translateX(18px) !important;
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<template>
  <div class="month-select-dropdown" ref="dropdownRef">

    <!-- Dropdown button -->
    <div class="dropdown-toggle" @click="toggleDropdown">
      <span v-if="internalValue.length">
        {{ selectedLabels.join(', ') }}
      </span>
      <span v-else class="placeholder">Select months...</span>
      <svg
        class="chevron"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="2"
        stroke="currentColor"
      >
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
      </svg>
    </div>

    <!-- Dropdown menu -->
    <div v-if="open" class="dropdown-menu">
      <label
        v-for="month in months"
        :key="month.value"
        class="dropdown-item"
      >
        <input
          type="checkbox"
          :value="month.value"
          v-model="internalValue"
        />
        <span>{{ month.label }}</span>
      </label>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, defineProps, defineEmits, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
  modelValue: {
    type: Array,
    default: () => []
  },
  label: {
    type: String,
    default: 'Select Nepali Months'
  }
})

const emit = defineEmits(['update:modelValue'])

const months = [
  { value: 1, label: 'Baishakh' },
  { value: 2, label: 'Jestha' },
  { value: 3, label: 'Ashadh' },
  { value: 4, label: 'Shrawan' },
  { value: 5, label: 'Bhadra' },
  { value: 6, label: 'Ashwin' },
  { value: 7, label: 'Kartik' },
  { value: 8, label: 'Mangsir' },
  { value: 9, label: 'Poush' },
  { value: 10, label: 'Magh' },
  { value: 11, label: 'Falgun' },
  { value: 12, label: 'Chaitra' }
]

const internalValue = ref([...props.modelValue])
const open = ref(false)
const dropdownRef = ref(null)

const selectedLabels = computed(() =>
  months
    .filter(m => internalValue.value.includes(m.value))
    .map(m => m.label)
)

const toggleDropdown = () => {
  open.value = !open.value
}

// Close dropdown when clicking outside
const handleClickOutside = (e) => {
  if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
    open.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})

watch(internalValue, (newVal) => {
  emit('update:modelValue', newVal)
})

watch(
  () => props.modelValue,
  (newVal) => {
    internalValue.value = [...newVal]
  }
)
</script>

<style scoped>
.month-select-dropdown {
  position: relative;
  width: 100%;
  max-width: 300px;
  font-family: sans-serif;
}

.label {
  font-weight: 600;
  color: #333;
  display: block;
  margin-bottom: 6px;
}

.dropdown-toggle {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: 1px solid #ccc;
  border-radius: 6px;
  padding: 8px 10px;
  background-color: #fff;
  cursor: pointer;
  transition: border-color 0.2s;
}

.dropdown-toggle:hover {
  border-color: #4a90e2;
}

.placeholder {
  color: #999;
}

.chevron {
  width: 18px;
  height: 18px;
  color: #555;
}

.dropdown-menu {
  position: absolute;
  top: 105%;
  left: 0;
  width: 100%;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 6px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  z-index: 10;
  max-height: 240px;
  overflow-y: auto;
  margin-top: 4px;
}

.dropdown-item {
  display: flex;
  align-items: center;
  padding: 6px 10px;
  cursor: pointer;
  transition: background 0.2s;
}

.dropdown-item:hover {
  background-color: #f5f8ff;
}

.dropdown-item input[type="checkbox"] {
  margin-right: 8px;
}
</style>

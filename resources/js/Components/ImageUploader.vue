<script setup>
import { ref, watch } from "vue";
import { Image } from "lucide-vue-next";

const props = defineProps({
  modelValue: [File, String, null], // Accept File, String (existing URL), or null
});

const emit = defineEmits(["update:modelValue"]);

const preview = ref(null);

// Watch modelValue to set preview
watch(
  () => props.modelValue,
  (newVal) => {
    if (!newVal) {
      preview.value = null;
    } else if (typeof newVal === "string") {
      // Existing logo URL
      preview.value = { file: null, url: newVal };
    } else if (newVal instanceof File) {
      // New uploaded file
      const reader = new FileReader();
      reader.onload = (e) => {
        preview.value = { file: newVal, url: e.target.result };
      };
      reader.readAsDataURL(newVal);
    }
  },
  { immediate: true }
);

function handleFile(file) {
  if (!file.type.startsWith("image/")) return;

  const reader = new FileReader();
  reader.onload = (e) => {
    preview.value = { file, url: e.target.result };
    emit("update:modelValue", file);
  };
  reader.readAsDataURL(file);
}

function handleDrop(e) {
  e.preventDefault();
  const file = e.dataTransfer.files[0];
  if (file) handleFile(file);
}

function handleDragOver(e) {
  e.preventDefault();
}

function removeImage() {
  preview.value = null;
  emit("update:modelValue", null);
}

function onFileChange(e) {
  const file = e.target.files[0];
  if (file) handleFile(file);
}
</script>


<template>
  <div>
    <div
      class="main-panel rounded-md p-3 cursor-pointer hover:border-blue-500 transition flex items-center justify-center"
      style="min-height: 200px;"
      @drop="handleDrop"
      @dragover="handleDragOver"
      @click="$refs.fileInput.click()"
    >
      <!-- Preview -->
      <div v-if="preview" class="relative w-48 h-48">
        <img :src="preview.url" class="w-full h-full object-cover rounded-md border" />
        <button type="button"
          @click.stop="removeImage"
          class=" bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs"
        >×</button>
      </div>

      <!-- Placeholder -->
      <div v-else class="text-center text-gray-500">
        <div class="flex justify-center mb-3">
          <component :is="Image" />
        </div>
        <p>Drag & Drop an image here or click to browse</p>
      </div>

      <input
        type="file"
        ref="fileInput"
        class="hidden"
        accept="image/*"
        @change="onFileChange"
      >
    </div>
  </div>
</template>

<style scoped>
.main-panel {
  border: 2px dashed rgba(128, 128, 128, 0.382);
}

.main-panel:hover {
  border: 2px dashed blue;
}

img {
  border-radius: 0.5rem;
  height: 200px;
  /* width: 150px; */
}
button{
  position: absolute;
  top: 0;
  right: -30px;
}
</style>

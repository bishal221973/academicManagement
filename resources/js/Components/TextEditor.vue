<template>
  <div class="rte w-full" :class="wrapperClass">
    <div v-if="toolbar" class="rte-toolbar mb-2 flex flex-wrap gap-2 bg-white p-2 rounded shadow-sm">
      <div class="flex gap-1 items-center">
        <button class="rte-btn px-2 py-1 rounded hover:bg-gray-100" @click.prevent="exec('bold')" title="Bold" type="button">B</button>
        <button class="rte-btn px-2 py-1 rounded hover:bg-gray-100" @click.prevent="exec('italic')" title="Italic" type="button">I</button>
        <button class="rte-btn px-2 py-1 rounded hover:bg-gray-100" @click.prevent="exec('underline')" title="Underline" type="button">U</button>
      </div>

      <div class="flex gap-1 items-center">
        <button class="rte-btn px-2 py-1 rounded hover:bg-gray-100" @click.prevent="formatBlock('H1')" title="H1">H1</button>
        <button class="rte-btn px-2 py-1 rounded hover:bg-gray-100" @click.prevent="formatBlock('H2')" title="H2">H2</button>
        <button class="rte-btn px-2 py-1 rounded hover:bg-gray-100" @click.prevent="formatBlock('P')" title="Paragraph">P</button>
      </div>

      <div class="flex gap-1 items-center">
        <button class="rte-btn px-2 py-1 rounded hover:bg-gray-100" @click.prevent="exec('insertUnorderedList')" title="Bulleted">•</button>
        <button class="rte-btn px-2 py-1 rounded hover:bg-gray-100" @click.prevent="exec('insertOrderedList')" title="Numbered">1.</button>
      </div>

      <div class="flex gap-1 items-center">
        <button class="rte-btn px-2 py-1 rounded hover:bg-gray-100" @click.prevent="createLink" title="Insert Link">Link</button>
        <button class="rte-btn px-2 py-1 rounded hover:bg-gray-100" @click.prevent="insertImage" title="Insert Image">Image</button>
      </div>

      <div class="flex gap-1 items-center ml-auto">
        <button class="rte-btn px-2 py-1 rounded hover:bg-gray-100" @click.prevent="clear" title="Clear">Clear</button>
      </div>

      <input ref="imageInput" type="file" accept="image/*" class="hidden" @change="onImageSelected" />
    </div>

    <div
      ref="editor"
      class="rte-editor bg-white rounded p-3 min-h-[150px] overflow-auto prose max-w-full"
      :contenteditable="!readonly"
      :placeholder="placeholder"
      @input="onInput"
      @paste.prevent="onPaste"
      @blur="emitModel"
      v-html="internalValue"
      :style="{ minHeight: minHeight + 'px' }"
    ></div>

    <div v-if="showCounter" class="text-sm text-gray-500 mt-1">{{ plainTextLength }} characters</div>
  </div>
</template>

<script setup>
import { ref, watch, computed, nextTick } from 'vue';

const props = defineProps({
  modelValue: { type: String, default: '' },
  placeholder: { type: String, default: 'Start typing...' },
  toolbar: { type: Boolean, default: true },
  readonly: { type: Boolean, default: false },
  minHeight: { type: Number, default: 150 },
  sanitize: { type: Boolean, default: true },
  uploadImage: { type: Function, default: null }, // optional async function(file) => url
  wrapperClass: { type: String, default: '' },
  showCounter: { type: Boolean, default: false },
});

const emit = defineEmits(['update:modelValue', 'input', 'clear']);
const editor = ref(null);
const imageInput = ref(null);
const internalValue = ref(props.modelValue || '');

watch(() => props.modelValue, (v) => {
  if (v !== internalValue.value) internalValue.value = v || '';
});

// expose methods
function exec(command, value = null) {
  if (props.readonly) return;
  document.execCommand(command, false, value);
  syncToModel();
}

function formatBlock(tag) {
  if (props.readonly) return;
  document.execCommand('formatBlock', false, tag);
  syncToModel();
}

function createLink() {
  if (props.readonly) return;
  const url = prompt('Enter URL');
  if (url) {
    document.execCommand('createLink', false, url);
    syncToModel();
  }
}

function insertImage() {
  if (props.readonly) return;
  imageInput.value && imageInput.value.click();
}

async function onImageSelected(e) {
  const file = e.target.files?.[0];
  if (!file) return;

  // if user provided an uploadImage function, use it
  if (props.uploadImage && typeof props.uploadImage === 'function') {
    try {
      const url = await props.uploadImage(file);
      if (url) document.execCommand('insertImage', false, url);
    } catch (err) {
      console.error('uploadImage failed', err);
      // fall back to local object url
      const localUrl = URL.createObjectURL(file);
      document.execCommand('insertImage', false, localUrl);
    }
  } else {
    // fallback: insert local object url
    const localUrl = URL.createObjectURL(file);
    document.execCommand('insertImage', false, localUrl);
  }

  // clear file input so same file can be chosen later
  e.target.value = null;
  syncToModel();
}

function onInput() {
  internalValue.value = editor.value.innerHTML;
  emit('input', internalValue.value);
  emit('update:modelValue', internalValue.value);
}

function emitModel() {
  emit('update:modelValue', internalValue.value);
}

function syncToModel() {
  nextTick(() => {
    internalValue.value = editor.value.innerHTML;
    emit('update:modelValue', internalValue.value);
  });
}

function clear() {
  if (props.readonly) return;
  editor.value.innerHTML = '';
  internalValue.value = '';
  emit('clear');
  emit('update:modelValue', '');
}

function onPaste(e) {
  // simple paste sanitization: insert plaintext to avoid nasty formatting
  e.preventDefault();
  const text = (e.clipboardData || window.clipboardData).getData('text/plain');
  document.execCommand('insertText', false, text);
  syncToModel();
}

const plainTextLength = computed(() => {
  const el = document.createElement('div');
  el.innerHTML = internalValue.value || '';
  return el.innerText.trim().length;
});

// allow parent to call methods via ref
defineExpose({
  clear,
  exec,
  formatBlock,
  getHtml: () => internalValue.value,
  setHtml: (html) => {
    if (editor.value) editor.value.innerHTML = html || '';
    internalValue.value = html || '';
  },
});
</script>

<style scoped>
.rte-editor:empty:before {
  content: attr(placeholder);
  color: #9ca3af; /* Tailwind gray-400 */
  pointer-events: none;
  direction: ltr;
  text-align: left;
}

.rte-toolbar .rte-btn { font-weight: 600; }

/* basic prose sizing so pasted content looks decent */
.prose img { max-width: 100%; height: auto; }
</style>
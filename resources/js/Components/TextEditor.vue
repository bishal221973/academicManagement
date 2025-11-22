<script setup>
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import { onMounted, ref, watch } from "vue";

const props = defineProps({
  default: String,
  modelValue: {
    type: String,
    default: "",
  },
});

const emit=defineEmits(["update:modelValue"]);
const editor = useEditor({
    onUpdate:({editor})=>{
        emit('update:modelValue',editor.getHTML());
    },
  editorProps: {
    attributes: {
      class: "border-[1px] border-gray-300 p-2  min-h-[150px]",
    },
  },
  content: props?.modelValue ?? props.default ?? "",
  extensions: [StarterKit],
});
watch(
  () => props.modelValue,
  (newValue) => {
    if (!editor.value) return;

    if (newValue !== editor.value.getHTML()) {
      editor.value.commands.setContent(newValue, false);
    }
  }
);

watch(
  () => props.default,
  (newValue) => {
    if (editor && editor.commands) {
      editor.commands.setContent(newValue || "");
    }
  }
);
</script>

<template>
  <section
    v-if="editor"
    class="buttons rounded mb-1 flex items-center flex-wrap gap-x-4 border border-gray-300 px-4 py-2 sticky z-50 bg-white" style="top: 0px;"
  >
    <button type="button"
      @click="editor.chain().focus().toggleBold().run()"
      :disabled="!editor.can().chain().focus().toggleBold().run()"
      :class="{ 'is-active': editor.isActive('bold') }"
    >
      <i class="fa fa-bold"></i>
    </button>
    <button type="button"
      @click="editor.chain().focus().toggleItalic().run()"
      :disabled="!editor.can().chain().focus().toggleItalic().run()"
      :class="{ 'is-active': editor.isActive('italic') }"
    >
      <i class="fa fa-italic"></i>
    </button>
    <button type="button"
      @click="editor.chain().focus().toggleStrike().run()"
      :disabled="!editor.can().chain().focus().toggleStrike().run()"
      :class="{ 'is-active': editor.isActive('strike') }"
    >
      <i class="fa fa-strikethrough"></i>
    </button>
    <button type="button" @click="editor.chain().focus().setHorizontalRule().run()">
      <i class="fa fa-minus"></i>
    </button>
    <button type="button"
      @click="editor.chain().focus().undo().run()"
      :disabled="!editor.can().chain().focus().undo().run()"
    >
      <i class="fa-solid fa-rotate-left"></i>
    </button>
    <button type="button"
      @click="editor.chain().focus().redo().run()"
      :disabled="!editor.can().chain().focus().redo().run()"
    >
      <i class="fa-solid fa-rotate-right"></i>
    </button>
    <!-- <button
      @click="editor.chain().focus().setTextAlign('left').run()"
      :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }"
    >
      <i class="fa-solid fa-align-left"></i>
    </button>
     <button
      @click="editor.chain().focus().setTextAlign('center').run()"
      :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }"
    >
      <i class="fa-solid fa-align-center"></i>
    </button>
    <button
      @click="editor.chain().focus().setTextAlign('right').run()"
      :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }"
    >
      <i class="fa-solid fa-align-right"></i>
    </button> -->
    <!-- <button
      @click="editor.chain().focus().toggleHighlight().run()"
      :class="{ 'is-active': editor.isActive('highlight') }"
    >
      <i class="fa-solid fa-highlighter"></i>
    </button>
    
   
    <button
      @click="editor.chain().focus().setTextAlign('justify').run()"
      :class="{ 'is-active': editor.isActive({ textAlign: 'justify' }) }"
    >
      <i class="fa-solid fa-align-justify"></i>
    </button> -->
  </section>
  <editor-content :editor="editor"/>
</template>

<style scoped>
.table-component {
  height: calc(100vh - 200px);
  overflow: auto;
}
th {
  border: 2px solid #cccccc70;
  font-weight: bold;
  color: #000;
  text-transform: uppercase;
}
</style>

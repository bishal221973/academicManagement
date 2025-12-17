<script setup>
import { ref, computed, watch } from "vue";
import TreeNode from "./TreeNode.vue"; // import the recursive component

const props = defineProps({
  items: Array,
  modelValue: [Number, String, null],
  placeholder: { type: String, default: "Select" },
  disabled: Boolean,
});

const emit = defineEmits(["update:modelValue"]);
const open = ref(false);
const selected = ref(null);

const findNode = (items, id) => items.find(i => i.id === id) || null;

const buildTree = (items, parentId = null) =>
  items
    .filter(i => parentId == null ? !i.parent_id || i.parent_id === 0 : i.parent_id === parentId)
    .map(i => ({ ...i, children: buildTree(items, i.id) }));

const tree = computed(() => buildTree(props.items));

watch(
  () => props.modelValue,
  val => { selected.value = findNode(props.items, val); },
  { immediate: true }
);

const selectItem = item => {
  emit("update:modelValue", item.id);
  selected.value = item;
  open.value = false;
};
</script>

<template>
  <div class="relative w-full">
    <button
      type="button"
      class="w-full px-3 py-[9px] border rounded-lg bg-white flex justify-between items-center"
      :disabled="disabled"
      @click="open = !open"
    >
      <span class="truncate text-sm">
        {{ selected?.name ?? placeholder }}
      </span>
      <span class="text-xs">▾</span>
    </button>

    <div v-if="open" class="absolute z-50 mt-1 w-full bg-white border rounded-lg shadow max-h-64 overflow-auto">
      <TreeNode
        v-for="node in tree"
        :key="node.id"
        :node="node"
        :level="0"
        @select="selectItem"
      />
    </div>
  </div>
</template>

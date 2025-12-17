<script setup>
import { defineProps, defineEmits, ref } from "vue";

// Import FontAwesome

const props = defineProps({
    node: { type: Object, required: true },
    level: { type: Number, default: 0 },
});

const emit = defineEmits(["select"]);

const open = ref(true); // default expanded

const toggle = (e) => {
    e.stopPropagation(); // prevent select
    open.value = !open.value;
};

const selectNode = () => emit("select", props.node);
</script>

<template>
    <div>
        <!-- Node label with icon and toggle -->
        <div class="flex items-center justify-between cursor-pointer hover:bg-gray-100 py-2 px-2 border-b-[1px]"
            :style="{ paddingLeft: `${(level * 20) + 10}px` }" @click="selectNode">
            <div class="flex items-center space-x-1">
                <!-- Node icon -->
                <FontAwesomeIcon :icon="node.children?.length ? (open ? faFolderOpen : faFolder) : faFile" />
                <span class="flex items-center gap-1">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-bar-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M6 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L12.293 7.5H6.5A.5.5 0 0 0 6 8m-2.5 7a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5" />
                    </svg> -->
                    {{ node.name }}</span>
            </div>

            <!-- Expand/Collapse icon on right -->
            <span v-if="node.children?.length" @click="toggle" class="ml-2">
                <i class="fa fa-icon"></i>
            </span>
        </div>

        <!-- Children -->
        <div v-show="open">
            <TreeNode v-for="child in node.children" :key="child.id" :node="child" :level="level + 1"
                @select="$emit('select', $event)" />
        </div>
    </div>
</template>

<style scoped>
/* Optional: subtle hover & rounded effect */
</style>

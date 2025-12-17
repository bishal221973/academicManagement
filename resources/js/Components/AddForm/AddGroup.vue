<!-- <script setup>
import { onMounted, ref } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
const props = defineProps({
    isSelect: {
        type: Boolean,
        default: false,
    },
    group: {
        type: Object,
        default: null,
    },
    groups:Object,
});
const openModal = ref(false);

const toggleModal = () => {
    openModal.value = !openModal.value;
};

const form = useForm({
    name: '',
    code: '',
    description: '',
    parent_id:''
});


const submit = () => {
    if(props.group?.id){
        updateData();
    }else{
        saveData();
    }
}
onMounted(() => {
    if (props.group?.id) {
        toggleModal();
        form.name = props.group.name;
        form.code = props.group.code;
        form.description = props.group.description;
    }
});

const saveData = () => {
    form.post(route('group.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('group.update', props.group), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}
</script>
<template>
    <button @click="toggleModal" class="" v-if="isSelect" type="button">
        <component :is="Plus" />
    </button>
    <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" v-else>Add Group</button>
    
    <Modal :show="openModal" maxWidth="sm" :title="group?.id ? 'Edit Group' : 'Add Group'" @close="toggleModal" :selectedData="group">
    
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label class="text-[14px]">Group Name *</label>
                <input type="text" v-model="form.name"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter course name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
            </div>
            
            <div class="mb-3">
                <label class="text-[14px]">Description</label>
                <textarea type="text" v-model="form.description"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter description"></textarea>
            </div>
            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{group?.id ? 'Update Group' : 'Save Group'}}
                </button>
            </div>
        </form>
    </Modal>
</template> -->

<script setup>
import { onMounted, ref, computed } from "vue";
import Modal from "../Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import TreeDropDown from "../TreeDropDown.vue";
const props = defineProps({
  isSelect: Boolean,
  group: Object,
  groups: Array,
});

const openModal = ref(false);

const toggleModal = () => {
  openModal.value = !openModal.value;
};

const form = useForm({
  name: "",
  description: "",
  parent_id: null,
});

/* ----------------------------
   Build Tree
----------------------------- */
const buildTree = (items, parentId = null) => {
  return items
    .filter(i => i.parent_id === parentId)
    .map(i => ({
      ...i,
      children: buildTree(items, i.id)
    }));
};

/* ----------------------------
   Flatten Tree for Select
----------------------------- */
const flattenTree = (tree, level = 0, arr = []) => {
  tree.forEach(node => {
    arr.push({
      id: node.id,
      label: `${"— ".repeat(level)}${node.name}`,
    });
    if (node.children?.length) {
      flattenTree(node.children, level + 1, arr);
    }
  });
  return arr;
};

const treeGroups = computed(() => buildTree(props.groups));
const parentOptions = computed(() => flattenTree(treeGroups.value));

/* ----------------------------
   Edit Mode
----------------------------- */
onMounted(() => {
  if (props.group?.id) {
    toggleModal();
    form.name = props.group.name;
    form.description = props.group.description;
    form.parent_id = props.group.parent_id;
  }
});

/* ----------------------------
   Submit
----------------------------- */
const submit = () => {
  props.group?.id ? updateData() : saveData();
};

const saveData = () => {
  form.post(route("group.store"), {
    onSuccess: () => {
      form.reset();
      toggleModal();
    },
  });
};

const updateData = () => {
  form.put(route("group.update", props.group.id), {
    onSuccess: () => {
      form.reset();
      toggleModal();
    },
  });
};
</script>
<template>
  <button v-if="isSelect" @click="toggleModal">
    <Plus />
  </button>

  <button
    v-else
    @click="toggleModal"
    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
  >
    Add Group
  </button>

  <Modal
    :show="openModal"
    maxWidth="sm"
    :title="group?.id ? 'Edit Group' : 'Add Group'"
    @close="toggleModal"
  >
    <form @submit.prevent="submit">
        <div class="mb-3">
        <label class="text-sm">Parent Group</label>
        
          <TreeDropDown v-model="form.parent_id" :items="groups"
                                        placeholder="Select parent group" class="mt-2" />
      </div>
      <!-- Group Name -->
      <div class="mb-3">
        <label class="text-sm">Group Name *</label>
        <input
          v-model="form.name"
          class="w-full border rounded px-3 py-2 mt-1"
          placeholder="Enter group name"
        />
        <small class="text-red-600">{{ form.errors.name }}</small>
      </div>

      <!-- Parent Group -->
      

      <!-- Description -->
      <div class="mb-3">
        <label class="text-sm">Description</label>
        <textarea
          v-model="form.description"
          class="w-full border rounded px-3 py-2 mt-1"
        ></textarea>
      </div>

      <!-- Actions -->
      <div class="flex justify-end bg-gray-100 p-3 rounded">
        <button
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          {{ group?.id ? "Update Group" : "Save Group" }}
        </button>
      </div>
    </form>
  </Modal>
</template>

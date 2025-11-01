<script setup>
import { computed, onMounted, ref } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import Datepicker from "../Datepicker.vue";
import SelectComponent from "@/Components/SelectComponent.vue";
import SelectCourse from "../Select/SelectCourse.vue";
import SelectSection from "../Select/SelectSection.vue";
import SelectGroup from "../Select/SelectGroup.vue";
import { Trash, Pen } from "lucide-vue-next";
import Switch from "../Switch.vue";
import Table from "../Table.vue";
const props = defineProps({
    isSelect: {
        type: Boolean,
        default: false,
    },
    student: {
        type: Object,
        default: null,
    },
    title: String,

    sections: Object,
    fields: Object,
});
const openModal = ref(false);
const selectedComponent=ref("section");
const toggleModal = () => {
    openModal.value = !openModal.value;
};

const sectionField = useForm({
    name: '',
});

const isEdit = ref(false);
const editId = ref(null);
const saveSection = () => {
    sectionField.post(route('admission-section.save'), {
        onSuccess: () => {
            sectionField.name = "";
        }
    })
}

const updateSection = () => {
    sectionField.put(route('admission-section.update', editId.value), {
        onSuccess: () => {
            sectionField.name = "";
            isEdit.value = false;
            editId.value = null;
        }
    })
}

const deleteSection = (id) => {
    const confirmed=confirm("Are you sure ?");
    if(confirmed){

        sectionField.delete(route('admission-section.destroy', id))
    }
}

const editSection = (section) => {
    isEdit.value = true;
    sectionField.name = section.name;
    editId.value = section.id;
}

const submitSection = () => {
    if (isEdit.value == true) {
        updateSection();
    } else {
        saveSection();
    }
}

const switchComponent=(type)=>{
    selectedComponent.value=type;
}

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Section.", key: "section" },
    { label: "Field", key: "field" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.students.map((item, index) => ({
        sn: index + 1,
       

        actions: item.id,
    }))
);
</script>
<template>
    <button @click="toggleModal" class="" v-if="isSelect" type="button">
        <component :is="Plus" />
    </button>
    <div v-else>

        <button @click="toggleModal" type="button" class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5"
            v-if="title">{{ title }}</button>
        <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            v-else>Manage Fields</button>
    </div>

    <Modal :show="openModal" maxWidth="lg" :title="'Manage Fields'" @close="toggleModal" :selectedData="student">

        <div class="flex gap-3">
            <button @click="switchComponent('section')" :class="selectedComponent == 'section' ? 'border-b-[1px]' : ''" class=" px-1 py-1">Section</button>
            <button @click="switchComponent('field')" :class="selectedComponent == 'field' ? 'border-b-[1px]' : ''" class=" px-1 py-1">Fields</button>
        </div>

        <div class="sections mt-3" v-if="selectedComponent == 'section'">
            <div v-for="(section, index) in sections" :key="index"
                class="px-3 py-2 rounded bg-gray-100 mb-1 flex justify-between items-center gap-3 w-full">
                <div class="flex justify-between gap-3 ">
                    <div class="bg-white h-[25px] w-[25px] flex justify-center items-center rounded-full text-[12px]">{{
                        index+1 }}</div>
                    {{ section?.name }}
                </div>

                <div class="pt-2">
                    <Switch :route="route('admission-section.status',section.id)" v-model="section.status" :onColor="'#fff'"
                        :offColor="'#ccc'" class="mr-6"/>
                    <button @click="editSection(section)">
                        <component :is="Pen" class="h-[17px] text-blue-400" />
                    </button>
                    <button @click="deleteSection(section.id)">
                        <component :is="Trash" class="h-[17px] text-red-400" />
                    </button>
                </div>
            </div>
            <form @submit.prevent="submitSection">
                <div class="flex gap-3">
                    <input v-model="sectionField.name" placeholder="Section" type="text"
                        class="border-gray-300 rounded w-full">
                    <button class="bg-red-500 px-3 py-1 rounded text-white">
                        {{ isEdit ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
            <!-- {{ sections }} -->
        </div>

        <div class="sections mt-3" v-if="selectedComponent == 'field'">
   
             <table class="w-full">
                <tr>
                    <th>S.N.</th>
                    <th>Section</th>
                    <th>Field</th>
                    <th>Action</th>
                </tr>

                <tr v-for="(item,index) in fields" :key="item.id">
                    <td>{{ index+1 }}</td>
                    <td>{{ item?.section?.name }}</td>
                    <td>{{ item?.name }}</td>
                </tr>
             </table>
            <form @submit.prevent="submitSection">
                <div class="flex gap-3">
                    <select name="" id="" class="border-gray-300 rounded w-full">
                        <option v-for="item in sections" :key="item.id">
                            {{ item?.name }}
                        </option>
                    </select>
                    <input v-model="sectionField.name" placeholder="Field" type="text"
                        class="border-gray-300 rounded w-full">
                    <button class="bg-red-500 px-3 py-1 rounded text-white">
                        {{ isEdit ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
            <!-- {{ sections }} -->
        </div>
    </Modal>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { ref, onMounted, reactive, nextTick } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import axios from "axios";
import Sortable from "sortablejs";
import { Mail, Phone } from "lucide-vue-next";
import ManageField from "@/Components/AddForm/ManageField.vue";
const props = defineProps({
    admissionFields: Object,
    student: Object,

    sections:Object,
    fields1:Object,
});

const fields = reactive(JSON.parse(JSON.stringify(props.admissionFields)));

onMounted(() => {
    nextTick(() => {
        Object.keys(fields).forEach((key) => {
            const el = document.getElementById(`field-group-${key}`);
            if (el) {
                Sortable.create(el, {
                    animation: 150,
                    handle: ".dragable-border", // use the element itself to drag
                    ghostClass: "drag-ghost",
                    onEnd: (evt) => {
                        // Update the array order after drop
                        const movedItem = fields[key].splice(evt.oldIndex, 1)[0];
                        fields[key].splice(evt.newIndex, 0, movedItem);

                        // Optional: send update to backend
                        saveNewOrder(key);
                    },
                });
            }
        });
    });
});

const saveNewOrder = async (groupKey) => {
    const ids = fields[groupKey].map((f) => f.id);
    try {
        await axios.post(route("admission-form.reorder"), { group: groupKey, ids });
        console.log("Order saved:", ids);
    } catch (e) {
        console.error("Failed to save order:", e);
    }
};

const resize = async (id) => {
    try {
        const response = await axios.get(route("admission-form.resize", id));
        const updatedField = response.data.data;
        for (const section of Object.values(fields)) {
            const field = section.find((f) => f.id === updatedField.id);
            if (field) {
                field.size = updatedField.size;
                break;
            }
        }
    } catch (error) {
        console.error("Resize failed:", error);
    }
};
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Student />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Student Management' }, { label: 'Admission Form' }]" />
           
                <!-- <ManageField :fields="fields1" :sections="sections"/> -->
            </div>

            <div class="flex w-full gap-3">
                <div class="w-full">
                    <div
                        class="w-full print:shadow-none shadow-md rounded-xl bg-white p-3 min-h-[calc(100vh-125px)] relative">
                        <!-- Academy info -->
                        <div
                            class="border-[1px] w-[100px] h-[100px] flex justify-center items-center absolute right-0 top-[50px]">
                            photo
                        </div>
                        <img :src="$page?.props?.academy?.logo" class="absolute opacity-5" alt="" />
                        <label class="block text-center text-[25px] font-bold uppercase">
                            {{ $page?.props?.academy?.name }}
                        </label>
                        <label class="block text-center text-[18px]">
                            {{ $page?.props?.academy?.address }}
                        </label>
                        <div class="flex justify-center items-center gap-3">
                            <Mail class="h-[16px] opacity-40" />
                            <label>{{ $page?.props?.academy?.academy_email }}</label>
                        </div>
                        <div class="flex justify-center items-center gap-3">
                            <Phone class="h-[16px] opacity-40" />
                            <label>{{ $page?.props?.academy?.phone }}</label>
                        </div>

                        <!-- Fields -->
                        <div v-for="(admissionField, index) in fields" :key="index"
                            class="grid grid-cols-12 gap-2 mb-3">
                            <div class="col-span-12">
                                <div class="border-b-[1px] px-3 mb-1">
                                    <span class="text-[13px] font-bold">{{ index }}</span>
                                </div>
                            </div>

                            <!-- Make sortable -->
                            <div class="grid grid-cols-12 gap-2 col-span-12" :id="`field-group-${index}`">
                                <div v-for="item in admissionField" :key="item.id"
                                    :class="[item.size, 'dragable-border', 'relative', 'px-2']"
                                    @contextmenu.prevent="resize(item.id)">
                                    <span class="text-[14px]">{{ item.name }}</span>
                                    <input type="text"
                                        class="w-full border-gray-300 rounded-md bg-white pointer-events-none"
                                        :value="item.value" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<style scoped>
.dragable-border {
    border: 1px solid transparent;
    transition: border 0.2s;
    position: relative;
    cursor: move;
}

.dragable-border:hover {
    border: 1px solid rgba(0, 0, 255, 0.4);
    border-radius: 5px;
}

.drag-ghost {
    opacity: 0.6;
    background-color: rgba(0, 0, 255, 0.1);
}
input{
    background-color: transparent !important;
}
</style>

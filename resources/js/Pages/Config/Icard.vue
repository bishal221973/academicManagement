<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { ArrowRight } from "lucide-vue-next";
import Configuration from "@/Components/Menus/Configuration.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { onMounted, ref } from "vue";
import SelectComponent from "@/Components/SelectComponent.vue";
import Theme1 from "@/Components/Icard/Theme1.vue";
import Theme2 from "@/Components/Icard/Theme2.vue";
// Extracting settings from props
const props = defineProps({
    icards: Object,
});


const themeMap = {
    Theme1: Theme1,
    Theme2: Theme2,
};

// Optional form setup if you plan to update configuration
const form = useForm({
    selected_theme: null,
});

const selectTheme=(themeId)=>{
    form.selected_theme=themeId;

    form.put(route('icard.update',themeId),{
        
    })
}
const student=ref({
    'name':'Bishal Chaudhary',
    'registration_number':'0123456789',
    'roll_number':'05',
    'course':{
        'name':'BCA'
    }
})
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Configuration />
        </template>

        <template #content>
             <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Configuration' }, { label: 'ID Card Setup' }]" />
                <AddCourse :course="course" />
            </div>
                <div class="flex gap-3 mt-1">
                    <div v-for="item in icards" :key="item.id" class="mt-3 w-[200px] h-[320px]">
                        
                        <component :student="student" :is="themeMap[item.name]" :data="item" @click="selectTheme(item.id)" :class="item.is_active ? 'border-[1px] border-red-500' : ''"/>
                        <!-- <item?.name/> -->
                    </div>
                </div>
        </template>
    </AppLayout>
</template>

<script setup>
import { computed } from 'vue';
import Table from '../Table.vue';
import TableMultiLevel from '../TableMultiLevel.vue';
import ImageUploader from '../ImageUploader.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({
    student: Object,
});

const form = useForm({
    front: props?.student?.nationality_card_front ? '/storage/' + props?.student?.nationality_card_front : "",
    back: props?.student?.nationality_card_back ? '/storage/' + props?.student?.nationality_card_back : "",
});

const upload = () => {
    form.post(route('student.upload.citizenship', props.student?.id));
}
</script>
<template>
    <small>Citizenship Card</small>
    <form @submit.prevent="upload">
        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-6">
                <small><b>Front</b></small>
                <ImageUploader :title="'Citizenship Card Front'" v-model="form.front" />
            </div>
            <div class="col-span-6">
                <small><b>Back</b></small>
                <ImageUploader :title="'Citizenship Card Front'" v-model="form.back" />
            </div>
            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    Upload
                </button>
            </div>
        </div>
    </form>

    <!-- <hr class="my-3">
    <small>Other Documents</small> -->
</template>
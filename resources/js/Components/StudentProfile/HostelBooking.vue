<script setup>
import { ref } from 'vue';
import Modal from '../Modal.vue';
import SelectHostel from '../Select/SelectHostel.vue';
import { useForm } from '@inertiajs/vue3';
import SelectHostelRoom from '../Select/SelectHostelRoom.vue';
import Datepicker from '../Datepicker.vue';
const props = defineProps({
    student: Object,
})

const today = new Date();
const runningHostelStays = props?.student?.hostels.find((stay) => {
    const checkOut = new Date(stay.check_out_date);
    return checkOut >= today;
});

const isModelOpen = ref(false);

const toggleModal = () => {
    isModelOpen.value = !isModelOpen.value;
}

const form = useForm({
    hostel_id: "",
    student_id: props?.student?.id ?? "",
    room_id: "",
    price: "0",
    check_in_date: "",
    bed_no: "",
    stay_month: "1",

})
</script>
<template>
    <div class="flex justify-end" v-if="student?.hostels?.length <= 0">
        <button @click="toggleModal"
            class="bg-blue-600 text-white px-4 py-[5px] rounded hover:bg-blue-700">Booking</button>
    </div>
    <div class="flex justify-end" v-else-if="!runningHostelStays">
        <button @click="toggleModal"
            class="bg-blue-600 text-white px-4 py-[5px] rounded hover:bg-blue-700">Renew</button>
    </div>

    <Modal :show="isModelOpen" @close="toggleModal" maxWidth="sm" :title="'Booking'">
        <form @submit.prevent="submit">
            <div class="rounded-lg shadow p-3 bg-white">
                <div class="mb-1">
                    <label class="text-[14px]">Hostel*</label>
                    <SelectHostel v-model="form.hostel_id" />
                    <small class="text-red-600">{{ form.errors.hostel_id }}</small>
                </div>
                <div class="mb-1">
                    <label class="text-[14px]">Room*</label>
                    <SelectHostelRoom :hostelId="form.hostel_id" v-model="form.room_id" />
                </div>
                <div class="mb-1">
                    <label class="text-[14px]">Price *</label>
                    <input type="text" v-model="form.price"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter price" />
                    <small class="text-red-600">{{ form.errors.price }}</small>
                </div>
                <div class="mb-1">
                    <label class="text-[14px]">Checkin Date *</label>
                    <Datepicker v-model="form.check_in_date" />
                    <small class="text-red-600">{{ form.errors.check_in_date }}</small>
                </div>
                <div class="mb-1">
                    <label class="text-[14px]">Stay Month *</label>
                    <input type="number" step="1" :min="1" v-model="form.stay_month"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter price" />
                    <small class="text-red-600">{{ form.errors.stay_month }}</small>
                </div>

                <div class=" flex justify-end">
                    <button class="bg-blue-600 w-full text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                        {{ hostelStudent?.id ? 'Update Student' : 'Save Student' }}
                    </button>
                </div>
            </div>
        </form>
    </Modal>


</template>
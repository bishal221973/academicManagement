<script setup>
import { ref } from 'vue';
import Modal from './Modal.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    data: Object,
    student: Object,
    features: Object,
});

const isRoomBook = ref(false);

const openBookRoom = () => {
    isRoomBook.value = true;
};

const closeBookRoom = () => {
    isRoomBook.value = false;
};

const submit = () => {
    // booking logic here
    closeBookRoom();
};

const form = useForm({
    contact: props?.student?.phone ?? "",
    course_id: props?.student?.course_id ?? "",
    student_id: props?.student?.id ?? "",
    roll_no: props?.student?.roll_number ?? "",
    reg_no: props?.student?.registration_number ?? "",
    hostel_id: props?.data?.hostel_id ?? "",
    room_id: props?.data?.room_id ?? "",
    price: props?.data?.price ?? "0",
    check_in_date: "",
    stay_month: "1",
    taxes: [],
    features: [],
    is_percentage: false,
    discount: 0,
    net_total: props?.room?.price ?? "0",
    total_amount: props?.room?.price ?? "0"
});
const isSelected = (tax) => {
    return form.taxes.some(t => t.tax_id === tax.id)
}
const toggleFeature = (feature) => {
    const index = form.features.findIndex(t => t.feature_id === feature.id)
    if (index === -1) {
        form.features.push({ feature_id: feature.id, name: feature.title, price: feature.price })
    } else {
        form.features.splice(index, 1)
    }
    computeSubTotal()
}
</script>

<template>
    <!-- Open modal -->
    <button v-if="data?.boolean === false" @click="openBookRoom"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Renew
    </button>

    <!-- Modal -->
    <Modal title="Renew Room" maxWidth="2xl" :show="isRoomBook" @close="closeBookRoom">
        <!-- {{ form }} -->
        <!-- {{ data }} -->
        <!-- {{ student }} -->
        <form @submit.prevent="submit">
            <!-- form fields here -->
            <span class="font-bold uppercase text-[17px]">{{ data?.hostel }}</span>
            <div class="flex">
                <span class="block text-[14px]"><span>Room : </span>{{ data?.roomNo }}</span>
                <button class="px-3 text-blue-500 rounded text-[12px]">Change Room</button>
            </div>
            <span class="block text-[14px]"><span>Checkin : </span>{{ data?.checkin }}</span>
            <span class="block text-[14px]"><span>Checkout : </span>{{ data?.checkout }}</span>

            <hr class="mt-3">
            <div class="flex gap-3">
                <div class="w-full">
                    <label class="text-[14px]">Stay Month *</label>
                    <input type="number" step="1" :min="1" v-model="form.stay_month"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Stay Month" />
                </div>
                <div class="w-full">
                    <label class="text-[14px]">Renew Date *</label>
                    <input type="date" v-model="form.check_in_date"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Stay Month" />
                </div>
            </div>

            <div class="col-span-12">
                <span>Services</span>
            </div>
            <div class="col-span-4 -mt-3" v-for="(item, index) in features" :key="index">
                <div class="flex justify-between">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" class="rounded-xl" :checked="isSelected(item)"
                            @change="toggleFeature(item)" name="" id=""></input>
                        {{ item?.title }} <small>(Rs. {{ item?.price }})</small>
                    </div>

                </div>
            </div>
            <div class="flex justify-end bg-gray-100 rounded p-3 mt-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Renew Now
                </button>
            </div>
        </form>
    </Modal>
</template>

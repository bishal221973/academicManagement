<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Hostel from "@/Components/Menus/Hostel.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import AddRoom from "@/Components/AddForm/AddRoom.vue";
import { ref, onMounted, computed, watch } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import SelectCourse from "@/Components/Select/SelectCourse.vue";
import SelectStudent1 from "@/Components/Select/SelectStudent1.vue";
import Datepicker from "@/Components/Datepicker.vue";
const props = defineProps({
    hostel: Object,
    room: Object,
    hostelStudents:Object,
    studentsInRoom:Object,
});

const courseList = ref(props?.hostel?.rooms);

const fetchSection = async (hostelId = null) => {
    const response = await axios.get(route("room.all"), {
        params: { hostel_id: hostelId || "" },
    });
    courseList.value = response.data.rooms;
};

onMounted(() => {
    fetchSection();

    Pusher.logToConsole = true;

    const pusher = new Pusher("09a7a9ef059d4f63aa24", {
        cluster: "ap2",
    });

    const channel = pusher.subscribe("my-channel");
    channel.bind("hostel-room-event", () => {
        fetchSection();
    });
});

const roomId = ref(null);
onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    roomId.value = params.get("room_id");
});

const isRoomBook = ref(false);
const bookingRoomNo = ref(null);
const openBookRoom = (num=null) => {
    isRoomBook.value = !isRoomBook.value;
    bookingRoomNo.value = num;
    form.bed_no = "Bed No. " + num;
}

const form = useForm({
    hostel_id: props?.hostel?.id ?? "",
    course_id: "",
    student_id: "",
    room_id: props?.room?.id ?? "",
    price: props?.room?.price ?? "0",
    check_in_date: "",
    bed_no: "",
     stay_month: "1",
})

const submit=()=>{
    saveData();
}

const saveData = async () => {
    form.post(route('hostelStudent.store'), {
        onSuccess: () => {
            form.reset();
            openBookRoom();
        }
    });
}

const bookedBeds = computed(() => {
    if (!props.room || !props.hostelStudents) return [];
    // Filter hostelStudents for the current room
    return props.hostelStudents
        .filter(student => student.room_id === props.room.id)
        .map(student => {
            // Assuming bed_no is stored as "Bed No. 1"
            return Number(student.bed_no.replace('Bed No. ', ''));
        });
});

watch(()=>form.stay_month,(newVal)=>{
    if(newVal >= 1){
        form.price = props?.room?.price*newVal;
    }
})
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Hostel />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[
                    { label: 'Hostel Management' },
                    { label: 'Hostel' },
                    { label: 'Show' },
                ]" />
            </div>

            <div class="flex w-full gap-3">
                <div class="w-full">
                    <!-- Hostel Info -->
                    <div class="rounded-lg shadow p-3 bg-white">
                        <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                            <span class="font-semibold text-gray-800">{{ hostel?.name }}</span>
                            <span>|</span>
                            <span>{{ hostel?.address }}</span>
                            <span>|</span>
                            <span>{{ hostel?.rooms?.length }} Rooms</span>
                            <span>|</span>
                            <span>{{ studentsInRoom?.length }} Students</span>
                        </div>
                    </div>

                    <!-- Room List -->
                    <div class="flex mt-2 gap-3">
                        <div class="rounded-lg shadow bg-white left-box">
                            <div class="p-3">
                                <small class="block text-center font-semibold text-gray-700">Rooms</small>
                                <hr class="my-2 border-gray-200" />

                                <div class="space-y-1">
                                    <Link v-for="room in hostel?.rooms" :key="room.id"
                                        :href="route('hostel.show', hostel.id) + '?room_id=' + (room?.id ?? '')"
                                        :class="roomId == room.id ? 'bg-red-500 text-white' : ''"
                                        class="block w-full text-[12px] px-3 py-2 rounded border border-gray-300 hover:border-gray-500 text-left transition-all"
                                        @click="switchRoom(room.id)">
                                    {{ room?.name }}
                                    </Link>

                                    <!-- Add new room button with dashed border -->

                                    <!-- or your component -->
                                    <AddRoom :type="'type1'" :hostelId="hostel?.id" />
                                </div>
                            </div>
                        </div>
                        <div class="w-full bg-white rounded-md p-3">
                            <div class="flex gap-3">
                                <small>
                                    <span class="font-bold">Name : </span>
                                    <span class="text-gray-500">
                                        {{ room?.name }}
                                    </span>
                                </small>
                                <span class="relative -mt-[3px]">|</span>
                                <small>
                                    <span class="font-bold">No. of Bed : </span>
                                    <span class="text-gray-500">
                                        {{ room?.no_of_bed }}
                                    </span>
                                </small>
                                <span class="relative -mt-[3px]">|</span>
                                <small>
                                    <span class="font-bold">No. of Students : </span>
                                    <span class="text-gray-500">
                                        {{ studentsInRoom?.length }}
                                    </span>
                                </small>
                                <span class="relative -mt-[3px]">|</span>
                                <small>
                                    <span class="font-bold">No. of Free Bed : </span>
                                    <span class="text-gray-500">
                                        {{ room?.no_of_bed - studentsInRoom?.length }}
                                    </span>
                                </small>
                                <span class="relative -mt-[3px]">|</span>
                                <small>
                                    <span class="font-bold">Price : </span>
                                    <span class="text-gray-500">
                                        Rs. {{ room?.price }}
                                    </span>
                                </small>
                            </div>

                            <hr class="my-3">

                            <div class="grid grid-cols-12 gap-3">
                                <div v-for="n in Number(room?.no_of_bed || 0)" :key="n" class="col-span-2">
                                    <div class="w-full">
                                        <div class="flex justify-center">
                                            <img class="w-[40px]" :src="'/bed.png'" alt=""></img>
                                        </div>
                                        <small class="block text-center">Bed No. {{ n }}</small>
                                        
                                        <div class="flex justify-center" v-if="bookedBeds.includes(n)" >
                                              <small class="block text-center bg-red-200 rounded-lg text-[9px] text-red-500 w-[50px]">Booked</small>
                                          </div>
                                        <div class="flex justify-center" v-else>
                                            <button @click="openBookRoom(n)"
                                                class="block text-center bg-green-100 rounded-lg text-[9px] text-green-500 w-[50px]">Book
                                                now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>

    <Modal :title="'Book Room'" maxWidth="sm" @close="openBookRoom" :show="isRoomBook">
        <form @submit.prevent="submit">
            <div class="mb-1">
            <label class="text-[14px]">Course*</label>
            <SelectCourse v-model="form.course_id" />
        </div>
        <div class="mb-1">
            <label class="text-[14px]">Student*</label>
            <SelectStudent1 v-model="form.student_id" :courseId="form.course_id" />
        </div>
        <div class="mb-1">
            <label class="text-[14px]">Checkin Date *</label>
            <Datepicker v-model="form.check_in_date" />
            <small class="text-red-600">{{ form.errors.check_in_date }}</small>
        </div>
        <div class="mb-1">
            <label class="text-[14px]">Price *</label>
            <input type="text" v-model="form.price"
                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter price" />
            <small class="text-red-600">{{ form.errors.price }}</small>
        </div>
        <div class="mb-1">
            <label class="text-[14px]">Bed *</label>
            <input type="text" v-model="form.bed_no"
                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter price" />
            <small class="text-red-600">{{ form.errors.bed_no }}</small>
        </div>
        <div class="mb-1">
            <label class="text-[14px]">Stay Month *</label>
            <input type="number" step="1" :min="1" v-model="form.stay_month"
                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter price" />
            <small class="text-red-600">{{ form.errors.stay_month }}</small>
        </div>
        <div class=" flex justify-end">
            <button class="bg-blue-600  text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                {{ 'Book Now' }}
            </button>
        </div>
        </form>
    </Modal>
</template>

<style scoped>
.left-box {
    width: 160px;
}
</style>

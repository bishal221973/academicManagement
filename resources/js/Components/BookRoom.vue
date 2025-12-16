<script setup>
import { ref, onMounted, computed, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import SelectCourse from "@/Components/Select/SelectCourse.vue";
import SelectStudent1 from "@/Components/Select/SelectStudent1.vue";
import Datepicker from "@/Components/Datepicker.vue";
import Toggle from "@/Components/Toggle.vue";
const props = defineProps({
    hostel: Object,
    room: Object,
    hostelStudents: Object,
    studentsInRoom: Object,
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
const openBookRoom = (num = null) => {
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
    taxes: [],
    is_percentage: false,
    discount: 0,
    net_total: props?.room?.price ?? "0",
    total_amount: props?.room?.price ?? "0"
});
const discountAmount = ref(0)
const subTotal = ref(0);
const netTotalAmount = ref(0);
watch((form.price), () => {
    subTotal.value = form.price;
    netTotalAmount.value = form.price;
})
const computeDiscount = () => {
    if (form.is_percentage) {
        if (form.price > 0) {
            const discount = form.price * form.discount / 100;
            discountAmount.value = discount.toFixed(2);
        } else {
            discountAmount.value = '0.0';
        }
    } else {
        discountAmount.value = Number(form.discount).toFixed(2);
    }
    computeNetTotal(form.price, discountAmount.value)
}
watch(
    [() => form.is_percentage, () => form.discount],
    () => {
        // alert('hello')
        computeDiscount()
    }
)
const computeNetTotal = (netAmount, discount) => {
    const netAmt = Number(netAmount) - Number(discount);
    netTotalAmount.value = Number(netAmt).toFixed(2);
    form.net_total = netAmt;
    computeTotalAmount(netAmt)
}
const totalAmountVal = ref(0);
const computeTotalAmount = (amt) => {
    let totalAmt = 0;

    for (const tax of form.taxes) {
        const taxAmount = Number(amt) * (tax.percentage / 100);
        totalAmt += taxAmount;
    }
    // alert(totalAmt)
    const total = Number(amt) + Number(totalAmt);
    totalAmountVal.value = total;
    form.total_amount = total;
}

const submit = () => {
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

watch(() => form.stay_month, (newVal) => {
    if (newVal >= 1) {
        form.price = props?.room?.price * newVal;
    }
})

onMounted(() => {
    fetchTaxes();

});
const taxes = ref([]);
const fetchTaxes = async () => {
    const response = await axios.get(route('tax.all'));
    taxes.value = response.data.taxes;

}
const isSelected = (tax) => {
    return form.taxes.some(t => t.tax_id === tax.id)
}
const toggleTax = (tax) => {
    const index = form.taxes.findIndex(t => t.tax_id === tax.id)
    if (index === -1) {
        // Add tax
        form.taxes.push({ tax_id: tax.id, name: tax.name, percentage: tax.percentage })
    } else {
        // Remove tax
        form.taxes.splice(index, 1)
    }
    // alert(form.net_total)
    computeTotalAmount(form.net_total)
}

const computePercentageAmount = (netAmt, percent) => {
    const percentage = netAmt * percent / 100;
    return percentage;
}
</script>
<template>
    <button @click="openBookRoom(n)"
        class="block text-center bg-green-100 rounded-lg text-[9px] text-green-500 w-[50px]">Book
        now</button>

    <Modal :title="'Book Room'" maxWidth="xl" @close="openBookRoom" :show="isRoomBook">
        <form @submit.prevent="submit">
            <div class="flex gap-3">
                <div class="w-full">
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
                </div>
                <div class="w-[500px]">
                    <div class="bg-gray-100 p-3 rounded">
                        <div class="flex justify-between">
                            <small class="font-bold">Sub Total : </small>
                            <small>Rs. {{ form.price }}</small>

                        </div>
                        <hr class="my-2">
                        <div class="block mt-3">
                            <div class="flex items-center justify-between gap-3">
                                <label for="">Discount</label>
                                <div class="flex items-center">
                                    <small class="block mr-1">रु</small>
                                    <Toggle v-model="form.is_percentage" :onColor="'#fff'" :offColor="'#ccc'"
                                        class="relative top-[2px]" />
                                    <small class="block pl-3" style="padding-left: 25px;">%</small>
                                </div>
                            </div>
                            <input type="text" v-model="form.discount"
                                :class="student?.id ? 'pointer-events-none bg-gray-100' : ''"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Discounts" />
                            <!-- {{ form.discount }} -->
                        </div>
                        <hr class="my-2" v-if="form.is_percentage">
                        <div class="flex justify-between" v-if="form.is_percentage">
                            <small class="font-bold">Discount Amount : </small>
                            <small>Rs. {{ discountAmount }}</small>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between">
                            <small class="font-bold">Net Total : </small>
                            <small>Rs. {{ form.net_total }}</small>
                        </div>
                        <hr class="my-2">

                        <div class="flex justify-between mb-1" v-for="(item, key) in taxes">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" :checked="isSelected(item)" @change="toggleTax(item)" name=""
                                    id=""></input>
                                {{ item?.name }}
                            </div>
                            <div>
                                {{ item?.percentage }}%
                            </div>
                        </div>
                        <hr class="my-2">
                        <div><small><b>Taxes</b></small></div>
                        <!-- {{ form.taxes }} -->
                        <div class="flex justify-between" v-for="(item, index) in form.taxes" :key="index">
                            <small>
                                {{ item?.name }} ({{ item?.percentage }}%)
                            </small>
                            <small>
                                Rs. {{ computePercentageAmount(form.net_total, item.percentage) }}
                            </small>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between">
                            <small class="font-bold">Grand Total : </small>
                            <small>Rs. {{ totalAmountVal }}</small>
                        </div>
                    </div>

                </div>
            </div>

        </form>
    </Modal>
</template>
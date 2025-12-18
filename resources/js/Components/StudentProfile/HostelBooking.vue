<script setup>
import { ref, onMounted, computed, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import SelectCourse from "@/Components/Select/SelectCourse.vue";
import SelectStudent1 from "@/Components/Select/SelectStudent1.vue";
import Datepicker from "@/Components/Datepicker.vue";
import Toggle from "@/Components/Toggle.vue";
import SelectHostel from "../Select/SelectHostel.vue";
import SelectHostelRoom from "../Select/SelectHostelRoom.vue";
import axios from "axios";
import { CloudCog } from "lucide-vue-next";
const props = defineProps({
    hostel: Object,
    room: Object,
    hostelStudents: Object,
    studentsInRoom: Object,
    features: Object,
    student: Object,
    myFeatures:Object,
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
    contact: "",
    course_id: "",
    student_id: "",
    student_name: "",
    roll_no: "",
    reg_no: "",
    hostel_id: "",
    room_id: 3,
    price: props?.room?.price ?? "0",
    check_in_date: "",
    stay_month: "1",
    taxes: [],
    features: [],
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

const lastRoom=ref(null);
onMounted(() => {


    if (props.myFeatures) {
        // alert("hello")
        form.features = props.myFeatures?.features?.map(f => ({
            feature_id: f.hostel_feature_id,
            name: f.feature?.title,
            price: f.feature?.price
        }));
        computeSubTotal(); // update totals after setting features
    }
    
    if (props?.student?.id) {
        openBookRoom();
        // alert('Hello')
        // openBookRoom();
        form.contact = props.student?.phone;
        // console.log("----------------");
        // console.log(props.student.hostels[props.student.hostels.length-1]);
        // form.room_id=props.student.hostels[props.student.hostels.length-1]?.room_id ?? 1;
        // form.hostel_id=props.student.hostels[props.student.hostels.length-1]?.hostel_id;

        const lastHostel = Array.isArray(props.student.hostels)
            ? props.student.hostels.at(-1)
            : null;

        if (lastHostel?.room_id) {
            form.room_id = Number(lastHostel.room_id);
            form.hostel_id = Number(lastHostel.hostel_id);
            lastRoom.value=Number(lastHostel?.room_id)
        }
    }
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

const orgPrice = ref(0);
const totalServicePrice = ref(0);
watch(() => form.stay_month, (newVal) => {
    if (newVal >= 1) {
        form.price = orgPrice.value * newVal;
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
const isSelected = (item) => {
    return form.features?.some(f => f.feature_id === item.id)
}

const toggleTax = (tax) => {
    const index = form.taxes.findIndex(t => t.tax_id === tax.id)
    if (index === -1) {
        form.taxes.push({ tax_id: tax.id, name: tax.name, percentage: tax.percentage })
    } else {
        form.taxes.splice(index, 1)
    }
    computeTotalAmount(form.net_total)
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

const computePercentageAmount = (netAmt, percent) => {
    const percentage = netAmt * percent / 100;
    return percentage;
}

const computeSubTotal = () => {
    const price = orgPrice.value;
    const stay_month = form.stay_month;
    const service_amount = form.features?.reduce(
        (sum, f) => sum + (Number(f.price) || 0),
        0
    );
    const totalPrice = (price * stay_month) + service_amount;
    form.price = totalPrice;
    computeNetTotal(form.price, discountAmount.value)
}

watch(() => form.contact, () => {
    fetchStudent()
})

watch(() => form.room_id, () => {
    fetchRoom()

})

const fetchStudent = async () => {
    const response = await axios.get(route('student.find') + '?contact=' + form.contact);

    form.course_id = response.data?.course_id;
    form.student_id = response.data?.id;
    form.student_name=response.data?.name;
    form.roll_no = response.data?.roll_number;
    form.reg_no = response.data?.registration_number;
}

const fetchRoom = async () => {

    const response = await axios.get(route('room.find') + '?id=' + form.room_id);

    form.price = response.data?.price;
    orgPrice.value = response.data.price;
    computeSubTotal();

}

watch(() => form.stay_month, () => {
    computeSubTotal();
})


</script>
<template>
    <!-- {{ student }} -->
    <button @click="openBookRoom(n)" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Book
        now</button>

    <Modal :title="student?.id ? 'Renew Now' : 'Book Room'" maxWidth="4xl" @close="openBookRoom" :show="isRoomBook">
        <form @submit.prevent="submit">
            <div class="flex gap-3">
                <div class="w-full">

                    <div class="grid grid-cols-12 gap-3">
                        <!-- <div class="col-span-5">
                            <label class="text-[14px]">Course*</label>
                            <SelectCourse v-model="form.course_id" />
                        </div> -->
                        <div class="col-span-5">
                            <label class="text-[14px]">Mobile / Email *</label>
                            <input type="text" v-model="form.contact"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter mobile number or emial address" />
                            <small class="text-red-600">{{ form.errors.bed_no }}</small>
                        </div>

                        <div class="col-span-5">
                            <!-- <div class="mb-1"> -->
                                {{ form.student_name }}
                            <label class="text-[14px]">Student*</label>
                            <SelectStudent1 v-model="form.student_id" :courseId="form.course_id" />
                            <!-- </div> -->
                        </div>
                        <div class="col-span-2 row-span-2 ">
                            <div class="border-[1px] h-full rounded-md p-3 flex justify-center items-center">
                                <img :src="'/student.png'" class="h-full" alt="">
                            </div>
                        </div>
                        <div class="col-span-5">
                            <!-- <div class="mb-1"> -->
                            <label class="text-[14px]">Roll No. *</label>
                            <input type="number" step="1" :min="1" v-model="form.roll_no"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter price" />
                            <small class="text-red-600">{{ form.errors.roll_no }}</small>
                            <!-- </div> -->
                        </div>
                        <div class="col-span-5">
                            <!-- <div class="mb-1"> -->
                            <label class="text-[14px]">Reg. No *</label>
                            <input type="text" step="1" :min="1" v-model="form.reg_no"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter price" />
                            <small class="text-red-600">{{ form.errors.reg_no }}</small>
                            <!-- </div> -->
                        </div>
                        <div class="col-span-12">
                            <hr>
                            </hr>
                        </div>
                        <div class="col-span-12">
                            <!-- <div class="mb-1"> -->
                            <label class="text-[14px]">Hostel*</label>
                            <SelectHostel v-model="form.hostel_id" />
                            <!-- </div> -->
                        </div>
                        <!-- {{ hostel_id }} -->
                        <div class="col-span-4">
                            <!-- <div class="mb-1"> -->
                            <!-- {{ lastRoom }} -->
                            <label class="text-[14px]">Room*</label>
                            <SelectHostelRoom :lastRoom="lastRoom" v-model="form.room_id" :hostelId="form.hostel_id" />
                            <!-- </div> -->
                        </div>
                        <div class="col-span-4">
                            <!-- <div class="mb-1"> -->
                            <label class="text-[14px]">{{ student?.id ? 'Renew' : 'Checkin' }} Date *</label>
                            <Datepicker v-model="form.check_in_date" class="-mt-1" />
                            <small class="text-red-600">{{ form.errors.check_in_date }}</small>
                            <!-- </div> -->
                        </div>
                        <div class="col-span-4">
                            <!-- <div class="mb-1"> -->
                            <label class="text-[14px]">Stay Month *</label>
                            <input type="number" step="1" :min="1" v-model="form.stay_month"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter price" />
                            <small class="text-red-600">{{ form.errors.stay_month }}</small>
                            <!-- </div> -->
                        </div>

                        <div class="col-span-12">
                            <hr>
                            <!-- {{ features }} -->
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


                    </div>


                    <!-- <div class="mb-1">
                        <label class="text-[14px]">Bed *</label>
                        <input type="text" v-model="form.bed_no"
                            class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter price" />
                        <small class="text-red-600">{{ form.errors.bed_no }}</small>
                    </div> -->

                    <!-- <div class=" flex justify-end">
                        <button class="bg-blue-600  text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                            {{ 'Book Now' }}
                        </button>
                    </div> -->
                </div>
                <div class="w-[400px]">
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
            <!-- {{ myFeatures.features }} -->
              <!-- {{ form }} -->
            <div class=" flex justify-end bg-gray-100 rounded p-3 mt-3">
                <button class="bg-blue-600  text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{ student?.id ? 'Renew Now' : 'Book Now' }}
                </button>
            </div>

        </form>
    </Modal>
</template>
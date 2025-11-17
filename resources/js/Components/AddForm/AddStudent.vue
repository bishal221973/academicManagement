<script setup>
import { onMounted, ref, watch } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import Datepicker from "../Datepicker.vue";
import SelectComponent from "@/Components/SelectComponent.vue";
import SelectCourse from "../Select/SelectCourse.vue";
import SelectSection from "../Select/SelectSection.vue";
import SelectGroup from "../Select/SelectGroup.vue";
import ImageUploader from "../ImageUploader.vue";
import ImageUploader1 from "../ImageUploader1.vue";
import Switch from "../Switch.vue";
import Toggle from "../Toggle.vue";
import axios from "axios";
import MultiMonthSelect from "../MultiMonthSelect.vue";
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
    bill:Object,
});
const openModal = ref(false);

const toggleModal = () => {
    openModal.value = !openModal.value;
};

const form = useForm({
    roll_number: '',
    name: '',
    registration_number: '',
    registration_date: '',
    birth_date: '',
    gender: '',
    religion: '',
    cast: '',
    phone: '',
    email: '',
    national_id: '',
    course_id: '',
    section_id: '',
    group_id: '',
    father_name: '',
    father_phone: '',
    father_education: '',
    father_profession: '',
    mother_name: '',
    mother_phone: '',
    mother_education: '',
    mother_profession: '',
    present_address: '',
    permanent_address: '',
    prev_school: '',
    prev_class: '',
    transfer_certificate: '',


    admition_fees: '',
    months:[],
    tution_fees: '',
    discount:0,
    is_percentage: false,
    sub_total:0,
    net_total:0,
    total_amount:0,
    taxes: [],
});

const addTax = () => {
  form.taxes.push({ tax_id: null, percentage: 0 })
}

const removeTax = (index) => {
  form.taxes.splice(index, 1)
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
  computeTotalAmount(netTotalAmount.value)
}
const submit = () => {
    if (props.student?.id) {
        updateData();
    } else {
        saveData();
    }
}
onMounted(() => {
    if (props.student?.id) {
        toggleModal();

        form.roll_number = props.student.roll_number;
        form.name = props.student.name;
        form.registration_number = props.student.registration_number;
        form.registration_date = props.student.registration_date;
        form.birth_date = props.student.birth_date;
        form.gender = props.student.gender;
        form.religion = props.student.religion;
        form.cast = props.student.cast;
        form.phone = props.student.phone;
        form.email = props.student.email;
        form.national_id = props.student.national_id;
        form.course_id = props.student.course_id;
        form.section_id = props.student.section_id;
        form.group_id = props.student.group_id;
        form.father_name = props.student.father_name;
        form.father_phone = props.student.father_phone;
        form.father_education = props.student.father_education;
        form.father_profession = props.student.father_profession;
        form.mother_name = props.student.mother_name;
        form.mother_phone = props.student.mother_phone;
        form.mother_education = props.student.mother_education;
        form.mother_profession = props.student.mother_profession;
        form.present_address = props.student.present_address;
        form.permanent_address = props.student.permanent_address;
        form.prev_school = props.student.prev_school;
        form.prev_class = props.student.prev_class;
        form.transfer_certificate = props.student.transfer_certificate;

        form.admition_fees = props.bill?.total_amount ?? usePage()?.props?.academy?.admission_fees;
        form.discount=props?.bill?.discount ?? 0;
            form.months = props.student.student_tuition_fees.map(fee => Number(fee.month))
    }
    form.admition_fees = props.student?.admission_fee ?? usePage()?.props?.academy?.admission_fees;
    computeSubTotal(usePage()?.props?.academy?.admission_fees)
});

const saveData = () => {
    form.post(route('student.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('student.update', props.student), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const dateOptions = [
    { label: "Male", value: "Male" },
    { label: "Female", value: "Female" },
];
const religionOptions = [
    { label: "Hindu", value: "Hindu" },
    { label: "Muslim", value: "Muslim" },
    { label: "Christian", value: "Christian" },
    { label: "Buddhist", value: "Buddhist" },
    { label: "Other", value: "Other" },
];

const castOptions = [
    { label: "Brahmin", value: "Brahmin" },
    { label: "Chhetri", value: "Chhetri" },
    { label: "Magar", value: "Magar" },
    { label: "Rai", value: "Rai" },
    { label: "Limbu", value: "Limbu" },
    { label: "Newar", value: "Newar" },
    { label: "Tharu", value: "Tharu" },
    { label: "Tamang", value: "Tamang" },
    { label: "Dalit", value: "Dalit" },
    { label: "Other", value: "Other" },
];
function handleFileChange(event) {
    const file = event.target.files[0];
    if (file) {
        form.transfer_certificate = file;
        console.log('Selected file:', file);
    }
}

const isTaxOpen = ref(false);
const toggleTaxes = () => {
    isTaxOpen.value = !isTaxOpen.value;
}

const taxes = ref([]);

onMounted(() => {
    fetchTaxes();
   
});

const fetchTaxes = async () => {
    const response = await axios.get(route('tax.all'));
    taxes.value = response.data.taxes;

}
const monthlyFees=ref(0);
watch(
  () => form.course_id,
  async (newVal, oldVal) => {
    if (!newVal) return

    try {
      const response = await axios.get(route('course.find',newVal))
      monthlyFees.value=response.data?.course?.fees;

      computeTutionFee();
    } catch (error) {
      console.error('Failed to fetch course details:', error)
    }
  }
)
watch(
  () => form.months,
  (newVal, oldVal) => {
    computeTutionFee();
  }
)

const computeTutionFee=()=>{
    const fees=monthlyFees.value*form.months.length;
    form.tution_fees= fees ?? 0;
}


const netTotalAmount=ref(0);
const discountAmount=ref(0)
const computeNetTotal=(netAmount,discount)=>{
    const netAmt=Number(netAmount)-Number(discount);
    netTotalAmount.value=Number(netAmt).toFixed(2);
    form.net_total=netAmt;
    computeTotalAmount(netAmt)
}

const totalAmountVal=ref(0);
const computeTotalAmount = (amt) => {
  let totalAmt = 0;

  for (const tax of form.taxes) {
    const taxAmount = Number(amt) * (tax.percentage / 100);
    totalAmt += taxAmount;
  }
  const total=Number(amt)+Number(totalAmt);
  totalAmountVal.value=total;
  form.total_amount=total;
}

const subTotal=ref(0);
const computeSubTotal=(admittionFee)=>{
   
    const tutionFees=form.tution_fees;
    subTotal.value=Number(admittionFee)+Number(tutionFees)
    computeNetTotal(subTotal.value,discountAmount.value)
    form.sub_total=Number(admittionFee)+Number(tutionFees);
}
watch(
  [() => form.months, () => form.course_id, () => form.admission_fees],
  () => computeSubTotal(form.admition_fees),
  { immediate: true }
)


const computeDiscount=()=>{
    if(form.is_percentage){
        if(subTotal.value>0){
            const discount=subTotal.value*form.discount/100;
            discountAmount.value=discount.toFixed(2);
        }else{
            discountAmount.value='0.0';
        }
    }else{
        discountAmount.value=Number(form.discount).toFixed(2);
    }
    computeNetTotal(subTotal.value,discountAmount.value)
}
watch(
  [() => form.is_percentage, () => form.discount],
  () => {
    // alert('hello')
    computeDiscount()
  }
)

const computePercentageAmount=(netAmt,percent)=>{
    const percentage=netAmt*percent/100;
    return percentage;
}

</script>
<template>
    <button @click="toggleModal" class="" v-if="isSelect" type="button">
        <component :is="Plus" />
    </button>
    <div v-else>
        <button @click="toggleModal" type="button" class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5"
            v-if="title">{{ title }}</button>
        <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            v-else>Add Student</button>
            
    </div>

    <Modal :show="openModal" maxWidth="4xl" :title="student?.id ? 'Edit Student' : 'Add Student'" @close="toggleModal"
        :selectedData="student">

        <form @submit.prevent="submit">
            <!-- {{ bill }} -->
            <!-- {{ student?.student_tuition_fees }} -->
            <div class="flex gap-3">
                <div class="w-full">
                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-12">
                            <div class="bg-gray-100 py-2 px-3 rounded">
                                <span class="text-[14px]">Basic Information :</span>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label class="text-[14px]">Roll Number *</label>
                            <input type="number" v-model="form.roll_number"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Roll number" />
                            <small class="text-red-600">{{ form.errors.roll_number }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Name *</label>
                            <input type="text" v-model="form.name"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter student name" />
                            <small class="text-red-600">{{ form.errors.name }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Registration No. *</label>
                            <input type="text" v-model="form.registration_number"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter registration" />
                            <small class="text-red-600">{{ form.errors.registration_number }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Registration Date *</label>
                            <Datepicker v-model="form.registration_date" />
                            <small class="text-red-600">{{ form.errors.registration_date }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Phone</label>
                            <input type="text" v-model="form.phone"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter phone number" />
                            <small class="text-red-600">{{ form.errors.phone }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Email</label>
                            <input type="text" v-model="form.email"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter email" />
                            <small class="text-red-600">{{ form.errors.email }}</small>
                        </div>

                        <div class="col-span-3">
                            <label class="text-[14px]">Birth Date</label>
                            <Datepicker v-model="form.birth_date" />
                            <small class="text-red-600">{{ form.errors.birth_date }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Gender</label>
                            <SelectComponent v-model="form.gender" :options="dateOptions" label="Date Format *"
                                placeholder="Select gender" class="mt-[5px]" />
                            <small class="text-red-600">{{ form.errors.gender }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Religion</label>
                            <SelectComponent v-model="form.religion" :options="religionOptions" label="Date Format *"
                                placeholder="Select gender" class="mt-[5px]" />
                            <small class="text-red-600">{{ form.errors.religion }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Cast</label>
                            <SelectComponent v-model="form.cast" :options="castOptions" label="Date Format *"
                                placeholder="Select gender" class="mt-[5px]" />
                            <small class="text-red-600">{{ form.errors.cast }}</small>
                        </div>

                        <div class="col-span-3">
                            <label class="text-[14px]">National ID</label>
                            <input type="text" v-model="form.national_id"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter national id" />
                            <small class="text-red-600">{{ form.errors.national_id }}</small>
                        </div>

                        <!-- ========================== -->
                        <div class="col-span-12">
                            <div class="bg-gray-100 py-2 px-3 rounded">
                                <span class="text-[14px]">Academic Information :</span>
                            </div>
                        </div>
                        <div class="col-span-12">
                            <div class="flex gap-3">
                                <div class="w-full">
                                    <label class="text-[14px]">Course *</label>
                                    <SelectCourse class="mt-[5px]" v-model="form.course_id" />
                                    <small class="text-red-600">{{ form.errors.course_id }}</small>
                                </div>
                                <div class="w-full">
                                    <label class="text-[14px]">Section</label>
                                    <SelectSection class="mt-[5px]" v-model="form.section_id"
                                        :courseId="form.course_id" />
                                    <small class="text-red-600">{{ form.errors.section_id }}</small>
                                </div>
                                <div class="w-full">
                                    <label class="text-[14px]">Group</label>
                                    <SelectGroup class="mt-[5px]" v-model="form.group_id" />
                                    <small class="text-red-600">{{ form.errors.group_id }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- =============================== -->
                        <div class="col-span-12">
                            <div class="bg-gray-100 py-2 px-3 rounded">
                                <span class="text-[14px]">Father's Information :</span>
                            </div>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Father Name</label>
                            <input type="text" v-model="form.father_name"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter father name" />
                            <small class="text-red-600">{{ form.errors.father_name }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Phone</label>
                            <input type="text" v-model="form.father_phone"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter father phone" />
                            <small class="text-red-600">{{ form.errors.father_phone }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Education</label>
                            <input type="text" v-model="form.father_education"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter father education" />
                            <small class="text-red-600">{{ form.errors.father_education }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Profession</label>
                            <input type="text" v-model="form.father_profession"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter father profession" />
                            <small class="text-red-600">{{ form.errors.father_profession }}</small>
                        </div>




                        <!-- =============================== -->
                        <div class="col-span-12">
                            <div class="bg-gray-100 py-2 px-3 rounded">
                                <span class="text-[14px]">Mother's Information :</span>
                            </div>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Mother Name</label>
                            <input type="text" v-model="form.mother_name"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter mother name" />
                            <small class="text-red-600">{{ form.errors.mother_name }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Phone</label>
                            <input type="text" v-model="form.mother_phone"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter mother phone" />
                            <small class="text-red-600">{{ form.errors.mother_phone }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Education</label>
                            <input type="text" v-model="form.mother_education"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter mother education" />
                            <small class="text-red-600">{{ form.errors.mother_education }}</small>
                        </div>
                        <div class="col-span-3">
                            <label class="text-[14px]">Profession</label>
                            <input type="text" v-model="form.mother_profession"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter mother profession" />
                            <small class="text-red-600">{{ form.errors.mother_profession }}</small>
                        </div>

                        <!-- =============================== -->
                        <div class="col-span-12">
                            <div class="bg-gray-100 py-2 px-3 rounded">
                                <span class="text-[14px]">Address Information :</span>
                            </div>
                        </div>
                        <div class="col-span-6">
                            <label class="text-[14px]">Present</label>
                            <input type="text" v-model="form.present_address"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter present address" />
                            <small class="text-red-600">{{ form.errors.present_address }}</small>
                        </div>
                        <div class="col-span-6">
                            <label class="text-[14px]">Permanent</label>
                            <input type="text" v-model="form.permanent_address"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter permanent address" />
                            <small class="text-red-600">{{ form.errors.permanent_address }}</small>
                        </div>

                        <!-- ========================== -->
                        <div class="col-span-12">
                            <div class="bg-gray-100 py-2 px-3 rounded">
                                <span class="text-[14px]">Previous School :</span>
                            </div>
                        </div>
                        <div class="col-span-12">
                            <div class="flex gap-3">
                                <div class="w-full">
                                    <label class="text-[14px]">School Name</label>
                                    <input type="text" v-model="form.prev_school"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter school name" />
                                    <small class="text-red-600">{{ form.errors.prev_school }}</small>
                                </div>
                                <div class="w-full">
                                    <label class="text-[14px]">Class</label>
                                    <input type="text" v-model="form.prev_class"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter class" />
                                    <small class="text-red-600">{{ form.errors.prev_class }}</small>
                                </div>
                                <div class="w-full">
                                    <label class="text-[14px]">Transfer Certificate</label>
                                    <input type="file" @change="handleFileChange"
                                        class="w-full border border-gray-300 rounded px-3 py-[5px] mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter student name" />
                                    <small class="text-red-600">{{ form.errors.transfer_certificate }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-[400px]" v-if="!student?.id">
                    <div class="bg-gray-100 py-2 px-3 rounded mb-2">
                        <span class="text-[14px]">Profile Information :</span>
                    </div>
                    <ImageUploader1 :height="'100px'" :title="'Brows Profile'" v-model="form.profile"/>

                    <div class="bg-gray-100 py-2 px-3 mt-2 rounded mb-2">
                        <span class="text-[14px]">Billing Information :</span>
                    </div>

                    <div class="block">
                        
                        <label class="checkbox-wrapper">
                            <input type="checkbox" disabled checked />
                            <span class="checkmark"></span>
                            Admission Fees
                        </label>
                        <input type="number" :class="student?.id ? 'pointer-events-none bg-gray-100' : ''" v-model="form.admition_fees" step="0.01"
                            class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter admission fees" />
                    </div>

                    <div class="block mt-3">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" disabled checked />
                            <span class="checkmark"></span>
                            Tution Fees
                        </label>
                        <MultiMonthSelect :class="student?.id ? 'pointer-events-none ' : ''" v-model="form.months"/>
                    </div>

                    <div class="block mt-3 hidden">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="" id=""></input>
                            <label for="">Hostel Fees</label>
                        </div>
                        <input type="text"
                            class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter admission fees" />
                    </div>


                    <hr class="my-3">

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
                        <input type="text" v-model="form.discount" :class="student?.id ? 'pointer-events-none bg-gray-100' : ''"
                            class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Discounts" />
                            <!-- {{ form.discount }} -->
                    </div>

                    <hr class="my-3">

                    <div class="block mt-3 bg-gray-100 p-3 rounded">
                        <div class="flex items-center justify-between gap-3" @click="toggleTaxes">
                            <label for="">Includes Taxes</label>
                            <div class="bg-red-100 h-[20px] w-[20px] text-red-300 rounded-full">
                                <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                        <div :class="isTaxOpen ? '' : 'h-[0px]'" class=" overflow-hidden">
                            <hr class="my-2">
                            <div class="flex justify-between mb-1" v-for="(item, key) in taxes">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" :checked="isSelected(item)" @change="toggleTax(item)" name="" id=""></input>
                                    {{ item?.name }}
                                </div>
                                <div>
                                    {{ item?.percentage }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="block mt-3 bg-gray-100 p-3 rounded">
                        <div class="flex justify-between">
                            <small>
                                Admission Fees
                            </small>
                            <small>
                                Rs. {{form.admition_fees}}
                            </small>
                        </div>
                        <hr class="my-1">
                        <div class="flex justify-between hidden">
                            <small>
                                Hostel Fees
                            </small>
                            <small>
                                Rs. 2000
                            </small>
                        </div>
                        <hr class="my-1 hidden">
                        <div class="flex justify-between">
                            <small>
                                Tution Fees
                            </small>
                            <small>
                                Rs. {{form.tution_fees}}
                            </small>
                        </div>
                        <hr class="my-1">
                        <div class="flex justify-between font-bold">
                            <small>
                                Sub Total
                            </small>
                            <small>
                                Rs. {{subTotal}}
                            </small>
                        </div>
                        <hr class="my-1">
                        <div class="flex justify-between">
                            <small>
                                Discount
                            </small>
                            <small>
                                Rs. {{discountAmount}}
                            </small>
                        </div>
                        <hr class="my-1">
                        <div class="flex justify-between font-bold">
                            <small>
                                Net Total
                            </small>
                            <small>
                                Rs. {{netTotalAmount}}
                            </small>
                        </div>
                        <hr class="my-1">

                        
                        <div><small><b>Taxes</b></small></div>
                        <div class="flex justify-between" v-for="(item,index) in form.taxes" :key="index">
                            <small>
                                {{item?.name}} ({{ item?.percentage }}%)
                            </small>
                            <small>
                                Rs. {{computePercentageAmount(netTotalAmount,item.percentage)}}
                            </small>
                        </div>
                        
                        <hr class="my-1">
                        <div class="flex justify-between font-bold">
                            <small>
                                Grand Total
                            </small>
                            <small>
                                Rs. {{totalAmountVal}}
                            </small>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{ student?.id ? 'Update Student' : 'Save Student' }}
                </button>
            </div>
        </form>
    </Modal>
</template>

<style scoped>
.checkbox-wrapper {
  display: flex;
  align-items: center;
  cursor: pointer;
  font-size: 16px;
}

/* Hide default checkbox */
.checkbox-wrapper input[type="checkbox"] {
  opacity: 0;
  width: 0;
  height: 0;
}

/* Custom checkmark box */
.checkmark {
  width: 18px;
  height: 18px;
  border: 2px solid #4a90e2;
  border-radius: 4px;
  margin-right: 8px;
  position: relative;
  transition: all 0.2s ease;
}

/* Checkmark indicator */
.checkbox-wrapper input:checked + .checkmark {
  background-color: #4a90e2;
  border-color: #4a90e2;
}

.checkmark::after {
  content: "";
  position: absolute;
  display: none;
}

.checkbox-wrapper input:checked + .checkmark::after {
  display: block;
  left: 5px;
  top: 2px;
  width: 4px;
  height: 8px;
  border: solid white;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}
</style>
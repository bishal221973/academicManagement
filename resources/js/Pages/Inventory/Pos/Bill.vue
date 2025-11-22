<script setup>
import Toggle from '@/Components/Toggle.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import SelectAllStudent from '@/Components/Select/SelectAllStudent.vue';
const props = defineProps({
    student: Object,
    orderList: Array,
    increase: Function,
    decrease: Function,
    clearOrder:Function,
})

const form = useForm({
    sub_total: 0,
    discount: 0,
    discountAmt: 0,
    is_percentage: false,
    grandTotal: 0,
    orderList: [],
    student_id: ""
})
watch(
    () => props.orderList,
    (newVal, oldVal) => {
        console.log('Order list changed:', newVal);

        form.sub_total = props.orderList.reduce((total, item) => {
            return total + (item.rate * item.qty);
        }, 0);
        form.orderList = props?.orderList;
        computeGrandTotal();
    },
    { deep: true } // ensure nested changes are detected
);

const discountAmount = ref(0);
const computeDiscount = () => {
    if (form.is_percentage) {
        if (form.sub_total > 0) {
            const discount = form.sub_total * form.discount / 100;
            discountAmount.value = discount.toFixed(2);
        } else {
            discountAmount.value = '0.0';
        }
    } else {
        discountAmount.value = Number(form.discount).toFixed(2);
    }
    form.discountAmt = discountAmount.value;
    computeGrandTotal();
    // computeNetTotal(subTotal.value,discountAmount.value)
}
watch(
    [() => form.is_percentage, () => form.discount],
    () => {
        computeDiscount()
    }
)

const computeGrandTotal = () => {
    const grandTotal = Number(form.sub_total) - Number(form.discountAmt);
    form.grandTotal = grandTotal;
}

const saveData = () => {
    form.post(route('sell.store'),{
        onSuccess:()=>{
            form.reset();
            props.clearOrder();
            
        }
    });
}
</script>
<template>
    <div style="width: 400px;">
        <div class="p-3 rounded bg-white shadow" style="min-height: calc(100vh - 300px);">
            <form @submit.prevent="saveData">
                <div class="flex justify-between">
                    <!-- <small><b>Current Order</b></small> -->
                     <!-- {{ form.productList }} -->
                    <SelectAllStudent :addButton="false" v-model="form.student_id" />
                </div>
                <!-- {{ form.orderList }} -->
                <div style="height: calc(100vh - 430px);overflow-y: auto;">

                    <div v-if="orderList.length === 0" class="mt-3 text-gray-400 text-sm">
                        No items added yet.
                    </div>

                    <div v-for="item in orderList" :key="item.id"
                        class="mt-3 border-b pb-2 flex justify-between items-center">

                        <div>
                            <small><b>{{ item.product }}</b></small><br>
                            <small class="text-gray-500">Rs. {{ item.rate * item.qty }}</small>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" class="px-2 py-1 bg-gray-200 rounded" @click="decrease(item.id)">-</button>
                            <span>{{ item.qty }}</span>
                            <!-- {{ item?.qty1 }} -->
                            <button type="button" class="px-2 py-1 bg-gray-200 rounded"
                                @click="increase(item.id, item.qty1)">+</button>
                        </div>

                    </div>
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
                    <input type="text" v-model="form.discount"
                        :class="student?.id ? 'pointer-events-none bg-gray-100' : ''"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Discounts" />
                    <!-- {{ form.discount }} -->
                </div>


                <div class="block mt-3 bg-gray-100 p-3 rounded">
                    <div class="flex justify-between">
                        <small>
                            Sub Total
                        </small>
                        <small>
                            Rs. {{ form.sub_total }}
                        </small>
                    </div>
                    <hr class="my-1">
                    <div class="flex justify-between">
                        <small>
                            Discount
                        </small>
                        <small>
                            Rs. {{ form.discountAmt }}
                        </small>
                    </div>
                    <hr class="my-1">
                    <div class="flex justify-between">
                        <small>
                            Grand Total
                        </small>
                        <small>
                            Rs. {{ form.grandTotal }}
                        </small>
                    </div>

                    <button class="w-full mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        type="submit">
                        Save
                    </button>

                </div>
            </form>

        </div>
    </div>
</template>
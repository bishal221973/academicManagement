<script setup>
import { useForm } from "@inertiajs/vue3";
import { Trash } from "lucide-vue-next";
import Swal from "sweetalert2";

const props = defineProps({
    route: {
        type: Object,
        required: true,
    },
});
const deleteData = () => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteRecord();
        }
    });
}

const deleteRecord = () => {
    useForm({}).delete(props.route, {
        onSuccess: () => {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Selected record has been deleted"
            });
        }
    })
}
</script>
<template>
    <button @click="deleteData">
        <component :is="Trash" class="h-[20px] text-red-600" />
    </button>
</template>
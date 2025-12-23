<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('admin.login'), {
        onFinish: () => form.reset('password'),
    });
};

const showPassword=ref(false);

</script>
<template>
    <Head title="Log in" />

    <div class="container">
        <div class="hover flex items-center justify-center">
            <div class="flex flex-col lg:flex-row justify-between w-full max-w-7xl px-4">

                <!-- LEFT SECTION -->
                <div class="w-full lg:w-1/2 text-center lg:text-left pl-5">
                    <img
                        src="/logo.jpg"
                        class="h-16 mx-auto lg:mx-0 rounded-full mt-6"
                        alt=""
                    />

                    <div class="mt-8 lg:mt-10">
                        <span class="text-white font-bold text-xl sm:text-2xl lg:text-[50px] uppercase block" style="line-height:50px">
                            Bauddhik Education Academy
                        </span>

                        <span class="block text-white text-sm sm:text-base mt-2">
                            Birendranagar-7, Surkhet
                        </span>

                        <span class="text-gray-300 block mt-6 lg:mt-20 text-sm sm:text-base">
                            Bauddhik Education Academy is a renowned educational institution located in
                            Birendranagar, Surkhet, offering specialized teaching and training for aspiring
                            candidates aiming to join the Nepal Army and Police.
                        </span>
                    </div>
                </div>

                <!-- RIGHT CARD -->
                <div class="card w-full lg:w-1/3 mt-10 lg:mt-0">
                    <span class="uppercase text-2xl sm:text-3xl font-bold text-blue-500 block text-center">
                        Welcome
                    </span>

                    <span class="block text-center text-xs sm:text-sm text-gray-500 mt-2">
                        Comprehensive Training, Expert Guidance, and Unwavering Discipline
                    </span>

                    <hr class="my-5">

                    <form @submit.prevent="submit">
                        <div class="mb-1">
                            <label>Email</label>
                            <input
                                type="email"
                                v-model="form.email"
                                class="w-full rounded border-gray-300"
                                placeholder="Email"
                            />
                            <InputError class="" :message="form.errors.email" />
                        </div>

                        <div class="mb-2">
                            <label>Password</label>
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                v-model="form.password"
                                class="w-full rounded border-gray-300"
                                placeholder="Password"
                            />
                            <label for="checkbox">
                                <input type="checkbox" name="" id="checkbox" v-model="showPassword" class="rounded-full">
                                <span class="text-xs text-gray-500 ml-2">Show Password</span>
                            </label>
                            <InputError class="" :message="form.errors.password" />
                        </div>

                        <button
                            class="bg-blue-700 py-2 w-full text-white rounded mt-4"
                        >
                            Login
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
.container {
    min-height: 100vh;
    min-width: 100vw;

    background-image: url('/bg.jpeg');
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
}

.hover {
    background-color: rgba(11, 7, 124, 0.8);
    height: 100vh;
    width: 100vw;
}

.card {
    background-color: white;
    height: 80vh;
    position: block;
    margin-top: 5vh;
    margin: 50px;
    padding: 50px;
    border-radius: 50px;
    /* overflow: hidden; */
}
</style>

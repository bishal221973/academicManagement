<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

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
</script>

<template>

    <Head title="Log in" />

    <!-- <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

<div v-if="status" class="mb-4 font-medium text-sm text-green-600">
    {{ status }}
</div>

<form @submit.prevent="submit">
    <div>
        <InputLabel for="email" value="Email" />
        <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required autofocus
            autocomplete="username" />
        <InputError class="mt-2" :message="form.errors.email" />
    </div>

    <div class="mt-4">
        <InputLabel for="password" value="Password" />
        <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
            autocomplete="current-password" />
        <InputError class="mt-2" :message="form.errors.password" />
    </div>

    <div class="block mt-4">
        <label class="flex items-center">
            <Checkbox v-model:checked="form.remember" name="remember" />
            <span class="ms-2 text-sm text-gray-600">Remember me</span>
        </label>
    </div>

    <div class="flex items-center justify-end mt-4">
        <Link v-if="canResetPassword" :href="route('password.request')"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Forgot your password?
        </Link>

        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Log in
        </PrimaryButton>
    </div>
</form>
</AuthenticationCard> -->
    <div class="container">
        <div class="hover">
            <div class="flex">
                <div class="w-[100%]">
                    <img src="/logo.jpg" class="h-[60px] rounded-full mt-10 ml-10" alt="">
                    <div class="pl-10 mt-10">
                        <span class="text-white font-bold text-[50px] uppercase">Bauddhik Education Academy</span>
                        <span class="block text-white">Birendranagar-7, Surkhet</span>

                        <span class="text-gray-300 block mt-[190px]">Bauddhik Education Academy is a renowned educational institution
                            located
                            in Birendranagar, Surkhet, offering specialized teaching and training for aspiring
                            candidates
                            aiming to join the Nepal Army and Police. With a team of highly skilled instructors and
                            comprehensive programs covering physical fitness, written exams, and interview techniques,
                            the
                            academy ensures students are well-prepared for the competitive selection processes.</span>
                    </div>
                </div>
                <div class="card">
                    <span class="uppercase text-[35px] font-bold text-blue-500 block text-center">Welcome</span>
                    <span class="block text-center text-[12px] text-gray-500">Comprehensive Training, Expert Guidance,
                        and
                        Unwavering Discipline for a Successful Career in Defense Services.</span>

                    <div class="mt-16">
                        <hr class="mb-16">
                        <form @submit.prevent="submit">
                            <div class="block mb-3">
                                <label for="">Email</label>
                                <input type="email" v-model="form.email" class="w-full rounded border-gray-300" placeholder="Email" name=""
                                    id="">
                                    <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="block">
                                <label for="">Password</label>
                                <input type="password" v-model="form.password" class="w-full rounded border-gray-300" placeholder="Email"
                                    name="" id="">
                                    <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="flex mt-2">
                                <label for="checkbox flex">
                                    <input type="checkbox" name="" id="checkbox" class="rounded-xl mr-2">
                                    <span>Show Password</span>
                                </label>
                            </div>

                            <button class="bg-blue-700 py-[7px] w-full text-white rounded mt-5">
                                Login
                            </button>
                        </form>
                    </div>
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
    width: 65%;
    min-height: 86vh;
    position: block;
    margin-top: 5vh;
    margin: 50px;
    padding: 50px;
    border-radius: 50px;
}
</style>

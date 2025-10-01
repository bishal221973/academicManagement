<template>
    <div class="w-full bg-white p-3 rounded shadow shadow-main/20 flex justify-between">
        <span><i>Logo Here</i></span>
        <div class="flex justify-between gap-3">
            {{ $page?.props?.auth?.user?.name }}
            <img :src="'/user.png'" class="h-[20px] w-[20px]" alt="">
        </div>
    </div>
</template>

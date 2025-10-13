<script setup>

const props=defineProps({
    student:Object,
})


</script>
<template>
    <div class="bg-white shadow-md rounded-md overflow-hidden relative h-[100%] transform transition duration-300 hover:scale-105">
        <div class="flex justify-between h-full">
            <div>
                <div class="w-[30px] bg-gray-400 h-[50%] left-sidebar1"> </div>
                <div class="w-[30px]  h-[60%] left-sidebar2 bg-red-500 relative -top-[10%]">
                    <div class="left-sidebar3"></div>
                </div>
            </div>

            <div class="h-[100%] w-[20px] flex items-center">
                <div class="h-[50%] w-[20px] flex items-center right-sidebar-1">
                    <div class=" flex items-center right-sidebar-2"></div>
                </div>
            </div>
        </div>
        <div class="absolute h-[100%] w-[100%] top-0 left-0 px-[32px]">
            <div class="flex justify-center mt-[50px]">
                <div class="bg-[#c55b29] h-[90px] w-[90px] rounded-xl p-[7px]">
                    <img :src="'/images/student.jpg'" class="h-[100%] w-[100%] rounded-lg" alt="">
                </div>
            </div>
            <b class="block text-center mt-3">{{student?.name}}</b>
            <div class="flex gap-1 mt-3">
                <span class="text-[11px] left-txt">Course</span>
                <span class="text-[11px]">:</span>
                <span class="text-[11px]">{{ student?.course?.name }}</span>
            </div>
            <div class="flex gap-1">
                <span class="text-[11px] left-txt">Reg No.</span>
                <span class="text-[11px]">:</span>
                <span class="text-[11px]">{{ student?.registration_number }}</span>
            </div>

            <div class="flex gap-1">
                <span class="text-[11px] left-txt">Roll no.</span>
                <span class="text-[11px]">:</span>
                <span class="text-[11px]">{{student?.roll_number}}</span>
            </div>
            <div class="footer w-full ">
                <div class="flex items-center justify-between w-full gap-3">
                    <img :src="'/images/logo.png'" class="h-[30px]" alt="">
                    <b class="text-[8px] text-[#c55b29]">National Academy of Science And Technology</b>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.left-sidebar1 {
    position: relative;
    left: -10px;
    background-color: #d1d5db;
    /* light gray (Tailwind gray-300) */
    border-top-right-radius: 70px;
    border-bottom-right-radius: 70px;
    overflow: hidden;
}

.left-sidebar2 {
    left: -10px;
    background-color: #c55b29;
    /* light gray (Tailwind gray-300) */
    border-top-right-radius: 70px;
    border-bottom-right-radius: 70px;
    overflow: hidden;
}


.left-sidebar3 {
    left: -10px;
    background-color: #c4812a;
    /* light gray (Tailwind gray-300) */
    border-top-right-radius: 70px;
    border-bottom-right-radius: 70px;
    overflow: hidden;
    position: absolute;
    height: 80%;
    width: 100%;
    top: 10%;
}

.right-sidebar-1 {
    background-color: #c55b29;
    border-top-left-radius: 70px;
    border-bottom-left-radius: 70px;
    position: relative;
}

.right-sidebar-2 {
    background-color: #c4812a;
    border-top-left-radius: 70px;
    border-bottom-left-radius: 70px;
    position: absolute;
    height: 80%;
    width: 60%;
    top: 10%;
    right: 0;
}
.left-txt{
    color: #c55b29;
    min-width: 40px;
}
.footer{
    position: absolute;
    bottom: 10px;
    width: calc(100% - 50px);
}
</style>

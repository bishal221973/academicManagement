<script setup>

const props=defineProps({
    student:Object,
})


</script>
<template>
    <div class="bg-white shadow-md rounded-md overflow-hidden relative h-[100%] transform transition duration-300 hover:scale-105">
        <div class="image-wrapper shadow-xl z-[1]">
            <img src="/images/building.jpeg" alt="Building" class="buildings">
            <div class="overlay"></div>
            <div class="circle1">
            </div>
            <div class="circle2"></div>
        </div>
        <div class="flex justify-center h-[45px] mb-3  ">
            <div class="h-[90px] w-[90px] rounded-full z-[9999] overflow-hidden absolute -mt-[50px] bg-white p-1">
                <img :src="'/images/student.jpg'" class="h-[100%] w-[100%] student-img rounded-full" alt="">
            </div>
        </div>
        <div class="circle3"></div>
        <b for="" class="block uppercase text-center text-[16px]">{{student?.name}}</b>
        <label for="" class="block text-[11px] text-center">Course : {{ student?.course?.name }}</label>
        <label for="" class="block text-[11px] text-center">Reg No.: {{ student?.registration_number }}</label>
        <label for="" class="block text-[11px] text-center">Class Roll No. : {{student?.roll_number}}</label>
        <div class="absolute bottom-0 w-full ">
            <div class="bg-main/10 gap-3 w-full footer flex items-center px-[20px]">
                 <img :src="'/images/logo.png'" class="h-[30px]" alt="">
                <b class="text-[8px] block text-center text-main">National Academy of Science And Technology</b>
            </div>
        </div>
    </div>
</template>

<style scoped>
.image-wrapper {
    position: relative;
    width: 100%;
    height: 110px;
    border-radius: 8px;
    overflow: hidden;
    background-color: white;
    border-bottom-left-radius: 200px;
    border-bottom-right-radius: 200px;
    padding-bottom: 10px;
}

.buildings {
    width: 100%;
    height: calc(100% - 10px);
    aspect-ratio: 16/9;
    object-fit: cover;
    display: block;
    border-bottom-left-radius: 200px;
    border-bottom-right-radius: 200px;
}

.overlay {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: calc(100% - 10px);
    background: rgba(0, 0, 0, 0.6);
    /* semi-transparent dark layer */
    z-index: 10;
    border-bottom-left-radius: 200px;
    border-bottom-right-radius: 200px;
}

.circle1 {
    position: absolute;
    bottom: -35px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 90px;
    background: rgba(85, 6, 6, 0.6);
    /* filter: blur(1px); */
    border-radius: 50%;
    z-index: 5;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.circle2 {
    position: absolute;
    bottom: -105px;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 110px;
    height: 110px;
    background: white;
    border-radius: 50%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.student-img {
    border: 2px solid white !important;
}

.circle3 {
    position: absolute;
    top: 100px;
    left: 50%;
    /* z-index: 9999; */
    transform: translate(-50%, -50%);
    width: 122px;
    height: 122px;
    background: white;
    border-radius: 50%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.footer{
    border-top-left-radius: 200px;
    border-top-right-radius: 200px;
    height: 40px;
}
</style>

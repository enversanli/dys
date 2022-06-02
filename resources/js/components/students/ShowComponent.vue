<template>
    <div class=" my-10 d-block w-full">
        <h2 class="text-center">Öğrenci Bilgileri</h2>
        <div class="h-40 w-40 mx-auto my-10">
            <img class="h-full w-full rounded-full  border-2 my-10 mx-auto" :src="student.photo_url">
        </div>
        <hr>
        <div class="grid w-full">
            <div class="w-full border-2 grid grid-cols-1 mb-10">
                <div class="grid grid-cols-2">
                    <input class="w-full border-2 rounded-md p-1 text-xl mb-3" type="text" :value="student.first_name">
                    <input class="w-full border-2 rounded-md p-1 text-xl mb-3" type="text" :value="student.last_name">

                    <input class="w-full border-2 rounded-md p-1 text-xl mb-3" type="date" :value="student.birth_date">
                </div>

                <h3 class="text-center my-5">Genel</h3>

                <div class="grid grid-cols-2">
                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text" :value="student.class.name">
                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text" :value="student.association.name">
                </div>
                <h3 class="text-center my-5">Veli Bilgileri</h3>
                <div class="grid grid-cols-2">
                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text" :value="student.parent.first_name">
                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text" :value="student.parent.last_name">
                </div>
            </div>
            <button class="w-40 bg-success" @click="update">Güncelle</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ShowComponent",
    data() {
        return {
            student: null,
            classes: {},
        }
    },
    mounted() {
        this.getStudent();
        this.getClasses();
    },

    methods: {
        getStudent() {
            axios.get('/students/11').then(response => {
                this.student = response.data.data;
            });
        },

        getClasses() {
            axios.get('/classes/list').then(response => {
                this.classes = response.data.data
                console.log(this.classes);
            });
        },
         update(){
            alert("Update");

            axios.put('/students/11').then(response => {

            });
         }
    }
}
</script>

<style scoped>

</style>

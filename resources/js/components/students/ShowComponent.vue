<template>
<div class="mx-10 my-10 d-block w-full">
    <div class="w-full inline-block border-2">
        <input class="w-1/2 border-2" type="text" :value="student.first_name">
        <input class="w-1/2 border-2" type="text" :value="student.last_name">
    </div>
</div>
</template>

<script>
export default {
    name: "ShowComponent",
    data(){
        return{
            student:null,
        }
    },
    mounted() {
        this.getStudent();
    },

    methods:{
        getStudent(){
            axios.get('/students/11').then(response => {
                this.student = response.data.data;
            });
        }
    }
}
</script>

<style scoped>

</style>

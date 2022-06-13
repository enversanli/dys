<template>
    <div class=" my-10 d-block w-full">
        <h2 class="text-center">Öğrenci Bilgileri</h2>
        <div class="h-40 w-40 mx-auto my-10">
            <img class="h-full w-full rounded-full  border-2 my-10 mx-auto" :src="user.photo_url">
        </div>
        <hr>
        <div class="grid w-full">
            <div class="w-full border-2 grid grid-cols-1 mb-10">
                <div class="grid grid-cols-2">
                    <input class="w-full border-2 rounded-md p-1 text-xl mb-3" type="text" v-model="user.first_name">
                    <input class="w-full border-2 rounded-md p-1 text-xl mb-3" type="text" v-model="user.last_name">

                    <input class="w-full border-2 rounded-md p-1 text-xl mb-3" type="date" v-model="user.birth_date">
                </div>

                <h3 class="text-center my-5">Genel</h3>

                <div class="grid grid-cols-2">
                    <select v-model="user.class_id">
                        <option v-for="cls in classes" :value="cls.id" :selected="user.class && cls.id === user.class.id">{{cls.name}}</option>
                    </select>
                </div>

                <div class="grid grid-cols-2">
                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text" v-if="user.class"
                           v-model="user.class.name">
                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text" v-if="user.association"
                           v-model="user.association.name">
                </div>
                <h3 class="text-center my-5" v-if="user.parent">Veli Bilgileri</h3>
                <div class="grid grid-cols-2" v-if="user.parent">
                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text"
                           v-model="user.parent.first_name">
                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text"
                           v-model="user.parent.last_name">
                </div>
            </div>
            <button class="w-40 bg-success" @click="update">Güncelle</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ShowComponent",
    props: ['id'],
    data() {
        return {
            user: null,
            classes: {},
        }
    },
    mounted() {
        this.getStudent();
        this.getClasses();
    },


    methods: {
        getStudent() {
            axios.get('/users/' + this.id).then(response => {
                this.user = response.data.data;
            }).catch(error => {
                this.$alert(error.response.data.message, 'Hata', 'error');
            });
        },

        getClasses() {
            axios.get('/classes/list').then(response => {
                this.classes = response.data.data;
            });
        },
        update() {
            const data = {
                first_name: this.user.first_name,
                last_name: this.user.last_name,
                class_id: this.user.class_id,
                birth_date : this.user.birth_date,
            };

            axios.put('/users/' + + this.id, data).then(response => {
                this.$alert('Kullanıcı başarıyla güncellendi..', 'İşlem Başarılı', 'success')
            }).catch((error)=>{
                this.$alert(error.response.data.message, 'Hata', 'error');
            });
        }
    }
}
</script>

<style scoped>

</style>

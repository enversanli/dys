<template>

    <div class="w-full shadow-lg my-10 p-2">
        <div class="px-4">
            <label>
                Kullanıcı Tipi
            </label>
            <select @change="checkForms($event)" v-model="role" class="w-full my-5 border-gray-800  border p-2 border-slate-400 rounded">
                <option v-for="userRole in userRoles" :value="userRole.key">{{userRole.translated}}</option>
            </select>
        </div>
        <div class="flex w-full">
            <div class="w-full px-3">
                <label for="first_name">Adı</label>
                <input id="first_name" type="text"
                       v-model="user.first_name"
                       class="w-full my-5 border-gray-800 mr-5 border p-2 border-slate-400 rounded" name="first_name">
            </div>
            <div class="w-full px-3">
                <label for="last_name">Soyadı</label>
                <input id="last_name" type="text" class="w-full my-5 border p-2 border-slate-400 rounded"
                       v-model="user.last_name"
                       name="last_name">
            </div>
        </div>
        <div class="flex w-full">
            <div class="w-full px-3">
                <label for="first_name">Doğum Tarihi</label>
                <input id="birth_date" type="date"
                       v-model="user.birth_date"
                       class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded" name="first_name">
            </div>
            <div class="w-full px-3" v-show="studentForm">
                <label for="last_name">Sınıfı</label>
                <select class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded" name="class_id"
                        v-model="user.class_id"
                        v-if="classes != null">
                    <option>Sınıf Seç</option>
                    <option v-for="row in classes" :value="row.id">{{ row.name }}</option>
                </select>
            </div>
        </div>

        <div class="flex w-full">
            <div class="w-full px-3">
                <label for="email">Email</label>
                <input id="email" type="text"
                       v-model="user.email"
                       class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded" name="parent_email">
            </div>
            <div class="w-full px-3">
                <label for="parent_id">Cinsiyet</label>
                <select class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded student-input" id="parent_id"
                        v-model="user.gender"
                >
                    <option :selected="true" :value="1">Erkek</option>
                    <option :selected="true" :value="0">Kız</option>
                </select>
            </div>
        </div>

        <div class="flex w-full">
            <div class="w-full px-3">
                <label for="email">Email</label>

            </div>
            <div class="w-full px-3" v-show="studentForm">
                <label for="parent_id">Veli</label>
                <select class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded student-input" id="parent_id"
                        v-model="user.parent_id"
                        v-if="classes != null">
                    <option :selected="true">Veli Seç</option>
                    <option v-for="row in parents" :value="row.id">{{ row.first_name + ' ' + row.last_name}}</option>
                </select>
            </div>
        </div>


        <div class="text-right">
            <button @click="update" type="button"
                    class="text-xl mr-2 inline-block px-6 py-2.5 bg-blue-600 text-white font-medium leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                Güncelle
            </button>
        </div>


    </div>

<!--    <div class=" my-10 d-block w-full">-->
<!--        <h2 class="text-center">Öğrenci Bilgileri</h2>-->
<!--        <div class="h-40 w-40 mx-auto my-10">-->
<!--            <img class="h-full w-full rounded-full  border-2 my-10 mx-auto" :src="user.photo_url">-->
<!--        </div>-->
<!--        <hr>-->
<!--        <div class="grid w-full">-->
<!--            <div class="w-full border-2 grid grid-cols-1 mb-10">-->
<!--                <div class="grid grid-cols-2">-->
<!--                    <input class="w-full border-2 rounded-md p-1 text-xl mb-3" type="text" v-model="user.first_name">-->
<!--                    <input class="w-full border-2 rounded-md p-1 text-xl mb-3" type="text" v-model="user.last_name">-->

<!--                    <input class="w-full border-2 rounded-md p-1 text-xl mb-3" type="date" v-model="user.birth_date">-->
<!--                </div>-->

<!--                <h3 class="text-center my-5">Genel</h3>-->

<!--                <div class="grid grid-cols-2">-->
<!--                    <select v-model="user.class_id">-->
<!--                        <option v-for="cls in classes" :value="cls.id" :selected="user.class && cls.id === user.class.id">{{cls.name}}</option>-->
<!--                    </select>-->
<!--                </div>-->

<!--                <div class="grid grid-cols-2">-->
<!--                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text" v-if="user.class"-->
<!--                           v-model="user.class.name">-->
<!--                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text" v-if="user.association"-->
<!--                           v-model="user.association.name">-->
<!--                </div>-->
<!--                <h3 class="text-center my-5" v-if="user.parent">Veli Bilgileri</h3>-->
<!--                <div class="grid grid-cols-2" v-if="user.parent">-->
<!--                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text"-->
<!--                           v-model="user.parent.first_name">-->
<!--                    <input class="w-full border-2 rounded-md p-1 text-xl" type="text"-->
<!--                           v-model="user.parent.last_name">-->
<!--                </div>-->
<!--            </div>-->
<!--            <button class="w-40 bg-success" @click="update">Güncelle</button>-->
<!--        </div>-->
<!--    </div>-->
</template>

<script>
export default {
    name: "ShowComponent",
    props: ['id'],
    data() {
        return {
            user: null,
            userRoles: {},
            classes: {},
            studentForm: false
        }
    },
    mounted() {
        this.getStudent();
        this.getClasses();
        this.getUserRoles();
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
        getUserRoles(){
            axios.get('/user-roles').then(response => {
                this.userRoles = response.data.data;
            }).catch(error => {
                this.$alert(error.response.data.message, 'HATA', 'error');
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
        },
        checkForms(event){
            if(event.target.value === 'student'){
                this.studentForm = true;
                return true;
            }

            this.studentForm = false;
        },
    }
}
</script>

<style scoped>

</style>

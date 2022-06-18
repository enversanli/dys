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
                        v-model="user.gender">
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
            <button @click="storeUser" type="button"
                    class="text-xl mr-2 inline-block px-6 py-2.5 bg-blue-600 text-white font-medium leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                Kaydet
            </button>
        </div>


    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {},
            classes: {},
            parents: {},
            userRoles: {},
            role: null,
            studentForm: false
        }
    },
    name: "StoreComponent",

    mounted() {
        this.getClasses();
        this.getParents();
        this.getUserRoles();
    },

    methods: {
        storeUser() {
            const data = {
                first_name: this.user.first_name,
                last_name: this.user.last_name,
                email: this.user.email,
                birth_date: this.user.birth_date,
                parent_id: this.user.parent_id,
                class_id: this.user.class_id,
                role: this.role,
                gender: this.gender,
            }

            axios.post('/users', data).then(response => {
                this.$alert(response.data.message, 'İşlem Başarılı', 'success');
            }).catch(error => {
                this.$alert(error.response.data.message, 'Hata', 'error');
            });
        },

        getClasses() {
            axios.get('/classes/list').then(response => {
                this.classes = response.data.data
            }).catch(error => {
                this.$alert(error.message, 'Hata', 'error');
            });
        },

        getParents() {
            axios.get('/users?role=parent').then(response => {
                this.parents = response.data.data;
            }).catch(error => {
                this.$alert(error.response.data.message, 'HATA', 'error');
            });
        },

        getUserRoles(){
          axios.get('/user-roles').then(response => {
                this.userRoles = response.data.data;
          }).catch(error => {
              this.$alert(error.response.data.message, 'HATA', 'error');
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

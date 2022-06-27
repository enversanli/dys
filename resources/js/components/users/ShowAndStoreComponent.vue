<template>

    <div class="w-full shadow-lg my-10 p-2">
        <div class="text-center mb-8">
            <img :src="'/user.png'" class="mx-auto h-40 rounded-full shadow-lg">
        </div>
        <div class="px-4" v-show="authUser.role.key !== 'parent'">
            <label>
                Kullanıcı Tipi
            </label>
            <select @change="checkForms($event)" v-model="role"
                    class="w-full my-5 border-gray-800  border p-2 border-slate-400 rounded">
                <option v-for="userRole in userRoles" :value="userRole.key"
                        :selected="user.role && userRole.key === user.role.key ? true : false"
                >
                    {{ userRole.translated }}
                </option>
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
                <label for="first_name">Telefon Numarası</label>
                <input id="mobile_phone" type="text"
                       v-model="user.mobile_phone"
                       class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded" name="mobile_phone">
            </div>
            <div class="w-full px-3">
                <label for="email">Email</label>
                <input id="email" type="text"
                       v-model="user.email"
                       :disabled="!user"
                       class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded" name="parent_email">


            </div>
        </div>

        <div class="flex w-full" v-show="studentForm || teacherForm">
            <div class="w-full px-3">
                <label for="last_name">Sınıfı</label>
                <select class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded"
                        v-model="user.class_id"
                        v-if="classes != null">
                    <option :disabled="myRole('parent')" v-for="row in classes" :value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <div class="w-full px-3" v-if="studentForm">
                <label>Cinsiyet</label>
                <select class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded student-input"
                        id="parent_id"
                        v-model="user.gender"
                >
                    <option :value="1" :selected="user.gender === '1'">Erkek</option>
                    <option :value="0" :selected="user.gender === '0'">Kız</option>
                </select>
            </div>
        </div>

        <div class="flex w-full" v-show="studentForm">
            <div class="w-full px-3">
                <label for="first_name">Doğum Tarihi</label>
                <input id="birth_date" type="date"
                       v-model="user.birth_date"
                       class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded" name="first_name">
            </div>
            <div class="w-full px-3">
                <label for="parent_id">Veli</label>
                <select class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded student-input"
                        id="parent_id"
                        v-show="!myRole('parent')"
                        v-model="user.parent_id"
                        v-if="classes != null">
                    <option selected>Veli Seç</option>
                    <option v-if="authUser.role.key !== 'parent'" v-for="row in parents" :value="row.id">
                        {{ row.first_name + ' ' + row.last_name }}
                    </option>
                </select>
                <input id="parent" type="text"
                       disabled
                       v-show="myRole('parent')"
                       :value="authUser.first_name + ' ' + authUser.last_name"
                       class="w-full my-5 border-gray-800 border p-2 border-slate-400 rounded">
            </div>
        </div>


        <div class="text-right">
            <button @click="update" type="button"
                    class="text-xl mr-2 inline-block px-6 py-2.5 bg-blue-600 text-white font-medium leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                Güncelle
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ShowAndStoreComponent",
    props: ['id', 'authUser'],
    data() {
        return {
            user: {},
            userRoles: {},
            classes: {},
            studentForm: true,
            teacherForm: true,
            parents: {},
            role: null
        }
    },
    mounted() {

        if (this.id) {
            this.getUser();
        }

        if (this.authUser && this.authUser.role !== 'parent') {
            this.getParents();
        }

        if (!this.authUser) {
            this.getMe();
        }

        this.getClasses();
        this.getUserRoles();
        this.checkForms(null);
    },


    methods: {

        // This function returns requested user to frontend by API request
        getUser() {
            axios.get('/users/' + this.id).then(response => {
                this.user = response.data.data;
                this.role = this.user.role.key
                if (this.user.role.key === 'student')
                    this.studentForm = true;

                if (this.user.role.key === 'teacher')
                    this.teacherForm = true;

            }).catch(error => {
                this.$alert(error.response.data.message, 'Hata', 'error');
            });
        },

        getParents() {
            axios.get('/users?role=parent').then(response => {
                this.parents = response.data.data;

            }).catch(error => {
                this.$alert(error.response.data.message, 'Hata', 'error');
            });
        },

        getClasses() {
            axios.get('/classes/list').then(response => {
                this.classes = response.data.data;
            });
        },
        getUserRoles() {
            axios.get('/user-roles').then(response => {
                this.userRoles = response.data.data;
            }).catch(error => {
                this.$alert(error.response.data.message, 'HATA', 'error');
            });
        },
        update() {
            var data = this.getUserData();

            if (this.id) {
                axios.put('/users/' + +this.id, data).then(response => {
                    this.$alert('Kullanıcı başarıyla güncellendi..', 'İşlem Başarılı', 'success')
                }).catch((error) => {
                    this.$alert(error.response.data.message, 'Hata', 'error');
                });
            }

            if (!this.id) {
                if (this.myRole('parent')) {
                    this.role = 'student';
                }

                axios.post('/users', data).then(response => {
                    this.$alert(response.data.message, 'İşlem Başarılı', 'success');
                }).catch(error => {
                    this.$alert(error.response.data.message, 'Hata', 'error');
                });
            }
        },

        getUserData() {
            const data = {
                first_name: this.user.first_name,
                last_name: this.user.last_name,
                email: this.user.email,
                birth_date: this.user.birth_date,
                parent_id: this.user.parent_id,
                class_id: this.user.class_id,
                role: this.role,
                gender: this.gender,
                mobile_phone : this.user.mobile_phone
            };

            if (this.myRole('parent')) {
                data['parent_id'] = this.authUser.id;
                data['role'] = 'student';
            }

            return data;
        },

        checkForms(event) {

            if (event.target.value === 'student') {
                this.studentForm = true;
                this.teacherForm = false;
                return true;
            }
            if (event.target.value === 'teacher') {
                this.studentForm = false;
                this.teacherForm = true;
                return true;
            }

            this.studentForm = false;
        },


        getMe() {
            axios.get('/me').then(response => {
                this.authUser = response.data.data;
            }).catch(error => {
                this.$alert('Bir sorunla karşılaşıldı.', 'Hata', 'error');
            });
        },

        myRole(key) {
            return this.authUser.role.key === key ? true : false;
        }
    }
}
</script>

<style scoped>

</style>

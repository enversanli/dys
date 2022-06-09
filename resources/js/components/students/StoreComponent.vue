<template>
    <div class="w-full shadow-lg my-10 p-2.5">
        <div class="flex w-full">
            <div class="w-full">
                <label for="first_name">Adı</label>
                <input id="first_name" type="text"
                       v-model="student.first_name"
                       class="w-full my-5 border-gray-800 mr-5 border p-2 border-slate-400 rounded" name="first_name">
            </div>
            <div class="w-full">
                <label for="last_name">Soyadı</label>
                <input id="last_name" type="text" class="w-full my-5 ml-5 border p-2 border-slate-400 rounded"
                       v-model="student.last_name"
                       name="last_name">
            </div>
        </div>


        <div class="flex w-full">
            <div class="w-full">
                <label for="first_name">Doğum Tarihi</label>
                <input id="birth_date" type="date"
                       v-model="student.birth_date"
                       class="w-full my-5 border-gray-800 mr-5 border p-2 border-slate-400 rounded" name="first_name">
            </div>
            <div class="w-full">
                <label for="last_name">Sınıfı</label>
                <select class="w-full my-5 border-gray-800 ml-5 border p-2 border-slate-400 rounded" name="class_id"
                        v-model="student.class_id"
                        v-if="classes != null">
                    <option>Sınıf Seç</option>
                    <option v-for="row in classes" :value="row.id">{{ row.name }}</option>
                </select>
            </div>

            <div class="w-full">
                <label for="parent_email">Email</label>
                <input id="email" type="text"
                       v-model="student.email"
                       class="w-full my-5 border-gray-800 mr-5 border p-2 border-slate-400 rounded" name="parent_email">
            </div>
        </div>

        <div class="flex w-full">
            <div class="w-full">
                <label for="parent">Veli Durumu</label>
                <select class="w-full my-5 border-gray-800 ml-5 border p-2 border-slate-400 rounded" id="parent"
                        v-model="student.parent_id"
                        v-if="classes != null">
                    <option>Veli Seç</option>
                    <option v-for="row in parents" :value="row.id">{{ row.first_name }}</option>
                </select>
            </div>
            <div class="w-full">
            </div>
        </div>

        <hr>
        <hr>
        <hr>
        <div class="flex w-full hidden" id="parent_row">
        <h2 class="text-center my-10">Veli Bilgileri</h2>
            <div class="w-full">
                <label for="parent_first_name">Adı</label>
                <input id="parent_first_name" type="text"
                       class="w-full my-5 border-gray-800 mr-5 border p-2 border-slate-400 rounded"
                       name="parent_first_name">
            </div>
            <div class="w-full">
                <label for="parent_last_name">Soyadı</label>
                <input id="parent_last_name" type="text" class="w-full my-5 ml-5 border p-2 border-slate-400 rounded"
                       name="parent_last_name">
            </div>
        </div>

        <div class="flex w-full">
            <div class="w-full">
                <label for="parent_email">Email</label>
                <input id="parent_email" type="text"
                       class="w-full my-5 border-gray-800 mr-5 border p-2 border-slate-400 rounded" name="parent_email">
            </div>
            <div class="w-full">
                <label for="parent_phone">Soyadı</label>
                <input id="parent_phone" type="text" class="w-full my-5 ml-5 border p-2 border-slate-400 rounded"
                       name="parent_phone">
            </div>
        </div>

        <div>
            <button @click="storeStudent">Kaydet</button>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            student:{},
            classes: {},
            parents: {},
        }
    },
    name: "StoreComponent",

    mounted() {
        this.getClasses();
        this.getParents();
    },

    methods: {
        storeStudent(){

            const data =  {
              first_name : this.student.first_name,
              last_name : this.student.last_name,
              email : this.student.email,
              birth_date : this.student.birth_date,
              parent_id : this.student.parent_id,
              class_id : this.student.class_id,
            }

          axios.post('/students', data).then(response => {
                console.log(response);

                alert(response.data.message);
          });
        },

        getClasses() {
            axios.get('/classes/list').then(response => {
                this.classes = response.data.data
                console.log(this.classes);
            }).catch(error => {
                alert(error.response.data.message);
            });
        },

        getParents() {
            axios.get('/users?role=parent').then(response => {
            this.parents = response.data.data;
            });
        },


    }
}
</script>

<style scoped>

</style>

<template>
    <div class="w-full shadow-lg my-10 p-2.5">
        <div class="flex w-full">
            <div class="w-full">
                <label for="first_name">Adı</label>
                <input id="first_name" type="text"
                       class="w-full my-5 border-gray-800 mr-5 border p-2 border-slate-400 rounded" name="first_name">
            </div>
            <div class="w-full">
                <label for="last_name">Soyadı</label>
                <input id="last_name" type="text" class="w-full my-5 ml-5 border p-2 border-slate-400 rounded"
                       name="last_name">
            </div>
        </div>


        <div class="flex w-full">
            <div class="w-full">
                <label for="first_name">Doğum Tarihi</label>
                <input id="birth_date" type="date"
                       class="w-full my-5 border-gray-800 mr-5 border p-2 border-slate-400 rounded" name="first_name">
            </div>
            <div class="w-full">
                <label for="last_name">Sınıfı</label>
                <select class="w-full my-5 border-gray-800 ml-5 border p-2 border-slate-400 rounded" name="class_id"
                        v-if="classes != null">
                    <option>Sınıf Seç</option>
                    <option v-for="row in classes" :value="row.id">{{ row.name }}</option>
                </select>
            </div>
        </div>

        <div class="flex w-full">
            <div class="w-full">
                <label for="parent">Veli Durumu</label>
                <select class="w-full my-5 border-gray-800 ml-5 border p-2 border-slate-400 rounded" id="parent"
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

    </div>
</template>

<script>
export default {
    data() {
        return {

            classes: {},
            parents: {},
        }
    },
    name: "StoreStudentComponent",

    mounted() {
        this.getClasses();
        this.getParents();
    },

    methods: {
        storeStudent(){
          axios.post('students').then(response => {

          });
        },

        getClasses() {
            axios.get('/classes/list').then(response => {
                this.classes = response.data.data
                console.log(this.classes);
            });
        },

        getParents() {
            axios.get('/users?role=parent').then(response => {
            this.parents = response.data.data;
            });
        }
    }
}
</script>

<style scoped>

</style>

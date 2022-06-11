<template>
    <!-- This is an example component -->
    <div class="w-full mx-auto bg-white my-10">

            <div class="grid gap-12 mb-6 lg:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Sınıf Adı</label>
                    <input type="text" v-model="name" id="name" name="name" class="bg-gray-50 border border-gray-300 text-black-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Kartallar" required>
                </div>
            </div>
        <div class="grid gap-12 mb-6 lg:grid-cols-2">
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Açıklama</label>
            <textarea type="text" v-model="description" id="description" name="description" class="max-h-22 bg-gray-50 border border-gray-300 text-black-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Yeni başlayanlar">
            </textarea>
        </div>
        </div>
            <button type="submit" @click="store" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Oluştur</button>

        <p class="mt-5"><small>Sınıflar, öğrencilerin kayıt edilebilmesi için gereklidir.</small>
        </p>
    </div>
</template>

<script>
export default {
    name: "StoreClassComponent",
    data(){
        return{
            name:null,
            description:null,
        }
    },
    methods:{
        store(){
            var data = {
              name : this.name,
              description : this.description
            };

            axios.post('/classes', data).then(response => function () {
                this.$alert('Sınıf başarıyla eklendi.', 'İşlem Başarılı', 'success');
                this.name = null;
                this.description = null;
            }).catch(error => {
                this.$alert(error.response.data.message, 'Hata', 'error');
            })
        }
    }
}
</script>

<style scoped>

</style>

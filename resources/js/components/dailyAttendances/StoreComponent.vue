<template>
    <div class="w-full overflow-hidden rounded-lg shadow-xs my-10">
        <section class="py-1 bg-blueGray-50">
            <div class="w-full xl:w-10/12 mb-12 xl:mb-0 px-4 mx-auto mt-24">
                <div class="flex float-left">
                    <select class="p-2 rounded-full shadow-lg" @change="getUsers($event)" v-model="classId">
                        <option v-for="row in classes" :value="row.id"> {{ row.name}}</option>
                    </select>
                </div>

                <div class="ml-4 mb-4 flex float-left">
                    <select class="p-2 rounded-full shadow-lg" @change="getUserDailyAttendances($event)" v-model="year">
                        <option v-for="year in years" :value="year">{{ year }}</option>
                    </select>
                </div>

                <div class="ml-4 mb-4 flex float-left">
                    <select class="p-2 rounded-full shadow-lg" @change="getUserDailyAttendances($event)" v-model="month">
                        <option value="01">Ocak</option>
                        <option value="02">Şubat</option>
                        <option value="03">Mart</option>
                        <option value="04">Nisan</option>
                        <option value="05">Mayıs</option>
                        <option value="06">Haziran</option>
                        <option value="07">Temmuz</option>
                        <option value="08">Ağustos</option>
                        <option value="09">Eylül</option>
                        <option value="10">Ekim</option>
                        <option value="11">Kasım</option>
                        <option value="12">Aralık</option>
                    </select>
                </div>
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">
                    <div class="rounded-t mb-0 px-4 py-3 border-0">
                        <div class="flex flex-wrap items-center">
                            <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                <h3 class="font-semibold text-base text-blueGray-700">Günlük Katılım Kaydı</h3>
                            </div>
                            <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                                <button
                                    class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                    type="button">Hepsini İndir
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="block w-full overflow-x-auto">
                        <table class="items-center bg-transparent w-full border-collapse ">
                            <thead>
                            <tr>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Durum
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Öğrenci
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Not
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Durum İşaretle
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="user in users">
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    <span class="  px-3 py-1 mx-1 rounded-full bg-red-600"
                                          :class="[(user.at_lesson? 'bg-green-600' : 'bg-red-600')]"></span>
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ user.first_name + ' ' + user.last_name }}
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    <textarea class="border-2 max-h-16 max-w-full p-2" v-model="user.note"> </textarea>
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    <input type="checkbox" class="mx-auto my-auto align-self-center w-4 h-4 text-orange-500 bg-gray-100 rounded border-gray-300 focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" v-model="user.at_lesson">
                                </td>
                            </tr>
                            </tbody>
                        <button @click="store" class="float-right flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Kaydet</button>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

</template>

<script>
export default {
    name: "StoreComponent",
    props: ['authUser'],
    data() {
        return {
            users: {},
            classes: {},
            fullName: null,
            role: 'student',
            attendances: {},
            paginateData: null,
            userId: 0,
            classId: 0,
            year: null,
            month: 0

        }
    },
    mounted() {
        this.getUsers();
        this.getClasses();
    },

    computed: {
        years() {
            const year = new Date().getFullYear()
            return Array.from({length: year - 20}, (value, index) => 2000 + index)
        }
    },

    methods: {
        getUsers(page) {

            if (typeof page === 'undefined') {
                page = 1;
            }
            this.role = 'student';
            var per_page = 999;

            axios.get('/users?role=' + this.role + '&class_id=' + this.classId).then(response => {
                this.users = response.data.data;
            }).catch(error => {
                this.$alert(error.response.data.message, 'Hata', 'error')
            });
        },

        getClasses() {
            axios.get('/classes/list').then(response => {
                this.classes = response.data.data;
            });
        },

        getUserDailyAttendances() {
            if (this.year === null) {
                this.year = new Date().getFullYear();
            }

            var url = '/daily-attendances/list?user_id=' + this.userId + '&class_id=' + this.classId + '&year=' + this.year + '&month=' + this.month;

            axios.get(url).then(response => {
                this.attendances = response.data.data;
            }).catch(error => {
                this.$alert(error.response.data.message, 'Hata', 'error');
            });
        },

        store() {
            this.users.filter(function () {
                
            });

            this.$confirm("Bu işlemi gerçekleştirmek istediğinize emin misiniz ?", "UYARI", "question").then(() => {

                const data = {
                    'user_id': this.userId,
                    'year': year,
                    'month': month
                }

                axios.post('/attendances', data).then(response => {
                    this.$alert('İşlem başarıyla gerçekleştirildi', 'İşlem Başarılı!', 'success');

                    this.getUserDuesses();
                }).catch(error => {
                    this.$alert(error.response.data.message, 'Hata', 'error');
                });
            });
        },

        update(userId, duesId, status) {
            this.$confirm("Bu işlemi gerçekleştirmek istediğinize emin misiniz ?", "UYARI", "question").then(() => {

                const data = {
                    'user_id': this.userId,
                    'dues_id': duesId,
                    'status': status
                }

                axios.put('/attendances', data).then(response => {
                    this.$alert('İşlem başarıyla gerçekleştirildi', 'İşlem Başarılı!', 'success');

                    this.getUserDuesses();
                }).catch(error => {
                    this.$alert(error.response.data.message, 'Hata', 'error');
                });
            });
        },

    }
}
</script>

<style scoped>

</style>

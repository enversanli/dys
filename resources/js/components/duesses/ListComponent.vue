<template>
    <div class="w-full overflow-hidden rounded-lg shadow-xs my-10">
        <section class="py-1 bg-blueGray-50">
            <div class="w-full xl:w-10/12 mb-12 xl:mb-0 px-4 mx-auto mt-24">
                <div class="flex float-left">
                    <select class="p-2 rounded-full shadow-lg" @change="getUserDuesses($event)" v-model="userId">
                        <option v-for="user in users" :value="user.id"> {{ user.first_name + ' ' + user.last_name }}</option>
                    </select>
                </div>

                <div class="ml-4 mb-4 flex float-left">
                    <select class="p-2 rounded-full shadow-lg" @change="getUserDuesses($event)" v-model="year">
                        <option v-for="year in years" :value="year">{{ year }}</option>
                    </select>
                </div>
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">
                    <div class="rounded-t mb-0 px-4 py-3 border-0">
                        <div class="flex flex-wrap items-center">
                            <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                <h3 class="font-semibold text-base text-blueGray-700">Aidat Ödemeleri</h3>
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
                                    Yıl
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Ay
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Ücret
                                </th>

                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Onay
                                </th>

                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    İşlem
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="dues in duesses">
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    <span class="  px-3 py-1 mx-1 rounded-full bg-red-600"
                                          :class="[(dues.status === 'PAID' ? 'bg-green-600' : ''), (dues.status === 'WAITING_CONFIRMATION' ? 'bg-yellow-600' : '')]"></span>
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ dues.year }}
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ dues.month + ' - ' + dues.month_translated }}
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ dues.fee }}
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ dues.approved_at ? dues.approved_at : '-' }}
                                </td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    <i class="fas fa-arrow-up text-emerald-500 mr-4"></i>
                                    <button class="bg-blue-600 p-2 rounded-lg text-white" v-if="dues.status !== 'PAID'"
                                            @click="store(dues.user_id, dues.year, dues.month, 'PAID')">Ödendi İşaretle
                                    </button>
                                    <button class="bg-red-600 p-2 rounded-lg text-white" v-if="dues.status === 'PAID'"
                                            @click="update(dues.user_id, dues.id, 'CANCELLED')">İşlemi İptal Et
                                    </button>
                                </td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

</template>

<script>
export default {
    name: "ListComponent",
    data() {
        return {
            users: {},
            fullName: null,
            role: '',
            duesses: '',
            paginateData: null,
            userId: 0,
            year: null,
        }
    },
    mounted() {
        this.getUsers();
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

            axios.get('/users?role=' + this.role + '&page=' + page + '&per_page=' + per_page).then(response => {
                this.users = response.data.data;
                this.paginateData = response.data.pagination;

                console.log(this.paginateData.pagination);
            }).catch(error => {
                this.$alert(error.response.data.message, 'Hata', 'error')
            });
        },

        getUserDuesses() {
            if (this.year === null) {
                this.year = new Date().getFullYear();
            }

            axios.get('/duesses?user_id=' + this.userId + '&year=' + this.year).then(response => {
                this.duesses = response.data.data;
            }).catch(error => {
                this.$alert(error.response.data.message, 'Hata', 'error');
            });
        },

        store(userId, year, month, status) {
            this.$confirm("Bu işlemi gerçekleştirmek istediğinize emin misiniz ?", "UYARI", "question").then(() => {

                const data = {
                    'user_id': this.userId,
                    'year': year,
                    'month': month
                }

                axios.post('/duesses', data).then(response => {
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

                axios.put('/duesses', data).then(response => {
                    this.$alert('İşlem başarıyla gerçekleştirildi', 'İşlem Başarılı!', 'success');

                    this.getUserDuesses();
                }).catch(error => {
                    this.$alert(error.response.data.message, 'Hata', 'error');
                });
            });
        }
    }
}
</script>

<style scoped>

</style>

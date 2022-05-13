<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Giriş</div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Mail Adresi</label>

                            <div class="col-md-6">
                                <input v-model="email" id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="" required autocomplete="email" autofocus>
                                <small class="hidden">Mail Adresi Zorunludur</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Şifre</label>

                            <div class="col-md-6">
                                <input v-model="password" id="password" type="password" class="form-control is-invalid" name="password"
                                       required autocomplete="current-password">

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                    <label class="form-check-label" for="remember">
                                        Beni Hatırla
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" @click="login">
                                    Giriş
                                </button>

                                <a class="btn btn-link" href="/">
                                    Şifremi Unuttum
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            email: null,
            password: null
        }
    },

    mounted() {
        console.log('Component mounted.')
    },

    methods: {
        login(){

            axios.post('/api/login', {email: this.email, password: this.password}).then(response => {
               console.log(response.data);
            }).catch();
        }
    }
}
</script>

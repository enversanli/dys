<div>
    <h2>Dear {{$data->data->user->first_name}}</h2>
    <p>
        Your account has been created successfully.
        Welcome to our platform.
    </p>

    <p>Hesabınızı hemen doğrulamak için lütfen <a href="{{config('app.url')}}/verify?code={{$data->data->user->verification_code}}">Buraya</a> tıklayınız.</p>
</div>

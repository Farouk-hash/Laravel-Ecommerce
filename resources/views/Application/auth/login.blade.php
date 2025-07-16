<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{trans('index.login_title')}}</title>
  <link rel="stylesheet" href="{{asset('assets/css/auth/auth.css')}}">
  <!-- Font Awesome for eye icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>
  <div class="left"></div>
  <div class="right">
    <div class="form-container">
      <!-- Logo Image -->
      <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo" />
      <h2>{{trans('index.login_title')}}</h2>
      
      <form action="{{route('auth.login.submit')}}" method="POST">
        @csrf
        
        <label for="email">{{trans('index.email')}}</label>
        <input type="email" id="email" name="email" required />
        
        <label for="password">{{trans('index.password')}}</label>
        <div class="password-container">
          <input type="password" id="password" name="password" required />
          <i class="fas fa-eye password-toggle" id="togglePassword"></i>
        </div>
        
        <button type="submit">{{trans('index.login')}}</button>
      </form>
      
      <div class="footer-link">
        <p>{{trans('index.no_account')}}<a href="{{route('auth.signup')}}">{{trans('index.sign_up')}}</a></p>
      </div>
    </div>
  </div>

  <script src="{{asset('assets/js/toggle-password.js')}}"></script>

</body>
</html>
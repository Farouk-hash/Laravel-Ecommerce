<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign Up</title>
  <link rel="stylesheet" href="{{asset('assets/css/auth/auth.css')}}">
  <!-- Font Awesome for eye icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
</head>
<body>
  <div class="left"></div>
  
  <div class="right">
    <div class="form-container">
      <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo" />
      <h2>{{trans('index.create_account')}}</h2>
      
      <form action="{{ route('auth.signup.submit') }}" method="POST">
        @csrf
        
        <label for="name">{{trans('index.username')}}</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required />
        @error('name')
          <div class="error">{{ $message }}</div>
        @enderror
        
        <label for="email">{{trans('index.email')}}</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required />
        @error('email')
          <div class="error">{{ $message }}</div>
        @enderror
        
        <label for="password">{{trans('index.password')}}</label>
        <div class="password-container">
          <input type="password" id="password" name="password" required />
          <i class="fas fa-eye password-toggle" id="togglePassword"></i>
        </div>
        @error('password')
          <div class="error">{{ $message }}</div>
        @enderror
        
        <label for="password_confirmation">{{trans('index.confirm_password')}}</label>
        <div class="password-container">
          <input type="password" id="password_confirmation" name="password_confirmation" required />
          <i class="fas fa-eye password-toggle" id="togglePasswordConfirmation"></i>
        </div>
        @error('password_confirmation')
          <div class="error">{{ $message }}</div>
        @enderror
        
        <button type="submit">{{trans('index.signup')}}</button>
      </form>
      
      <div class="footer-link">
        {{trans('index.already_have_account')}} <a href="{{ route('auth.login') }}">{{trans('index.login')}}</a>
      </div>
    </div>
  </div>
  <script src="{{asset('assets/js/toggle-password.js')}}"></script>
</body>
</html>
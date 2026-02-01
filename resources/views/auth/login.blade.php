<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>SoundHub • Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


<link rel="stylesheet" href="{{ asset('css/auth.css') }}">


</head>
<body class="login-page">

  <div class="login-wrapper">
    <form method="POST" action="{{ route('login') }}" class="login-card">
      @csrf

      <div class="login-brand">
        <img src="{{ asset('sound-hub-icon.svg') }}" alt="SoundHub">
      </div>

      <div class="field">
        <label>Email</label>
        <input
          class="input @error('email') error @enderror"
          name="email"
          type="email"
          required
          value="{{ old('email') }}"
          placeholder="exemplo@email.com"
        >
        @error('email')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="field">
        <label>Password</label>
        <input
          name="password"
          type="password"
          required
          class="input @error('password') error @enderror"
          placeholder="••••••••"
        >
      </div>

      <button type="submit" class="register-button">
  Login
</button>

      <div class="register-link">
        Don't have an account? <a href="{{ route('register') }}">Register</a>
      </div>
    </form>
  </div>

</body>
</html>


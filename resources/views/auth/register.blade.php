<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>SoundHub • Registro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

</head>
<body class="register-page">

  <div class="register-wrapper">
    <form method="POST" action="{{ route('register') }}" class="register-card">
      @csrf

      <div class="register-brand">
        <img src="{{ asset('sound-hub-icon.svg') }}" alt="SoundHub">
      </div>

      <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Create Account</h2>

      <div class="field">
        <label>Name</label>
        <input
          class="input @error('name') error @enderror"
          name="name"
          type="text"
          required
          value="{{ old('name') }}"
          placeholder="João Silva"
        >
        @error('name')
          <span class="error-text">{{ $message }}</span>
        @enderror
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
          minlength="8"
        >
        @error('password')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="field">
        <label>Confirm Password</label>
        <input
          name="password_confirmation"
          type="password"
          required
          class="input"
          placeholder="••••••••"
          minlength="8"
        >
      </div>

      <button type="submit" class="register-button">
        Create Account
      </button>

      <div class="login-link">
        Already have an account? <a href="{{ route('login') }}">Login</a>
      </div>
    </form>
  </div>

</body>
</html>

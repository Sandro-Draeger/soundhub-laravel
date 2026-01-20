<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>SoundHub • Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="{{ asset('fe_master.css') }}">
</head>
<body class="login-page">

  <div class="login-wrapper">
    <form method="POST" action="{{ route('login.submit') }}" class="login-card">
      @csrf

      <div class="login-brand">
        <img src="{{ asset('sound-hub-icon.svg') }}" alt="SoundHub">
      </div>

      <div class="field">
        <label>Email</label>
        <input
        class="input"
          name="email"
          type="email"
          required
          value="{{ old('email') }}"
          class="@error('email') error @enderror"
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
          class="@error('password') error @enderror"
          placeholder="••••••••"
        >
      </div>

      <button type="submit" class="login-button">
        Entrar
      </button>
    </form>
  </div>

</body>
</html>

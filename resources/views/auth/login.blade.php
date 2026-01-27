<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>SoundHub • Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="{{ asset('fe_master.css') }}">
  <style>
    .login-page {
      background: black;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-wrapper {
      width: 100%;
      max-width: 400px;
      padding: 20px;
      background: black;
    }

    .login-card {
      background: white;
      border-radius: 12px;
      padding: 40px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .login-brand {
      text-align: center;
      margin-bottom: 30px;
    }

    .login-brand img {
      height: 60px;
    }

    .field {
      margin-bottom: 20px;
    }

    .field label {
      display: block;
      margin-bottom: 8px;
      color: black;
      font-weight: 600;
      font-size: 14px;
    }

    .input {
      width: 100%;
      padding: 12px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 14px;
      transition: border-color 0.3s;
    }

    .input:focus {
      outline: none;
      border-color: #667eea;
    }

    .input.error {
      border-color: #f44336;
    }

    .error-text {
      color: #f44336;
      font-size: 12px;
      margin-top: 5px;
      display: block;
    }

    .register-button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.2s;
    }

    .login-button:hover {
      transform: translateY(-2px);
    }

    .login-button:active {
      transform: translateY(0);
    }

    .register-link {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: #666;
    }

    .register-link a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
    }

    .register-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body class="login-page">

  <div class="login-wrapper">
    <form method="POST" action="{{ route('login') }}" class="login-card">
      @csrf

      <div class="login-brand">
        <img src="{{ asset('sound-hub-icon.svg') }}" alt="SoundHub">
      </div>

      <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Login</h2>

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
        <label>Senha</label>
        <input
          name="password"
          type="password"
          required
          class="input @error('password') error @enderror"
          placeholder="••••••••"
        >
      </div>

      <button type="submit" class="login-button">
        Entrar
      </button>

      <div class="register-link">
        Não tem conta? <a href="{{ route('register') }}">Cadastre-se</a>
      </div>
    </form>
  </div>

</body>
</html>


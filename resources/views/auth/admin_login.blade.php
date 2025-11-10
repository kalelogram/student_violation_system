<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | PRMSU Gate System</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      height: 100vh;
      background: linear-gradient(135deg, #004aad, #007bff);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
    }

    .container {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(14px);
      border-radius: 20px;
      padding: 50px 40px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      width: 360px;
      animation: fadeIn 0.8s ease;
      border: 1px solid rgba(255,255,255,0.2);
    }

    .logo {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      margin-bottom: 18px;
      object-fit: cover;
      border: none;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
      transition: transform 0.3s ease;
    }

    h2 {
      margin-bottom: 25px;
      font-size: 1.8rem;
      letter-spacing: 0.5px;
      font-weight: 600;
      color: #fff;
      text-shadow: 0 1px 5px rgba(0,0,0,0.3);
    }

    input[type="password"] {
      width: 100%;
      padding: 13px;
      border: none;
      border-radius: 10px;
      margin-bottom: 8px;
      font-size: 1rem;
      outline: none;
      background: rgba(255, 255, 255, 0.9);
      color: #004aad;
      text-align: center;
      transition: all 0.3s ease;
    }

    input[type="password"]:focus {
      background: #fff;
    }

    .error {
      color: #ff3f3fff;
      margin-bottom: 10px;
      font-size: 0.9rem;
      animation: fade 0.4s ease;
    }

    .button-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 10px;
      margin-top: 10px;
    }

    button {
      flex: 1;
      background: #f4c542;
      color: #004aad;
      border: none;
      border-radius: 12px;
      padding: 12px;
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    button:hover {
      transform: scale(1.05);
      background: #004aad;
      color: #fff;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .back-btn {
      flex: 0 0 45px;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 45px;
      border-radius: 50%;
      background: rgba(255,255,255,0.9);
      transition: all 0.3s ease;
    }

    .back-btn img {
      width: 26px;
      height: 26px;
      filter: invert(20%) sepia(90%) hue-rotate(190deg);
      transition: transform 0.3s ease;
    }

    .back-btn:hover {
      transform: scale(1.1);
      background: #f4c542;
    }

    .back-btn:hover img {
      transform: translateX(-2px);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(25px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="container">
    <form method="POST" action="{{ route('admin.login.submit') }}">
      @csrf
      <img src="{{ asset('logo.png') }}" alt="System Logo" class="logo">
      <h2>Admin Login</h2>

      <input type="password" name="password" placeholder="Enter password..." required>

      @if(session('error'))
        <p class="error">{{ session('error') }}</p>
      @endif

      <div class="button-row">
        <a href="{{ route('form.logout') }}" class="back-btn">
          <img src="{{ asset('arrows.png') }}" alt="Back">
        </a>
        <button type="submit">Login</button>
      </div>
    </form>
  </div>
</body>
</html>

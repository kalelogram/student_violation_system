<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Guard Login | PRMSU Gate System</title>
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
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 40px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      width: 350px;
      animation: fadeIn 1s ease;
    }

    h2 {
      margin-bottom: 25px;
      font-size: 1.6rem;
      letter-spacing: 0.5px;
    }

    input[type="password"] {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 10px;
      margin-bottom: 15px;
      font-size: 1rem;
      outline: none;
    }

    button {
      width: 100%;
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
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .error {
      color: #ff8080;
      margin-bottom: 10px;
      font-size: 0.9rem;
      animation: fade 0.4s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
   <form method="POST" action="{{ route('guard.login.submit') }}">
      @csrf
      <h2>Guard Login</h2>
      <input type="password" name="password" placeholder="Enter password..." required>
      <button type="submit">Login</button>
  </form>
  @if(session('error'))
      <p style="color:red;">{{ session('error') }}</p>
  @endif
</body>
</html>
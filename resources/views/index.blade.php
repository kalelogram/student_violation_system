<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Selection | PRMSU Gate System</title>
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
      overflow: hidden;
    }

    .container {
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 40px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      width: 350px;
      animation: fadeIn 1s ease;
    }

    h2 {
      margin-bottom: 25px;
      font-size: 1.6rem;
      letter-spacing: 0.5px;
    }

    .role-btn {
      display: block;
      width: 100%;
      background: white;
      color: #004aad;
      border: none;
      border-radius: 12px;
      padding: 14px;
      margin: 10px 0;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .role-btn:hover {
      transform: scale(1.05);
      background: #ffa200ff;
      color: white;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .footer {
      margin-top: 15px;
      font-size: 0.85rem;
      opacity: 0.8;
    }
  </style>
</head>

<body>
  <form method="POST" action="{{ route('select-role') }}" class="container">
    @csrf
    <h2>Welcome to PRMSU Gate System</h2>
    <button type="submit" name="role" value="admin" class="role-btn">Admin</button>
    <button type="submit" name="role" value="guard" class="role-btn">Guard</button>
    <p class="footer">President Ramon Magsaysay State University</p>
  </form>
</body>
</html>
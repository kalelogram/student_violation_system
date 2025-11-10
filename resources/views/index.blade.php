 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Selection | PRMSU Student Violation Record System</title>
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

    .logo {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      margin-bottom: 15px;
      box-shadow: 0 0 10px rgba(255,255,255,0.3);
    }

    h2 {
      margin-bottom: 25px;
      font-size: 1.6rem;
      letter-spacing: 0.5px;
    }

    .role-btn {
      display: block;
      width: 100%;
      text-align: center;
      background: white;
      color: #004aad;
      border: none;
      border-radius: 12px;
      padding: 14px;
      margin: 10px 0;
      font-size: 1rem;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .role-btn:hover {
      transform: scale(1.05);
      background: #ff8c00ff;
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
  
  <div class="container">
    <div class="PRMSU_logo">
      <img src="{{ asset('logo.png') }}" alt="System Logo" class="logo">

    </div>
        <h2>Welcome to PRMSU Student Violation Record System</h2>

        <a href="{{ route('admin.login') }}" class="role-btn">Admin</a>
        <a href="{{ route('guard.login') }}" class="role-btn">Guard</a>

        <p>President Ramon Magsaysay State University, Iba campus</p>
  </div>
</body>
</html>
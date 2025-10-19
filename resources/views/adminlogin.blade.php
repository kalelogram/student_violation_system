<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body { font-family: Poppins, sans-serif; background: #f4f4f9; text-align: center; padding: 100px; }
    input, button { padding: 10px; border-radius: 8px; border: 1px solid #ccc; }
  </style>
</head>
<body>
  <h2>Admin Login</h2>
  @if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
  @endif
  <form method="POST" action="{{ route('admin.login.post') }}">
    @csrf
    <input type="password" name="password" placeholder="Enter admin password">
    <button type="submit">Login</button>
  </form>
</body>
</html>
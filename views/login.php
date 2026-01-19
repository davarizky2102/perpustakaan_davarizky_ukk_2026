<!DOCTYPE html>
<html>
<head>
    <title>Login Perpustakaan</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: white; padding: 20px; border-radius: 8px; shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        input, select, button { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #333; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 style="text-align:center">Login Perpus</h2>
        <form action="proses_login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="siswa">Siswa</option>
            </select>
            <button type="submit" name="login">Masuk</button>
        </form>
    </div>
</body>
</html>
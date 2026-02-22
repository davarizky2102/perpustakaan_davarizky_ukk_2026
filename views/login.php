<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpus Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Dekorasi Lingkaran Background */
        body::before, body::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 0;
        }
        body::before { top: -100px; left: -100px; }
        body::after { bottom: -100px; right: -100px; }

        .container { z-index: 1; }

        .card {
            border: none;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: #1cc88a;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin: -90px auto 20px;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-label { font-weight: 600; color: #333; }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            background: #fdfdfd;
        }

        .form-control:focus {
            border-color: #1cc88a;
            box-shadow: 0 0 0 0.25 row rgba(28, 200, 138, 0.25);
        }

        .btn-primary {
            background: linear-gradient(45deg, #1cc88a, #13855c);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(28, 200, 138, 0.4);
        }

        .brand-text span { color: #1cc88a; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg mt-5">
                <div class="card-body p-5">
                    <div class="login-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    
                    <h3 class="text-center mb-1 fw-bold brand-text">PERPUS<span>KU</span></h3>
                    <p class="text-center text-muted small mb-4">Akses Koleksi Buku Digital</p>
                    
                    <form action="core/proseslogin.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label small text-uppercase">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-success"></i></span>
                                <input type="text" name="username" class="form-control border-start-0" placeholder="Username lu men" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small text-uppercase">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-success"></i></span>
                                <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg shadow">
                                LOGIN <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4 pt-2">
                        <p class="text-muted small mb-0">Belum punya akun?</p>
                        <a href="index.php?page=registrasi" class="text-success fw-bold text-decoration-none">Daftar Akun Baru Disini</a>
                    </div>
                </div>
            </div>
            <p class="text-center text-white-50 mt-4 small">&copy; 2026 Perpus Digital - Developed with Wit</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
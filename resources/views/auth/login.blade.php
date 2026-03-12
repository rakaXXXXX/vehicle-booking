<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Vehicle Booking System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
            margin: 20px;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .login-header h3 {
            margin: 0;
            font-weight: 300;
        }
        .login-header h2 {
            margin: 10px 0 0;
            font-weight: 600;
        }
        .login-body {
            padding: 40px;
            background: white;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 20px;
            height: auto;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #667eea;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            color: white;
            font-weight: 600;
            width: 100%;
            transition: transform 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            color: white;
        }
        .input-group-text {
            background: transparent;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .brand-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="brand-icon">
                <i class="fas fa-truck"></i>
            </div>
            <h3>Selamat Datang di</h3>
            <h2>Vehicle Booking System</h2>
            <p class="mt-3 mb-0">Nikel Mining Co.</p>
        </div>
        <div class="login-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

           <form method="POST" action="{{ route('login') }}">
    @csrf
    
    <div class="input-group">
        <span class="input-group-text bg-white">
            <i class="fas fa-envelope text-primary"></i>
        </span>
        <input type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               name="email" 
               placeholder="Email" 
               value="{{ old('email') }}"
               required 
               autofocus>
    </div>

    <div class="input-group">
        <span class="input-group-text bg-white">
            <i class="fas fa-lock text-primary"></i>
        </span>
        <input type="password" 
               class="form-control @error('password') is-invalid @enderror" 
               name="password" 
               placeholder="Password"
               required>
    </div>

    <div class="d-flex justify-content-between mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">
                Ingat Saya
            </label>
        </div>
        <a href="#" class="text-decoration-none">Lupa Password?</a>
    </div>

    <button type="submit" class="btn btn-login">
        <i class="fas fa-sign-in-alt me-2"></i> Login
    </button>
</form>

            <hr class="my-4">

            <div class="text-center">
                <p class="text-muted mb-2">Demo Akun:</p>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="p-2 border rounded">
                            <small><strong>Admin</strong></small><br>
                            <small class="text-muted">admin@nikel.co</small><br>
                            <small class="text-muted">admin123</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded">
                            <small><strong>Approver</strong></small><br>
                            <small class="text-muted">supervisor@nikel.co</small><br>
                            <small class="text-muted">supervisor123</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
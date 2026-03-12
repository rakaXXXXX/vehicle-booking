<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Debug Login</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('debug.login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="admin@nikel.co" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" value="admin123" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                            <a href="/" class="btn btn-secondary">Back to Main Login</a>
                        </form>

                        <hr>
                        <h5>Akun Testing:</h5>
                        <ul>
                            <li>admin@nikel.co / admin123</li>
                            <li>supervisor@nikel.co / supervisor123</li>
                            <li>manager@nikel.co / manager123</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
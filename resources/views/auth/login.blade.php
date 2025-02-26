<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
        }
        .card {
            border-radius: 12px;
            border: none;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        .form-label {
            font-weight: bold;
        }
        .alert {
            border-radius: 8px;
        }
        .btn-login {
            background-color: #1a237e;
            color: white;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-login:hover {
            background-color: #151b66;
            transform: scale(1.05);
        }
        .btn-login:active {
            transform: scale(0.98);
        }
        .text-center a {
            text-decoration: none;
            color: #1a237e;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .text-center a:hover {
            color: #151b66;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4">Login</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-login w-100">
                Login
            </button>
        </form>

        <p class="text-center mt-3">Don't have an account? <a href="{{ route('register.form') }}">Sign Up</a></p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $("#loginForm").submit(function (event) {
            let email = $("input[name='email']").val();
            let password = $("input[name='password']").val();

            if (email.trim() === "" || password.trim() === "") {
                alert("Please fill in all fields.");
                event.preventDefault();
            }
        });
    });
</script>

</body>
</html>
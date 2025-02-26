<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 450px;
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
        .btn-register {
            background-color: #1a237e;
            color: white;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-register:hover {
            background-color: #151b66;
            transform: scale(1.05);
        }
        .btn-register:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4">Register</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password:</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-register w-100">
                Register
            </button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $("#registerForm").submit(function (event) {
            let password = $("input[name='password']").val();
            let confirmPassword = $("input[name='password_confirmation']").val();

            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                event.preventDefault();
            }
        });
    });
</script>

</body>
</html>
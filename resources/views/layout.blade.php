<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link href="{{ asset('css\style.css') }}" rel="stylesheet">
</head>
<body>



    <nav class="navbar navbar-expand-lg">
        <div class="container">
        <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
</form>

        <button class="btn" id="darkModeToggle">
    <i class="fas fa-moon"></i>
</button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
            <div class="text-center mb-4">
    <img src="{{ asset('images/avatar.jpg') }}" class="rounded-circle" width="80" alt="User Avatar">
    
    @auth
        <h5 class="mt-2">{{ Auth::user()->name }}</h5>
        <small>{{ Auth::user()->email }}</small>
    @else
        <h5 class="mt-2">Guest</h5>
        <small>guest@example.com</small>
    @endauth
</div>
 <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('bookings.index') }}">
                        <i class="fas fa-ticket-alt me-2"></i> Booking
                        </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('trips.index') }}">
                        <i class="fas fa-plane me-2"></i> Trips
                    </a>
                </li>
                    </li><li class="nav-item">
                    <a class="nav-link" href="{{ route('ships.index') }}">
                            <i class="fas fa-ship me-2"></i> Shipments
                        </a>
                    <!-- </li><li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-plus me-2"></i> Users
                        </a>
                    </li>
                     -->
                </ul>
            </div>

            <div class="col-md-10 p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

</body>
</html>
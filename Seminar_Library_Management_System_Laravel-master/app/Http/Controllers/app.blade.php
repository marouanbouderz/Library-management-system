<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seminar Library System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fe; }
        .main-content { margin-left: 260px; min-height: 100vh; padding: 20px; transition: 0.3s; }
        .modern-sidebar { width: 260px; height: 100vh; background: #1e1e2d; position: fixed; left: 0; top: 0; padding: 1.5rem; display: flex; flex-direction: column; color: #fff; }
        .logo-circle { width: 40px; height: 40px; background: #6366f1; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 10px; }
        .nav-item { display: flex; align-items: center; gap: 15px; color: #7e8299; text-decoration: none; padding: 0.8rem 1rem; border-radius: 12px; margin-bottom: 0.5rem; }
        .nav-item:hover, .nav-item.active { background: #6366f1; color: #fff; text-decoration: none; }
        .section-title { color: #4b4b63; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; margin: 1.5rem 0 0.5rem 0.5rem; font-weight: 700; }
        .stat-card { transition: transform 0.3s; border-radius: 1.25rem !important; }
        .stat-card:hover { transform: translateY(-5px); }
        .icon-box { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
        .bg-light-primary { background: rgba(99, 102, 241, 0.1); }
        .bg-light-success { background: rgba(16, 185, 129, 0.1); }
        .bg-light-warning { background: rgba(245, 158, 11, 0.1); }
        .badge-light-success { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .badge-light-warning { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    </style>
</head>
<body>
    <aside class="modern-sidebar">
        <div class="d-flex align-items-center mb-5">
            <div class="logo-circle"><i class="fas fa-book-reader"></i></div>
            <span class="h5 mb-0 font-weight-bold">Seminar<span style="color:#6366f1">Lib</span></span>
        </div>
        <p class="section-title">Core</p>
        <a href="#" class="nav-item"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
        <p class="section-title">Management</p>
        <a href="{{ route('books.index') }}" class="nav-item active"><i class="fas fa-book"></i><span>Library Books</span></a>
        <a href="#" class="nav-item"><i class="fas fa-id-card"></i><span>Members</span></a>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>
</body>
</html>
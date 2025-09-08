<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'ระบบจำแนกพรรณไม้' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">🌱 Plant ID</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/identify') }}">อัปโหลดภาพ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/plants') }}">ฐานข้อมูลพรรณไม้</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/research') }}">ผลการวิจัย</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">เกี่ยวกับโครงการ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">ติดต่อเรา</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">© 2025 ระบบจำแนกพรรณไม้ | พัฒนาด้วย Laravel 11 + Bootstrap 5</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

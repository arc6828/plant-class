<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'ระบบจำแนกพรรณไม้' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        nav,
        .nav,
        .menu,
        button,
        .button,
        .btn,
        .price,
        .prompt,
        ._heading,
        .wp-block-pullquote blockquote,
        blockquote,
        label,
        legend,
        a,
        .card-header,
        th,
        li {
            font-family: "Prompt", "Open Sans script=all rev=1" !important;
        }
    </style>
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
                    <li class="nav-item"><a class="nav-link" href="{{ url('/research-results') }}">ผลการวิจัย</a></li>
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

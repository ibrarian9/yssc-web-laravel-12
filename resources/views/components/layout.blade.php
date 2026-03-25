<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Yayasan Seribu Satu Cita' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50">

    <nav class="bg-white py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2">
            <a href="/" class="flex items-center group">
                <img 
                    src="{{ (\App\Models\Profile::first())?->logo ? asset('storage/' . \App\Models\Profile::first()->logo) : asset('assets/logo.png') }}" 
                    alt="Logo Yayasan Seribu Satu Cita" 
                    class="h-12 md:h-14 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
                >
            </a>
        </div>
        
        <div class="hidden md:flex items-center gap-8 text-gray-700 font-medium">
            <a href="/" class="hover:text-foundation-yellow">Beranda</a>
            <a href="/program" class="hover:text-foundation-yellow">Program</a>
            <a href="/publikasi" class="hover:text-foundation-yellow">Publikasi</a>
            <a href="/login" class="font-bold text-emerald-800 border-l pl-8">Login</a>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-emerald-900 text-white py-10 text-center">
        <p>&copy; 2026 Yayasan Seribu Satu Cita. All rights reserved.</p>
    </footer>

</body>
</html>
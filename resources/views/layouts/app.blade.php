<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SIM-DATUN | Kejaksaan Negeri Banjarmasin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,900&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50/50 selection:bg-emerald-100 selection:text-emerald-900">
        <div class="min-h-screen relative">
            <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-emerald-500/5 to-transparent -z-10 pointer-events-none"></div>

            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white/70 backdrop-blur-md border-b border-gray-100 sticky top-[64px] z-40">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="relative">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>

            <footer class="py-10 text-center">
                <p class="text-[9px] font-black text-gray-300 uppercase tracking-[0.5em] italic">
                    Sistem Informasi Monitoring - Bidang DATUN Kejaksaan
                </p>
            </footer>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Efek Notifikasi Sukses
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'BERHASIL',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#ffffff',
                    color: '#0f172a',
                    iconColor: '#10b981',
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutDown animate__faster'
                    },
                    customClass: {
                        popup: 'rounded-[2rem] border-none shadow-2xl',
                        title: 'font-black tracking-tighter italic',
                        htmlContainer: 'font-bold text-slate-500 uppercase text-[10px] tracking-widest'
                    }
                });
            @endif

            // Efek Notifikasi Error (Jika ada validasi gagal)
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'OOPS...',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#0f172a',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        title: 'font-black tracking-tighter italic'
                    }
                });
            @endif
        </script>
    </body>
</html>
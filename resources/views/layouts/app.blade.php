<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#3b82f6">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Financial Management">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Financial Management">
    <meta name="msapplication-TileColor" content="#3b82f6">
    <meta name="msapplication-tap-highlight" content="no">

    <!-- PWA Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/icon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/icon-16x16.png">
    <link rel="apple-touch-icon" href="/icons/icon-152x152.png">
    <link rel="manifest" href="/manifest.json">

    <title>@yield('title', 'Financial Management')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e5e7eb;
            z-index: 50;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            padding-bottom: 4.5rem;
        }

        @media (min-width: 768px) {
            .bottom-nav {
                display: none;
            }

            .main-content {
                padding-bottom: 2rem;
            }
        }

        .nav-item {
            @apply flex flex-col items-center justify-center py-1 px-1 text-xs font-medium text-gray-600 hover:text-blue-600 transition-colors;
            min-height: 45px;
            font-size: 0.7rem;
        }

        .nav-item.active {
            @apply text-blue-600;
        }

        .nav-icon {
            @apply w-3.5 h-3.5 mb-0.5;
        }

        /* Modal Animations */
        .modal-overlay {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }

        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            transform: translateY(-50px) scale(0.9);
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }

        .modal-overlay.show .modal-content {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        /* Button hover effects */
        .btn-primary {
            @apply bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 transform hover:scale-105 active:scale-95;
        }

        .btn-secondary {
            @apply bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-all duration-200 transform hover:scale-105 active:scale-95;
        }

        /* PWA Install Prompt */
        .pwa-install-prompt {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            max-width: 320px;
            display: none;
        }

        .pwa-install-prompt.show {
            display: block;
        }

        @media (min-width: 768px) {
            .pwa-install-prompt {
                bottom: 20px;
                right: 20px;
                left: auto;
                transform: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- PWA Install Prompt -->
    <div id="pwaInstallPrompt" class="pwa-install-prompt">
        <div class="flex items-center space-x-3 mb-3">
            <img src="/icons/icon-72x72.png" alt="App Icon" class="w-12 h-12 rounded-lg">
            <div>
                <h3 class="font-semibold text-gray-900">Install Financial Management</h3>
                <p class="text-sm text-gray-600">Akses cepat dari home screen</p>
            </div>
        </div>
        <div class="flex space-x-2">
            <button id="pwaInstallBtn" class="btn-primary text-sm flex-1">Install</button>
            <button id="pwaDismissBtn" class="btn-secondary text-sm">Nanti</button>
        </div>
    </div>

    <!-- Header for desktop -->
    <header class="bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold">Financial Management</a>
                <nav class="flex space-x-6">
                    @if(session('user_id'))
                        <a href="{{ route('home') }}" class="hover:text-blue-200 transition-colors">Dashboard</a>
                        <a href="{{ route('transaksi.index') }}" class="hover:text-blue-200 transition-colors">Transaksi</a>
                        <a href="{{ route('investasi.index') }}" class="hover:text-blue-200 transition-colors">Investasi</a>
                        <a href="{{ route('sedekah.index') }}" class="hover:text-blue-200 transition-colors">Sedekah</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-blue-200 transition-colors">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-blue-200 transition-colors">Login</a>
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Bottom Navigation for Mobile -->
    @if(session('user_id'))
    <nav class="bottom-nav md:hidden">
        <div class="flex justify-around py-1">
            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('transaksi.index') }}" class="nav-item {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
                <span>Transaksi</span>
            </a>
            <a href="{{ route('investasi.index') }}" class="nav-item {{ request()->routeIs('investasi.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                <span>Investasi</span>
            </a>
            <a href="{{ route('sedekah.index') }}" class="nav-item {{ request()->routeIs('sedekah.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <span>Sedekah</span>
            </a>
            <button onclick="logout()" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Logout</span>
            </button>
        </div>
    </nav>
    @endif

    <script>
        // Setup CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // PWA Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('SW registered: ', registration);
                    })
                    .catch(function(registrationError) {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }

        // PWA Install Prompt
        let deferredPrompt;
        const pwaInstallPrompt = document.getElementById('pwaInstallPrompt');
        const pwaInstallBtn = document.getElementById('pwaInstallBtn');
        const pwaDismissBtn = document.getElementById('pwaDismissBtn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;

            // Show install prompt after 3 seconds
            setTimeout(() => {
                if (deferredPrompt) {
                    pwaInstallPrompt.classList.add('show');
                }
            }, 3000);
        });

        pwaInstallBtn.addEventListener('click', (e) => {
            pwaInstallPrompt.classList.remove('show');
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the install prompt');
                } else {
                    console.log('User dismissed the install prompt');
                }
                deferredPrompt = null;
            });
        });

        pwaDismissBtn.addEventListener('click', (e) => {
            pwaInstallPrompt.classList.remove('show');
        });

        // PWA Update Available
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.addEventListener('controllerchange', () => {
                // New service worker activated, reload page
                window.location.reload();
            });
        }

        function logout() {
            Swal.fire({
                title: 'Logout',
                text: 'Apakah Anda yakin ingin logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("logout") }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Show success message
        function showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        }

        // Show error message
        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: message
            });
        }

        // Confirm delete
        function confirmDelete(url, message = 'Apakah Anda yakin ingin menghapus data ini?') {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(response) {
                            showSuccess('Data berhasil dihapus');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr) {
                            showError('Gagal menghapus data');
                        }
                    });
                }
            });
        }

        // Modal functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('show');
                // Focus first input
                const firstInput = modal.querySelector('input, select, textarea');
                if (firstInput) {
                    setTimeout(() => firstInput.focus(), 300);
                }
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }
    </script>

    @yield('scripts')
</body>
</html>

@extends('layouts.app')

@section('title', 'Dashboard - Financial Management')

@section('content')
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Keuangan</h1>
                <p class="text-gray-600 mt-1">Ringkasan keuangan bulanan Anda</p>
            </div>
            <button id="filterToggle" onclick="toggleFilter()" class="btn-secondary p-2 rounded-full">
                <svg id="filterIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Filter Form -->
    <div id="filterSection" class="bg-white rounded-lg shadow-md p-6 mb-8 hidden transform transition-all duration-300 ease-in-out">
        <form method="GET" action="{{ route('home') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-48">
                <label for="month" class="block text-sm font-medium text-gray-700 mb-2">Bulan:</label>
                <select name="month" id="month" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="flex-1 min-w-48">
                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Tahun:</label>
                <select name="year" id="year" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                    </svg>
                    Filter
                </button>
                <button type="button" onclick="resetFilter()" class="btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset
                </button>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl font-bold text-green-600 mb-2">
                Rp {{ number_format($pendapatan, 0, ',', '.') }}
            </div>
            <div class="text-gray-600 text-sm">Total Pendapatan</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl font-bold text-red-600 mb-2">
                Rp {{ number_format($pengeluaran, 0, ',', '.') }}
            </div>
            <div class="text-gray-600 text-sm">Total Pengeluaran</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl font-bold text-yellow-600 mb-2">
                Rp {{ number_format($investasi, 0, ',', '.') }}
            </div>
            <div class="text-gray-600 text-sm">Total Investasi</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl font-bold text-blue-600 mb-2">
                Rp {{ number_format($sedekah, 0, ',', '.') }}
            </div>
            <div class="text-gray-600 text-sm">Total Sedekah</div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Kategori</h3>
            <div class="relative" style="height: 300px;">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 md:p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tren Bulanan {{ $year }}</h3>
            <div class="relative" style="height: 300px;">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Login Button at Bottom -->
    @if(!session('user_id'))
        <div class="text-center py-8">
            <a href="{{ route('login') }}" class="btn-primary inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Login untuk Mengelola Keuangan
            </a>
        </div>
    @endif

    <script>
        // Filter toggle functionality
        function toggleFilter() {
            const filterSection = document.getElementById('filterSection');
            const filterIcon = document.getElementById('filterIcon');

            if (filterSection.classList.contains('hidden')) {
                // Show filter
                filterSection.classList.remove('hidden');
                filterSection.classList.add('opacity-100', 'translate-y-0');
                filterSection.classList.remove('opacity-0', '-translate-y-4');
                filterIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
            } else {
                // Hide filter
                filterSection.classList.add('opacity-0', '-translate-y-4');
                setTimeout(() => {
                    filterSection.classList.add('hidden');
                    filterSection.classList.remove('opacity-100', 'translate-y-0');
                }, 300);
                filterIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>';
            }
        }

        // Reset filter functionality
        function resetFilter() {
            const currentDate = new Date();
            const currentMonth = currentDate.getMonth() + 1;
            const currentYear = currentDate.getFullYear();

            document.getElementById('month').value = currentMonth;
            document.getElementById('year').value = currentYear;

            // Submit form automatically
            document.querySelector('#filterSection form').submit();
        }

        // Mobile-friendly chart configuration
        const isMobile = window.innerWidth < 768;
        const chartFontSize = isMobile ? 10 : 12;
        const chartPadding = isMobile ? 10 : 20;

        // Pie Chart with mobile optimization
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut', // Changed to doughnut for better mobile view
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    data: @json($chartData['data']),
                    backgroundColor: @json($chartData['colors']),
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: isMobile ? 'bottom' : 'right',
                        labels: {
                            padding: chartPadding,
                            font: {
                                size: chartFontSize
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: chartFontSize
                        },
                        bodyFont: {
                            size: chartFontSize
                        },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: Rp ${value.toLocaleString('id-ID')} (${percentage}%)`;
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'xy',
                    intersect: false
                }
            }
        });

        // Line Chart with mobile optimization
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan',
                    data: @json($monthlyData['pendapatan']),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#28a745',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: isMobile ? 4 : 6,
                    pointHoverRadius: isMobile ? 6 : 8,
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Pengeluaran',
                    data: @json($monthlyData['pengeluaran']),
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#dc3545',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: isMobile ? 4 : 6,
                    pointHoverRadius: isMobile ? 6 : 8,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: !isMobile,
                            text: 'Bulan'
                        },
                        ticks: {
                            font: {
                                size: chartFontSize
                            }
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: !isMobile,
                            text: 'Jumlah (Rp)'
                        },
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: chartFontSize
                            },
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                } else if (value >= 1000) {
                                    return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            padding: chartPadding,
                            font: {
                                size: chartFontSize
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: chartFontSize
                        },
                        bodyFont: {
                            size: chartFontSize
                        },
                        callbacks: {
                            label: function(context) {
                                const label = context.dataset.label || '';
                                const value = context.parsed.y;
                                return `${label}: Rp ${value.toLocaleString('id-ID')}`;
                            }
                        }
                    }
                }
            }
        });

        // Handle window resize for responsive charts
        window.addEventListener('resize', function() {
            const newIsMobile = window.innerWidth < 768;
            if (newIsMobile !== isMobile) {
                location.reload(); // Reload to update chart configurations
            }
        });
    </script>
@endsection

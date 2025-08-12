<x-filament::page>
    <style>
        body {
            background: white;
            min-height: 100vh;
        }
        
        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 24px;
            color: white;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 50%);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }
        
        .stats-card:hover::before {
            background: linear-gradient(45deg, rgba(255,255,255,0.2) 0%, transparent 50%);
        }
        
        .stats-card.variant-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .stats-card.variant-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stats-card.variant-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .stats-card.variant-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .stats-card.variant-5 {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .stats-card.variant-6 {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        }
        
        .chart-container {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .table-container {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .section-title {
            font-size: 28px;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .period-tabs {
            display: flex;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 15px;
            padding: 8px;
            margin-bottom: 25px;
            backdrop-filter: blur(10px);
        }
        
        .tab-button {
            flex: 1;
            padding: 12px 20px;
            border: none;
            background: transparent;
            border-radius: 10px;
            font-weight: 600;
            color: #667eea;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .tab-button.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            transform: translateY(-2px);
        }
        
        .tab-button:hover:not(.active) {
            background: rgba(102, 126, 234, 0.2);
            transform: translateY(-1px);
        }
        
        .stats-period {
            display: none;
        }
        
        .stats-period.active {
            display: block;
            animation: fadeInUp 0.5s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .stats-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }
        
        .stats-value {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .export-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        
        .export-btn {
            padding: 12px 25px;
            border: none;
            border-radius: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        .export-btn.pdf {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
        }
        
        .export-btn.excel {
            background: linear-gradient(135deg, #26de81 0%, #20bf6b 100%);
            color: white;
        }
        
        .export-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .table-modern {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .table-modern thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            font-weight: 600;
            text-align: left;
            border: none;
        }
        
        .table-modern tbody tr {
            transition: all 0.3s ease;
        }
        
        .table-modern tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
        }
        
        .table-modern tbody td {
            padding: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .chart-wrapper {
            position: relative;
            height: 400px;
            margin: 20px 0;
        }
    </style>

    <div class="dashboard-container">
        <!-- Header Dashboard -->
        <div class="text-center mb-8">
            <h1 class="section-title">🏪 Dashboard Penjualan Kedai CKCK</h1>
            <p class="text-gray-600">Pantau performa penjualan dan statistik bisnis Anda</p>
        </div>

        <!-- Tab Navigation -->
        <div class="period-tabs">
            <button class="tab-button active" onclick="showPeriod('harian')" id="tab-harian">
                📅 Laporan Harian
            </button>
            <button class="tab-button" onclick="showPeriod('mingguan')" id="tab-mingguan">
                📊 Laporan Mingguan
            </button>
            <button class="tab-button" onclick="showPeriod('bulanan')" id="tab-bulanan">
                📈 Laporan Bulanan
            </button>
            <button class="tab-button" onclick="showPeriod('keseluruhan')" id="tab-keseluruhan">
                📊 Keseluruhan
            </button>
        </div>

        <!-- Export Buttons -->
        <div class="export-buttons">
            <a href="#" class="export-btn pdf">
                📄 Export PDF
            </a>
            <a href="#" class="export-btn excel">
                📊 Export Excel
            </a>
        </div>

        <!-- Laporan Harian -->
        <div id="stats-harian" class="stats-period active">
            <h2 class="section-title">📅 Laporan Harian - {{ date('d F Y') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="stats-card variant-1">
                    <div class="stats-icon">📋</div>
                    <div class="stats-value">{{ $this->totalOrderHari }}</div>
                    <div class="stats-label">Pesanan Hari Ini</div>
                </div>
                <div class="stats-card variant-2">
                    <div class="stats-icon">💰</div>
                    <div class="stats-value">Rp {{ number_format($this->totalPendapatanHari) }}</div>
                    <div class="stats-label">Pendapatan Hari Ini</div>
                </div>
                <div class="stats-card variant-3">
                    <div class="stats-icon">✅</div>
                    <div class="stats-value">{{ $this->orderSelesaiHari }}</div>
                    <div class="stats-label">Pesanan Selesai</div>
                </div>
            </div>
        </div>

        <!-- Laporan Mingguan -->
        <div id="stats-mingguan" class="stats-period">
            <h2 class="section-title">📊 Laporan Mingguan - {{ date('d') }} - {{ date('d M Y', strtotime('+6 days')) }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="stats-card variant-4">
                    <div class="stats-icon">📊</div>
                    <div class="stats-value">{{ $this->totalOrderMinggu }}</div>
                    <div class="stats-label">Pesanan Minggu Ini</div>
                </div>
                <div class="stats-card variant-5">
                    <div class="stats-icon">💎</div>
                    <div class="stats-value">Rp {{ number_format($this->totalPendapatanMinggu) }}</div>
                    <div class="stats-label">Pendapatan Minggu Ini</div>
                </div>
                <div class="stats-card variant-6">
                    <div class="stats-icon">🎯</div>
                    <div class="stats-value">{{ $this->orderSelesaiMinggu }}</div>
                    <div class="stats-label">Pesanan Selesai</div>
                </div>
            </div>
        </div>

        <!-- Laporan Bulanan -->
        <div id="stats-bulanan" class="stats-period">
            <h2 class="section-title">📈 Laporan Bulanan - {{ date('F Y') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="stats-card variant-1">
                    <div class="stats-icon">📈</div>
                    <div class="stats-value">{{ $this->totalOrderBulan }}</div>
                    <div class="stats-label">Pesanan Bulan Ini</div>
                </div>
                <div class="stats-card variant-2">
                    <div class="stats-icon">🚀</div>
                    <div class="stats-value">Rp {{ number_format($this->totalPendapatanBulan) }}</div>
                    <div class="stats-label">Pendapatan Bulan Ini</div>
                </div>
                <div class="stats-card variant-3">
                    <div class="stats-icon">🏆</div>
                    <div class="stats-value">{{ $this->orderSelesaiBulan }}</div>
                    <div class="stats-label">Pesanan Selesai</div>
                </div>
            </div>
        </div>

        <!-- Laporan Keseluruhan -->
        <div id="stats-keseluruhan" class="stats-period">
            <h2 class="section-title">📊 Laporan Keseluruhan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="stats-card variant-4">
                    <div class="stats-icon">📋</div>
                    <div class="stats-value">{{ $this->totalOrder }}</div>
                    <div class="stats-label">Total Pesanan</div>
                </div>
                <div class="stats-card variant-5">
                    <div class="stats-icon">💰</div>
                    <div class="stats-value">Rp {{ number_format($this->totalPendapatan) }}</div>
                    <div class="stats-label">Total Pendapatan</div>
                </div>
                <div class="stats-card variant-6">
                    <div class="stats-icon">✅</div>
                    <div class="stats-value">{{ $this->orderSelesai }}</div>
                    <div class="stats-label">Total Selesai</div>
                </div>
            </div>
        </div>

        <!-- Chart Penjualan -->
        <div class="chart-container">
            <h2 class="section-title">📈 Grafik Penjualan 7 Hari Terakhir</h2>
            <div class="chart-wrapper">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Tabel Laporan Detail -->
        <div class="table-container">
            <h2 class="section-title">📋 Laporan Penjualan Detail</h2>
            
            <!-- Export Buttons untuk tabel -->
            <div class="export-buttons">
                <a href="#" class="export-btn pdf" onclick="exportTableToPDF()">
                    📄 Export PDF
                </a>
                <a href="#" class="export-btn excel" onclick="exportTableToExcel()">
                    📊 Export Excel
                </a>
            </div>

            <!-- Filter tanggal -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mb-6 p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-200">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">📅 Dari Tanggal:</label>
                    <input type="date" id="minDate" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-purple-500 focus:outline-none transition-colors">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">📅 Sampai Tanggal:</label>
                    <input type="date" id="maxDate" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-purple-500 focus:outline-none transition-colors">
                </div>
                <button id="resetFilter" class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-3 rounded-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-300 transform hover:scale-105 mt-6 md:mt-0">
                    🔄 Reset Filter
                </button>
            </div>

            <div class="overflow-x-auto rounded-2xl">
                <table id="salesTable" class="table-modern">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Tanggal</th>
                            <th>No. Meja</th>
                            <th>Nama Customer</th>
                            <th>Total Harga</th>
                            <th>Status Makanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Order::orderBy('created_at', 'desc')->get() as $order)
                        <tr>
                            <td class="font-bold text-purple-600">#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="font-semibold">{{ $order->nomor_meja }}</td>
                            <td>{{ $order->customer_name ?? 'Guest' }}</td>
                            <td class="font-bold text-green-600">Rp {{ number_format($order->total_harga) }}</td>
                            <td>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($order->status_makanan == 'pesanan selesai') bg-green-100 text-green-800
                                    @elseif($order->status_makanan == 'sedang dimasak') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($order->status_makanan) }}
                                </span>
                            </td>
                           
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script Chart.js dan DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script>
        // Inisialisasi Chart.js
        const ctx = document.getElementById('salesChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
        gradient.addColorStop(1, 'rgba(102, 126, 234, 0.1)');

        // Data penjualan untuk chart
        const salesData = [
            {date: '2025-08-07', count: 6, total: 180000},
            {date: '2025-08-08', count: 9, total: 270000},
            {date: '2025-08-09', count: 7, total: 210000},
            {date: '2025-08-10', count: 12, total: 360000},
            {date: '2025-08-11', count: 3, total: 90000},
            {date: '2025-08-12', count: 8, total: 240000},
            {date: '2025-08-13', count: 5, total: 150000}
        ];

        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: salesData.map(item => {
                    const date = new Date(item.date);
                    return date.toLocaleDateString('id-ID', { 
                        day: 'numeric', 
                        month: 'short' 
                    });
                }),
                datasets: [{
                    label: '💰 Pendapatan (Rp)',
                    data: salesData.map(item => item.total),
                    backgroundColor: gradient,
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(102, 126, 234, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 8,
                    pointHoverRadius: 12
                }, {
                    label: '📋 Jumlah Pesanan',
                    data: salesData.map(item => item.count),
                    backgroundColor: 'rgba(244, 63, 94, 0.1)',
                    borderColor: 'rgba(244, 63, 94, 1)',
                    borderWidth: 4,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(244, 63, 94, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 8,
                    pointHoverRadius: 12,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(102, 126, 234, 1)',
                        borderWidth: 2,
                        cornerRadius: 15,
                        titleFont: {
                            size: 16,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14
                        },
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return '💰 Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                                } else {
                                    return '📋 Pesanan: ' + context.parsed.y + ' order';
                                }
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                weight: 'bold',
                                size: 12
                            },
                            color: '#666'
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            },
                            font: {
                                weight: 'bold',
                                size: 11
                            },
                            color: '#666'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false,
                        },
                        ticks: {
                            callback: function(value) {
                                return value + ' order';
                            },
                            font: {
                                weight: 'bold',
                                size: 11
                            },
                            color: '#666'
                        }
                    }
                }
            }
        });

        // Fungsi untuk mengganti periode laporan
        function showPeriod(period) {
            // Sembunyikan semua periode
            document.querySelectorAll('.stats-period').forEach(el => {
                el.classList.remove('active');
            });
            
            // Tampilkan periode yang dipilih
            document.getElementById('stats-' + period).classList.add('active');
            
            // Update status tab
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById('tab-' + period).classList.add('active');
        }

        // Inisialisasi DataTables
        $(document).ready(function() {
            $('#salesTable').DataTable({
                responsive: true,
                pageLength: 25,
                order: [[1, 'desc']],
                language: {
                    search: "🔍 Pencarian:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data tersedia",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Tidak ada data dalam tabel"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '📊 Export Excel',
                        className: 'export-btn excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '📄 Export PDF',
                        className: 'export-btn pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths = ['15%', '20%', '15%', '20%', '15%', '15%'];
                            doc.styles.tableHeader.fillColor = '#667eea';
                        }
                    }
                ]
            });

            // Custom date range filter
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = $('#minDate').val();
                    var max = $('#maxDate').val();
                    var date = data[1]; // Kolom tanggal (index 1)
                    
                    if (!min && !max) return true;
                    
                    // Convert date format from d/m/Y H:i to comparable format
                    var dateParts = date.split(' ')[0].split('/');
                    var dateFormatted = dateParts[2] + '-' + dateParts[1].padStart(2, '0') + '-' + dateParts[0].padStart(2, '0');
                    
                    if (min && !max) {
                        return dateFormatted >= min;
                    } else if (!min && max) {
                        return dateFormatted <= max;
                    } else if (min && max) {
                        return dateFormatted >= min && dateFormatted <= max;
                    }
                    
                    return true;
                }
            );

            // Date filter events
            $('#minDate, #maxDate').change(function() {
                $('#salesTable').DataTable().draw();
            });

            // Reset filter
            $('#resetFilter').click(function() {
                $('#minDate, #maxDate').val('');
                $('#salesTable').DataTable().draw();
            });
        });

        // Fungsi export manual
        function exportTableToPDF() {
            $('#salesTable').DataTable().button('.buttons-pdf').trigger();
        }

        function exportTableToExcel() {
            $('#salesTable').DataTable().button('.buttons-excel').trigger();
        }

        // Animasi loading saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stats-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });

            // Set periode harian sebagai default
            showPeriod('harian');
        });

        // Update waktu real-time (opsional)
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }

        // Update setiap detik
        setInterval(updateTime, 1000);
    </script>

    <style>
        /* Custom DataTables styling */
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            margin-left: 0.5rem;
            transition: border-color 0.3s ease;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.25rem 0.5rem;
            margin: 0 0.5rem;
        }

        .dataTables_wrapper .dataTables_info {
            padding-top: 1rem;
            font-weight: 600;
            color: #4b5563;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.5rem;
            margin: 0 0.25rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            border: none;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #667eea 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #4c51bf 0%, #553c9a 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.6);
        }

        .dt-buttons {
            margin-bottom: 1rem;
        }

        .dt-buttons .dt-button {
            margin-right: 0.5rem;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .dt-buttons .dt-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</x-filament::page>

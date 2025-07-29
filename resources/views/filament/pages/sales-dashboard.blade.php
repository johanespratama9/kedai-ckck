<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-gray-500 text-sm">Total Order</h2>
            <p class="text-2xl font-bold">{{ $this->totalOrder }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-gray-500 text-sm">Total Pendapatan</h2>
            <p class="text-2xl font-bold">Rp {{ number_format($this->totalPendapatan) }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-gray-500 text-sm">Order Selesai</h2>
            <p class="text-2xl font-bold">{{ $this->orderSelesai }}</p>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow mb-6">
        <h2 class="text-lg font-semibold mb-2">Grafik Penjualan</h2>
        <canvas id="salesChart"></canvas>
    </div>

    <h2 class="text-lg font-semibold mb-4">Laporan Penjualan</h2>

    {{-- Filter tanggal --}}
    <div class="flex flex-col md:flex-row items-start md:items-center gap-2 mb-4">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Dari Tanggal:</label>
            <input type="date" id="minDate" class="border rounded px-2 py-1">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Sampai Tanggal:</label>
            <input type="date" id="maxDate" class="border rounded px-2 py-1">
        </div>
        <button id="resetFilter" class="bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600 mt-5">Reset Filter</button>
    </div>

    <div class="overflow-x-auto">
        <table id="salesTable" class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Order ID</th>
                    <th class="px-4 py-2">Meja</th>
                    <th class="px-4 py-2">Total Harga</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach (\App\Models\Order::latest()->get() as $order)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->nomor_meja }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($order->total_harga) }}</td>
                        <td class="px-4 py-2">{{ $order->status }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Script Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.7)');
        gradient.addColorStop(1, 'rgba(79, 70, 229, 0.1)');

        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(\App\Models\Order::orderBy('created_at')->pluck('created_at')->map->format('d M')) !!},
                datasets: [{
                    label: 'Total Penjualan',
                    data: {!! json_encode(\App\Models\Order::orderBy('created_at')->pluck('total_harga')) !!},
                    backgroundColor: gradient
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

    {{-- DataTables + Buttons --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#salesTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excelHtml5', title: 'Laporan Penjualan' },
                    { extend: 'pdfHtml5', title: 'Laporan Penjualan' },
                    { extend: 'print', title: 'Laporan Penjualan' }
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: { first: "Pertama", last: "Terakhir", next: "Berikutnya", previous: "Sebelumnya" },
                    zeroRecords: "Data tidak ditemukan"
                }
            });

            // Custom filter by date range
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = $('#minDate').val();
                    var max = $('#maxDate').val();
                    var tanggal = data[4]; // kolom tanggal

                    if (min && tanggal < min) return false;
                    if (max && tanggal > max) return false;
                    return true;
                }
            );

            // Otomatis filter saat ganti tanggal
            $('#minDate, #maxDate').change(function() {
                table.draw();
            });

            // Reset filter
            $('#resetFilter').click(function() {
                $('#minDate').val('');
                $('#maxDate').val('');
                table.draw();
            });
        });
    </script>
</x-filament::page>

<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "plant_net");

// Query untuk mengambil data dari tabel
$query = "SELECT MONTH(order_time_product) AS Month,SUM(total_harga_produk) AS PendapatanBulanan FROM pesananproduk GROUP BY MONTH(order_time_product)";
$res = mysqli_query($conn, $query);

// Inisialisasi array untuk menyimpan bulan dan total penjualan
$bulanData = array();
$totalData = array();

// Mengambil data dari hasil query dan menyimpannya ke dalam array
while ($data = mysqli_fetch_array($res)) {
    $bulanData[] = $data['Month'];
    $totalData[] = $data['PendapatanBulanan'];
}

// Menutup koneksi ke database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Area Chart</title>
    <!-- Load library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="lineChart"></canvas>

    <script>
        // Mengambil data dari PHP dan menyimpannya dalam variabel JavaScript
        var bulanData = <?php echo json_encode($bulanData); ?>;
        var totalData = <?php echo json_encode($totalData); ?>;

        // Membuat chart menggunakan Chart.js
        var ctx = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: bulanData,
                datasets: [{
                    label: 'Total Sales',
                    data: totalData,
                    fill: false,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

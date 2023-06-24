<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "plant_net");

// Query untuk mengambil data dari tabel
$query = "SELECT MONTH(order_time_product) AS Month, SUM(jumlah_pesanan_produk) AS Total_Sales FROM pesananproduk GROUP BY MONTH(order_time_product)";
$res = mysqli_query($conn, $query);

// Inisialisasi array untuk menyimpan bulan dan total penjualan
$bulanData = array();
$totalData = array();

// Mengambil data dari hasil query dan menyimpannya ke dalam array
while ($data = mysqli_fetch_array($res)) {
    $bulanData[] = $data['Month'];
    $totalData[] = $data['Total_Sales'];
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
    <canvas id="areaChart"></canvas>

    <script>
        // Mengambil data dari PHP dan menyimpannya dalam variabel JavaScript
        var bulanData = <?php echo json_encode($bulanData); ?>;
        var totalData = <?php echo json_encode($totalData); ?>;

        // Membuat chart menggunakan Chart.js
        var ctx = document.getElementById('areaChart').getContext('2d');
        var areaChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: bulanData,
                datasets: [{
                    label: 'Total Sales',
                    data: totalData,
                    fill: true,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
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

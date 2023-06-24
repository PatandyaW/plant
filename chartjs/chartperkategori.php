<?php
// Buat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "plant_net");

// Query SQL
$query = "
    SELECT
        CASE 
            WHEN bulan_referensi.bulan = 1 THEN 'Januari'
            WHEN bulan_referensi.bulan = 2 THEN 'Februari'
            WHEN bulan_referensi.bulan = 3 THEN 'Maret'
            WHEN bulan_referensi.bulan = 4 THEN 'April'
            WHEN bulan_referensi.bulan = 5 THEN 'Mei'
            WHEN bulan_referensi.bulan = 6 THEN 'Juni'
            WHEN bulan_referensi.bulan = 7 THEN 'Juli'
            WHEN bulan_referensi.bulan = 8 THEN 'Agustus'
            WHEN bulan_referensi.bulan = 9 THEN 'September'
            WHEN bulan_referensi.bulan = 10 THEN 'Oktober'
            WHEN bulan_referensi.bulan = 11 THEN 'November'
            WHEN bulan_referensi.bulan = 12 THEN 'Desember'
        END AS bulan,
        COALESCE(SUM(pesananproduk.jumlah_pesanan_produk), 0) AS total_penjualan
    FROM (
        SELECT 1 AS bulan
        UNION SELECT 2
        UNION SELECT 3
        UNION SELECT 4
        UNION SELECT 5
        UNION SELECT 6
        UNION SELECT 7
        UNION SELECT 8
        UNION SELECT 9
        UNION SELECT 10
        UNION SELECT 11
        UNION SELECT 12
    ) AS bulan_referensi
    LEFT JOIN pesananproduk ON MONTH(pesananproduk.order_time_product) = bulan_referensi.bulan
        AND pesananproduk.produk_id BETWEEN 1 AND 10
    GROUP BY bulan_referensi.bulan;
";

// Eksekusi query
$result = mysqli_query($conn, $query);

// Ambil data dari hasil query
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Tutup koneksi
mysqli_close($conn);

// Ekstraksi bulan dan total penjualan
$bulan = array_column($data, 'bulan');
$total_penjualan = array_column($data, 'total_penjualan');

// Membuat bar chart menggunakan Chart.js
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bar Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="barChart"></canvas>
    <script>
        // Membuat bar chart dengan menggunakan Chart.js
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($bulan); ?>,
                datasets: [{
                    label: 'Total Penjualan',
                    data: <?php echo json_encode($total_penjualan); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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

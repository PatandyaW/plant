<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "ecomm");

// Query untuk mengambil data dari tabel
$query = "SELECT 
CASE
	WHEN MONTH(sales.sales_date) = 1 THEN 'Januari'
    WHEN MONTH(sales.sales_date) = 2 THEN 'Februari'
    WHEN MONTH(sales.sales_date) = 3 THEN 'Maret'
    WHEN MONTH(sales.sales_date) = 4 THEN 'April'
    WHEN MONTH(sales.sales_date) = 5 THEN 'Mei'
    WHEN MONTH(sales.sales_date) = 6 THEN 'Juni'
    WHEN MONTH(sales.sales_date) = 7 THEN 'Juli'
    WHEN MONTH(sales.sales_date) = 8 THEN 'Agustus'
    WHEN MONTH(sales.sales_date) = 9 THEN 'September'
    WHEN MONTH(sales.sales_date) = 10 THEN 'Oktober'
    WHEN MONTH(sales.sales_date) = 11 THEN 'November'
    WHEN MONTH(sales.sales_date) = 12 THEN 'Desember'
END AS Month, SUM(details.quantity*(products.price)) AS Total
FROM details 
JOIN sales ON details.sales_id=sales.id 
JOIN products ON details.product_id = products.id
GROUP BY  MONTH(sales.sales_date);
";
$res = mysqli_query($conn, $query);

// Inisialisasi array untuk menyimpan bulan dan total penjualan
$bulanData = array();
$totalData = array();

// Mengambil data dari hasil query dan menyimpannya ke dalam array
while ($data = mysqli_fetch_array($res)) {
    $bulanData[] = $data['Month'];
    $totalData[] = $data['Total'];
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
                    label: 'Total Pendapatan Bulanan (dalam RP)',
                    data: totalData,
                    fill: true,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
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

<?php
// Buat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "ecomm");

// Query SQL
$query = "
SELECT 
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
    END AS Month,SUM(details.quantity) AS Total FROM details JOIN sales ON details.sales_id=sales.id GROUP BY MONTH(sales.sales_date);
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
$bulan = array_column($data, 'Month');
$total_penjualan = array_column($data, 'Total');

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
                    label: 'Total Penjualan Bulanan (Unit)',
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

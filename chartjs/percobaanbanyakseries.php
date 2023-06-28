<?php
// Buat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "ecomm");

// Query SQL pertama
$query1 = "
SELECT
months.month,
products.category_id,
COALESCE(SUM(details.quantity), 0) AS total_penjualan
FROM (
SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8
UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12
) AS months
JOIN products
LEFT JOIN sales ON MONTH(sales.sales_date) = months.month
LEFT JOIN details ON details.sales_id = sales.id
AND details.product_id = products.id
WHERE products.category_id = 1
GROUP BY months.month, products.category_id;
";

$query2 = "
SELECT
months.month,
products.category_id,
COALESCE(SUM(details.quantity), 0) AS total_penjualan
FROM (
SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8
UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12
) AS months
JOIN products
LEFT JOIN sales ON MONTH(sales.sales_date) = months.month
LEFT JOIN details ON details.sales_id = sales.id
AND details.product_id = products.id
WHERE products.category_id = 2
GROUP BY months.month, products.category_id;
";

// Query SQL ke-3
$query3 = "
SELECT
months.month,
products.category_id,
COALESCE(SUM(details.quantity), 0) AS total_penjualan
FROM (
SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8
UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12
) AS months
JOIN products
LEFT JOIN sales ON MONTH(sales.sales_date) = months.month
LEFT JOIN details ON details.sales_id = sales.id
AND details.product_id = products.id
WHERE products.category_id = 3
GROUP BY months.month, products.category_id;
";

// Query SQL ke-4
$query4 = "
SELECT
months.month,
products.category_id,
COALESCE(SUM(details.quantity), 0) AS total_penjualan
FROM (
SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8
UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12
) AS months
JOIN products
LEFT JOIN sales ON MONTH(sales.sales_date) = months.month
LEFT JOIN details ON details.sales_id = sales.id
AND details.product_id = products.id
WHERE products.category_id = 4
GROUP BY months.month, products.category_id;
";

// Eksekusi query pertama
$result1 = mysqli_query($conn, $query1);
$data1 = array();
while ($row = mysqli_fetch_assoc($result1)) {
    $data1[] = $row['total_penjualan'];
}

// Eksekusi query kedua
$result2 = mysqli_query($conn, $query2);
$data2 = array();
while ($row = mysqli_fetch_assoc($result2)) {
    $data2[] = $row['total_penjualan'];
}

// Eksekusi query ke3
$result3 = mysqli_query($conn, $query3);
$data3 = array();
while ($row = mysqli_fetch_assoc($result3)) {
    $data3[] = $row['total_penjualan'];
}

// Eksekusi query ke4
$result4 = mysqli_query($conn, $query4);
$data4 = array();
while ($row = mysqli_fetch_assoc($result4)) {
    $data4[] = $row['total_penjualan'];
}

// Tampilkan hasil dalam bentuk bar chart
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
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                datasets: [
                    {
                        label: 'Tanaman Hias',
                        data: <?php echo json_encode($data1); ?>,
                        backgroundColor: 'rgba(255, 0, 0, 0.5)',
                        borderColor: 'rgba(255, 0, 0, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Bibit Buah',
                        data: <?php echo json_encode($data2); ?>,
                        backgroundColor: 'rgba(255, 165, 0, 0.5)',
                        borderColor: 'rgba(255, 165, 0, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Bibit Sayur',
                        data: <?php echo json_encode($data3); ?>,
                        backgroundColor: 'rgba(0, 0, 255, 0.5)',
                        borderColor: 'rgba(0, 0, 255, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Tanaman Aromatik',
                        data: <?php echo json_encode($data4); ?>,
                        backgroundColor: 'rgba(0, 128, 0, 0.5)',
                        borderColor: 'rgba(0, 128, 0, 1)',
                        borderWidth: 1
                    }
                ]
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
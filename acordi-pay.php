<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // File path
    $file = __DIR__ . '/payment-completed.txt';
} else {
    // File path
    $file = __DIR__ . '/payu-payment-completed.txt';
}
date_default_timezone_set('Asia/Kolkata');

if (!file_exists($file)) {
    die("No payment data found.");
}

$content = file_get_contents($file);
$records = explode('-----------------------------', $content);

$dataList = [];

foreach ($records as $record) {

    if (trim($record) == '') continue;

    preg_match('/Date:\s*(.*)/', $record, $dateMatch);
    $date = $dateMatch[1] ?? '';

    preg_match_all('/\[(.*?)\]\s*=>\s*(.*)/', $record, $matches);

    $data = [];
    if (!empty($matches[1])) {
        foreach ($matches[1] as $index => $key) {
            $data[$key] = trim($matches[2][$index]);
        }
    }

    $data['date'] = $date;
    $dataList[] = $data;
}


$totalAmount = 0;
$todayAmount = 0;

$todayDate = date('Y-m-d');

foreach ($dataList as $row) {

    $amount = floatval($row['amount'] ?? 0);
    $status = strtolower($row['status'] ?? '');
    $date = $row['date'] ?? '';

    // sirf success wale count karo
    if ($status == 'success') {

        $totalAmount += $amount;

        if (date('Y-m-d', strtotime($date)) == $todayDate) {
            $todayAmount += $amount;
        }
    }
}

// 🔥 Order by latest date
usort($dataList, function ($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});
?>

<!DOCTYPE html>
<html>
<link href="image/logo.jpg" rel="icon">
<head>
    <title>Payment Dashboard</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #1e293b;
            color: #fff;
            padding: 15px 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header img {
            height: 40px;
        }

        .container {
            padding: 20px;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #0f172a;
            color: #fff;
            padding: 10px;
            font-size: 14px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
        }

        tr:hover {
            background: #f1f5f9;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .failed {
            color: red;
            font-weight: bold;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            flex: 1;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .stat-card:nth-child(2) {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .stat-card h3 {
            margin: 0;
            font-size: 16px;
        }

        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .stats {
                flex-direction: column;
            }
        }

        /* 📱 Mobile responsive */
        @media (max-width: 768px) {

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                margin-bottom: 15px;
                background: #fff;
                border-radius: 10px;
                padding: 10px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            }

            td {
                border: none;
                display: flex;
                justify-content: space-between;
                padding: 8px;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #555;
            }
        }
    </style>
</head>

<body>

    <!-- 🔥 Header -->
    <div class="header">
        <div class="header-left">
            <!-- 🖼️ Company Logo -->
            <img src="https://acordi.in/image/logo.jpg" alt="Logo">
            <h2>Agricultural Consultancy and Rural Development Institute</h2>
        </div>

        <!-- 📅 Current Date -->
        <div>
            <?php echo date("d M Y, h:i A"); ?>
        </div>
    </div>

    <div class="container">
        <div class="stats">
            <div class="stat-card">
                <h3>💰 Today Earning</h3>
                <p>₹<?= number_format($todayAmount, 2) ?></p>
            </div>

            <div class="stat-card">
                <h3>📊 Total Earning</h3>
                <p>₹<?= number_format($totalAmount, 2) ?></p>
            </div>
        </div>
        <div class="card">

            <table>
                <thead>
                    <tr>
                        <th>PayU Id</th>
                        <th>Date</th>
                        <th>Txn ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($dataList as $row): ?>
                        <tr>
                            <td data-label="PayU Id"><?= $row['mihpayid'] ?? '' ?></td>
                            <td data-label="Date"><?= $row['date'] ?></td>
                            <td data-label="Txn"><?= $row['txnid'] ?? '' ?></td>
                            <td data-label="Name"><?= $row['firstname'] ?? '' ?></td>
                            <td data-label="Email"><?= $row['email'] ?? '' ?></td>
                            <td data-label="Amount">₹<?= $row['amount'] ?? '' ?></td>
                            <td data-label="Status" class="<?= ($row['status'] == 'success') ? 'success' : 'failed' ?>">
                                <?= $row['status'] ?? '' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background: white;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #1e40af;
            font-size: 28px;
            margin-bottom: 5px;
        }
        .header p {
            color: #64748b;
            font-size: 14px;
        }
        .period {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background: #eff6ff;
            border-radius: 8px;
        }
        .period strong {
            color: #1e40af;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table thead {
            background: #3b82f6;
            color: white;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #e5e7eb;
        }
        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-diproses { background: #dbeafe; color: #1e40af; }
        .status-selesai { background: #d1fae5; color: #065f46; }
        .status-batal { background: #fee2e2; color: #991b1b; }
        .summary {
            margin-top: 30px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }
        .summary h3 {
            color: #1e40af;
            margin-bottom: 15px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .summary-item {
            padding: 10px;
            background: white;
            border-radius: 6px;
        }
        .summary-item label {
            display: block;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .summary-item strong {
            color: #1e293b;
            font-size: 18px;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
        .signature-line {
            display: inline-block;
            border-top: 1px solid #000;
            padding-top: 5px;
            min-width: 200px;
            margin-top: 60px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>LAPORAN BOOKING</h1>
        <p>SYH Cleaning - Jasa Cuci Sepatu Profesional</p>
    </div>

    <!-- Period -->
    <div class="period">
        <strong>Periode:</strong> <?= date('d F Y', strtotime($start_date)) ?> - <?= date('d F Y', strtotime($end_date)) ?>
    </div>

    <!-- Summary Statistics -->
    <div class="summary">
        <h3>Ringkasan Statistik</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <label>Total Booking</label>
                <strong><?= count($bookings) ?></strong>
            </div>
            <div class="summary-item">
                <label>Booking Selesai</label>
                <strong><?= count(array_filter($bookings, fn($b) => $b['status'] === 'selesai')) ?></strong>
            </div>
            <div class="summary-item">
                <label>Booking Pending</label>
                <strong><?= count(array_filter($bookings, fn($b) => $b['status'] === 'pending')) ?></strong>
            </div>
            <div class="summary-item">
                <label>Total Pendapatan</label>
                <strong>Rp <?= number_format(array_sum(array_column(array_filter($bookings, fn($b) => $b['status'] === 'selesai'), 'total')), 0, ',', '.') ?></strong>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <table>
        <thead>
            <tr>
                <th>ID Booking</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($bookings)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">
                        Tidak ada data booking untuk periode ini
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td>#<?= $booking['id'] ?></td>
                        <td><?= $booking['customer_name'] ?></td>
                        <td>
                            <?php
                            $serviceName = match($booking['layanan']) {
                                'fast-cleaning' => 'Fast Cleaning',
                                'deep-cleaning' => 'Deep Cleaning',
                                'white-shoes' => 'White Shoes',
                                'suede-treatment' => 'Suede Treatment',
                                'unyellowing' => 'Unyellowing',
                                'repair' => 'Repair',
                                'coating' => 'Coating',
                                'dyeing' => 'Dyeing',
                                default => ucfirst(str_replace('-', ' ', $booking['layanan']))
                            };
                            echo $serviceName;
                            ?>
                        </td>
                        <td><?= date('d/m/Y', strtotime($booking['dibuat_pada'])) ?></td>
                        <td>
                            <?php
                            $statusClass = match($booking['status']) {
                                'pending' => 'status-pending',
                                'diproses' => 'status-diproses',
                                'selesai' => 'status-selesai',
                                'batal' => 'status-batal',
                                default => ''
                            };
                            $statusText = match($booking['status']) {
                                'pending' => 'Pending',
                                'diproses' => 'Diproses',
                                'selesai' => 'Selesai',
                                'batal' => 'Batal',
                                default => $booking['status']
                            };
                            ?>
                            <span class="status <?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                        <td>Rp <?= number_format($booking['total'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Footer with Signature -->
    <div class="footer">
        <p style="color: #64748b; margin-bottom: 10px;">Dicetak pada: <?= date('d F Y H:i:s') ?></p>
        
        <div class="signature">
            <p>Mengetahui,</p>
            <div class="signature-line">
                <strong>Owner SYH Cleaning</strong>
            </div>
        </div>
    </div>
</body>
</html>

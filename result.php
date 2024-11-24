<?php
include 'db.php';

$sql = "SELECT * FROM registrations";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pendaftaran</title>
    <link rel="stylesheet" href="css/form.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h2>Data Pendaftaran</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal Lahir</th>
                    <th>No Telepon</th>
                    <th>Password</th>
                    <th>Nama File</th>
                    <th>Browser info</th>
                    <th>Waktu Pendaftaran</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['dob']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['password']) ?></td>
                        <td><?= htmlspecialchars($row['file_name']) ?></td>
                        <td><?= htmlspecialchars($row['browser_info']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <table class="file-content-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama File</th>
                    <th>Isi File</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Reset pointer hasil query
                $result->data_seek(0);
                
                while ($row = $result->fetch_assoc()): 
                    $filePath = 'uploads/' . $row['file_name']; // Pastikan file berada di folder 'uploads'
                    $fileContent = file_exists($filePath) ? file($filePath, FILE_IGNORE_NEW_LINES) : ["File tidak ditemukan."];
                ?>
                    <tr>
                        <td rowspan="<?= count($fileContent) ?>"><?= htmlspecialchars($row['id']) ?></td>
                        <td rowspan="<?= count($fileContent) ?>"><?= htmlspecialchars(basename($row['file_name'])) ?></td>
                        <td><?= htmlspecialchars($fileContent[0]) ?></td>
                    </tr>
                    <?php for ($i = 1; $i < count($fileContent); $i++): ?>
                        <tr>
                            <td><?= htmlspecialchars($fileContent[$i]) ?></td>
                        </tr>
                    <?php endfor; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Belum ada data yang terdaftar.</p>
    <?php endif; ?>
</body>

</html>

<?php
$conn->close();
?>
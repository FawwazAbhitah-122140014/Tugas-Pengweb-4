<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div id="form-section">
            <h2>Pendaftaran</h2>
            <form id="registrationForm" action="process.php" method="POST" enctype="multipart/form-data">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name">
                <span id="errorFile" class="error"></span>

                <label for="email">Email</label>
                <input type="email" id="email" name="email">
                <span id="errorFile" class="error"></span>

                <label for="dob">Tanggal Lahir</label>
                <input type="date" id="dob" name="dob" required>
                <span id="errorFile" class="error"></span>

                <label for="phone">No Telepon</label>
                <input type="text" id="phone" name="phone">
                <span id="errorFile" class="error"></span>

                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <span id="errorFile" class="error"></span>

                <label for="file">Unggah File (teks)</label>
                <input type="file" id="file" name="file" accept=".txt" required>
                <span id="errorFile" class="error"></span>

                <input type="submit" value="Daftar">
            </form>
        </div>
    <script src="script.js"></script>
</body>
</html>

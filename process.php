<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $dob = $_POST['dob'];
    $phone = trim($_POST['phone']);
    $file = $_FILES['file'];

    if (strlen($name) < 3) $errors[] = "Nama harus minimal 3 karakter.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email tidak valid.";
    if (strlen($password) < 6) $errors[] = "Password minimal 6 karakter.";
    if (empty($dob)) $errors[] = "Tanggal lahir harus diisi.";
    if (!preg_match("/^\+?[0-9]{10,15}$/", $phone)) $errors[] = "Nomor telepon tidak valid. Pastikan formatnya benar.";
    if ($file['type'] != 'text/plain') $errors[] = "File harus berupa teks.";
    if ($file['size'] > 1024 * 1024) $errors[] = "Ukuran file tidak boleh lebih dari 1MB.";

    if (count($errors) > 0) {
        foreach ($errors as $error) echo "<p class='error'>$error</p>";
        echo "<a href='form.php'>Kembali ke Form</a>";
        exit();
    }

    $uploadDir = "uploads/";
    $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $file['name']);
    $filePath = $uploadDir . basename($fileName);

    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        echo "<p>Gagal mengunggah file.</p>";
        echo "<a href='form.php'>Kembali ke Form</a>";
        exit();
    }

    $fileContent = file($filePath, FILE_IGNORE_NEW_LINES);

    $browser = $_SERVER['HTTP_USER_AGENT'];

    $stmt = $conn->prepare("INSERT INTO registrations (name, email, password, dob, phone, file_name, browser_info) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $password, $dob, $phone, $fileName, $browser);

    if ($stmt->execute()) {
        echo "<form id='redirectForm' action='result.php' method='POST'>
            <input type='hidden' name='name' value='" . htmlspecialchars($name) . "'>
            <input type='hidden' name='email' value='" . htmlspecialchars($email) . "'>
            <input type='hidden' name='password' value='" . htmlspecialchars($password) . "'>
            <input type='hidden' name='dob' value='" . htmlspecialchars($dob) . "'>
            <input type='hidden' name='phone' value='" . htmlspecialchars($phone) . "'>
            <input type='hidden' name='fileContent' value='" . htmlspecialchars(json_encode($fileContent)) . "'>
        </form>
        <script>document.getElementById('redirectForm').submit();</script>";
        exit();
    } else {
        echo "<p>Terjadi kesalahan saat menyimpan data. Silakan coba lagi.</p>";
        echo "<a href='form.php'>Kembali ke Form</a>";
    }

    $stmt->close();
    $conn->close();
}
?>

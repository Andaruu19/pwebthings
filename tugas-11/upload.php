<?php
// Konfigurasi database
$host = 'localhost';
$dbname = 'tugas-11-pweb';
$username = 'root';
$password = '';

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Inisialisasi variabel
$error = '';
$success = '';

// Proses upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "uploads/"; // Folder tempat file disimpan
    $file_name = basename($_FILES["photo"]["name"]);
    $target_file = $target_dir . $file_name;
    $upload_ok = true;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file adalah gambar
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check === false) {
        $error = "File bukan gambar.";
        $upload_ok = false;
    }

    // Cek ukuran file (maksimal 2MB)
    if ($_FILES["photo"]["size"] > 2 * 1024 * 1024) {
        $error = "Ukuran file terlalu besar (maksimal 2MB).";
        $upload_ok = false;
    }

    // Hanya izinkan format tertentu
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($image_file_type, $allowed_types)) {
        $error = "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        $upload_ok = false;
    }

    // Proses upload jika tidak ada error
    if ($upload_ok) {
        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Simpan nama file ke database
            $stmt = $conn->prepare("INSERT INTO photos (photo_name) VALUES (?)");
            $stmt->bind_param("s", $file_name);

            if ($stmt->execute()) {
                $success = "File " . htmlspecialchars($file_name) . " berhasil diunggah.";
            } else {
                $error = "Gagal menyimpan data ke database: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error = "Terjadi kesalahan saat mengunggah file.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto</title>
</head>
<body>
    <h1>Upload Foto</h1>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="photo">Pilih Foto:</label><br>
        <input type="file" id="photo" name="photo" accept="image/*" required><br><br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>

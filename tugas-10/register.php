<?php
// Konfigurasi database
$host = 'localhost';
$dbname = 'tugas-9';
$username = 'root';
$password = '';

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil daftar roles dari database
$roles_result = $conn->query("SELECT * FROM roles");
$roles = [];
while ($row = $roles_result->fetch_assoc()) {
    $roles[] = $row;
}

// Inisialisasi variabel
$error = '';
$success = '';

// Proses pendaftaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $role_id = intval($_POST['role_id']);

    // Validasi input
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Semua bidang harus diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid.";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok.";
    } elseif ($role_id <= 0) {
        $error = "Peran pengguna tidak valid.";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Masukkan data ke database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $username, $email, $hashed_password, $role_id);

        if ($stmt->execute()) {
            $success = "Pendaftaran berhasil! Anda dapat login sekarang.";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
</head>
<body>
    <h1>Form Pendaftaran</h1>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Konfirmasi Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <label for="role_id">Pilih Peran:</label><br>
        <select id="role_id" name="role_id" required>
            <option value="">-- Pilih Peran --</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['id']; ?>"><?php echo htmlspecialchars($role['role_name']); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>

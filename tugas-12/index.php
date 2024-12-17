<?php
// Sertakan pustaka FPDF
require('fpdf.php');

// Konfigurasi database
$host = 'localhost';
$dbname = 'tugas-12-pweb';
$username = 'root';
$password = '';

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data pengguna dari database
$result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");

// Buat dokumen PDF
class PDF extends FPDF
{
    // Header
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Laporan Data Pengguna', 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 10, 'ID', 1, 0, 'C');
        $this->Cell(60, 10, 'Username', 1, 0, 'C');
        $this->Cell(80, 10, 'Email', 1, 0, 'C');
        $this->Cell(40, 10, 'Tanggal Dibuat', 1, 1, 'C');
    }

    // Footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Tambahkan data ke tabel
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $row['id'], 1, 0, 'C');
    $pdf->Cell(60, 10, $row['username'], 1, 0, 'L');
    $pdf->Cell(80, 10, $row['email'], 1, 0, 'L');
    $pdf->Cell(40, 10, $row['created_at'], 1, 1, 'L');
}

// Output PDF
$pdf->Output('D', 'Laporan_Pengguna.pdf');

$conn->close();
?>

<?php

require_once '../isAdmin.php';
include_once '../connection.php';
global $connect;
// count tota kelas
$query_kelas = 'SELECT COUNT(*) AS total_kelas FROM kelas';
$result_kelas = mysqli_query($connect, $query_kelas);
$total_kelas = mysqli_fetch_assoc($result_kelas)['total_kelas'];

// count total pendaftar
$query_siswa = 'SELECT COUNT(*) AS total_siswa FROM siswas s left join pembayaran p on s.id = p.siswa_id';
$result_siswa = mysqli_query($connect, $query_siswa);
$total_siswa = mysqli_fetch_assoc($result_siswa)['total_siswa'];

// count total pengajar
$query_pengajar = 'SELECT COUNT(*) AS total_pengajar FROM pengajar';
$result_pengajar = mysqli_query($connect, $query_pengajar);
$total_pengajar = mysqli_fetch_assoc($result_pengajar)['total_pengajar'];

// statistik pendaftar
$query_diterima = 'SELECT COUNT(*) as diterima from pembayaran where is_verified = true';
$result_diterima = mysqli_query($connect, $query_diterima);
$diterima = mysqli_fetch_assoc($result_diterima)['diterima'];

// statistik total cabang
$query_cabang = 'SELECT COUNT(*) as total_cabang from cabang';
$result_cabang = mysqli_query($connect, $query_cabang);
$total_cabang = mysqli_fetch_assoc($result_cabang)['total_cabang'];

$query_ditolak = 'SELECT COUNT(*) as ditolak from pembayaran where is_verified = false';
$result_ditolak = mysqli_query($connect, $query_ditolak);
$ditolak = mysqli_fetch_assoc($result_ditolak)['ditolak'];
// get all pendaftar
$query_pendaftar = 'SELECT p.id as id,s.nama as siswa_nama ,c.nama as cabang_nama, s.no_hp, p.is_verified FROM siswas s join pembayaran p on s.id = p.siswa_id join cabang c on p.cabang_id = c.id ORDER BY s.created_at DESC';
$result_pendaftar = mysqli_query($connect, $query_pendaftar);
$pendaftar = mysqli_fetch_all($result_pendaftar, MYSQLI_ASSOC);
require_once '../template/header.php';
?>
<style>
.stat-card {
    background: linear-gradient(135deg, #0396FF, #0D47A1);
    border-radius: 16px;
    padding: 20px;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.stat-title {
    font-size: 1rem;
    opacity: 0.9;
}

.stat-icon {
    font-size: 2rem;
    opacity: 0.8;
    margin-bottom: 15px;
}

.status-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.table-custom {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
}

.table-custom thead {
    background: #f8f9fa;
}

.dashboard-title {
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 30px;
    color: #2c3e50;
}

.verification-badge {
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
}
</style>

<div class="container py-4">
    <h1 class="dashboard-title"><i class="bx bxs-dashboard me-2"></i>Dashboard Overview</h1>
    
    <div class="row g-4">
        <!-- Statistics Cards -->
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #0396FF, #0D47A1)">
                <i class='bx bxs-school stat-icon'></i>
                <div class="stat-number"><?php echo $total_kelas; ?></div>
                <div class="stat-title">Total Kelas</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #32CCBC, #90F7EC)">
                <i class='bx bxs-group stat-icon'></i>
                <div class="stat-number"><?php echo $total_siswa; ?></div>
                <div class="stat-title">Total Siswa</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #FF6B6B, #FFE66D)">
                <i class='bx bxs-user-voice stat-icon'></i>
                <div class="stat-number"><?php echo $total_pengajar; ?></div>
                <div class="stat-title">Total Pengajar</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #17C964, #0E884D)">
                <i class='bx bxs-buildings stat-icon'></i>
                <div class="stat-number"><?php echo $total_cabang; ?></div>
                <div class="stat-title">Total Cabang</div>
            </div>
        </div>
    </div>

    <!-- Registration Status -->
    <div class="status-card mt-5">
        <h2 class="h4 mb-4">Status Pendaftaran</h2>
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="stat-card" style="background: linear-gradient(135deg, #28a745, #20c997)">
                    <i class='bx bxs-check-circle stat-icon'></i>
                    <div class="stat-number"><?php echo $diterima; ?></div>
                    <div class="stat-title">Pendaftar Diterima</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card" style="background: linear-gradient(135deg, #dc3545, #f86d6d)">
                    <i class='bx bxs-x-circle stat-icon'></i>
                    <div class="stat-number"><?php echo $ditolak; ?></div>
                    <div class="stat-title">Pendaftar Ditolak</div>
                </div>
            </div>
        </div>

        <!-- Registration Table -->
        <div class="table-responsive table-custom">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Cabang</th>
                        <th>Nomor HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendaftar as $p) { ?>
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <i class='bx bxs-user-circle fs-4 me-2'></i>
                                <?php echo $p['siswa_nama']; ?>
                            </div>
                        </td>
                        <td class="align-middle"><?php echo $p['cabang_nama']; ?></td>
                        <td class="align-middle"><?php echo $p['no_hp']; ?></td>
                        <td class="align-middle">
                            <?php if ($p['is_verified']): ?>
                                <span class="verification-badge bg-success bg-opacity-10 text-success">
                                    <i class='bx bxs-check-circle me-1'></i>Terverifikasi
                                </span>
                            <?php else: ?>
                                <span class="verification-badge bg-danger bg-opacity-10 text-danger">
                                    <i class='bx bxs-x-circle me-1'></i>Belum Terverifikasi
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="align-middle">
                            <div class="btn-group">
                                <a href="verifikasi_pembayaran.php?id=<?php echo $p['id']; ?>" 
                                   class="btn btn-sm btn-outline-success">
                                    <i class='bx bx-check me-1'></i>Verifikasi
                                </a>
                                <a href="tolak.php?id=<?php echo $p['id']; ?>" 
                                   class="btn btn-sm btn-outline-danger">
                                    <i class='bx bx-x me-1'></i>Tolak
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../template/footer.php'; ?>
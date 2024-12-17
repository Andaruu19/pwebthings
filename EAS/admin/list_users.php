<?php
require_once '../isAdmin.php';
include_once '../connection.php';
global $connect;
$users_query = 'SELECT name,username,email,roles,id FROM users';
$users_result = mysqli_query($connect, $users_query);
$users = mysqli_fetch_all($users_result, MYSQLI_ASSOC);
include_once '../template/header.php';
?>

<style>
.users-container {
    padding: 2rem;
}

.search-box {
    background: white;
    padding: 1rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.user-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    border: 1px solid #eee;
    position: relative;
    overflow: hidden;
}

.user-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.user-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: #198754;
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #198754;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: 600;
}

.user-role {
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.role-admin {
    background: rgba(25, 135, 84, 0.1);
    color: #198754;
}

.role-user {
    background: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
}

.user-actions {
    opacity: 0;
    transition: all 0.3s ease;
}

.user-card:hover .user-actions {
    opacity: 1;
}
</style>

<div class="container-fluid users-container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-4">
                <i class='bx bxs-user-account me-2'></i>User Management
            </h2>
            
            <!-- Search Box -->
            <div class="search-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class='bx bx-search'></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="searchUser" 
                                   placeholder="Search users...">
                        </div>
                    </div>
                    <div class="col-md-auto ms-auto">
                        <button class="btn btn-success">
                            <i class='bx bx-plus me-2'></i>Add New User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php foreach ($users as $user) { 
            $initials = strtoupper(substr($user['name'], 0, 2));
        ?>
            <div class="col-xl-4 col-md-6">
                <div class="user-card">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                            <?php echo $initials; ?>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-1"><?php echo $user['name']; ?></h5>
                            <p class="text-muted mb-0">@<?php echo $user['username']; ?></p>
                        </div>
                        <div>
                            <span class="user-role <?php echo $user['roles'] == 'admin' ? 'role-admin' : 'role-user'; ?>">
                                <?php echo ucfirst($user['roles']); ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div class="d-flex align-items-center text-muted">
                            <i class='bx bx-envelope me-2'></i>
                            <?php echo $user['email']; ?>
                        </div>
                    </div>

                    <div class="user-actions mt-3 pt-3 border-top">
                        <div class="btn-group w-100">
                            <button class="btn btn-light" title="Edit">
                                <i class='bx bx-edit'></i>
                            </button>
                            <button class="btn btn-light" title="Reset Password">
                                <i class='bx bx-key'></i>
                            </button>
                            <button class="btn btn-light text-danger" title="Delete">
                                <i class='bx bx-trash'></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include_once '../template/footer.php'; ?>
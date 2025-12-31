<?php
// Include the layout
ob_start();

// Get tab parameter
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'profile';
?>

<!-- Page Header -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h3 mb-0">My Profile</h1>
    </div>
</div>

<!-- Profile Section -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Account Menu</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link <?php echo $active_tab == 'profile' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/user/profile?tab=profile">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $active_tab == 'password' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/user/profile?tab=password">Change Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/orders">My Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/orders/downloads">Downloads</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <?php if ($active_tab == 'profile'): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo BASE_URL; ?>/user/profile">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? SecurityHelper::generateCSRFToken(); ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo e($user['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo e($user['email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Account Role</label>
                                <input type="text" class="form-control" id="role" value="<?php echo e(ucfirst($user['role'])); ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Account Status</label>
                                <input type="text" class="form-control" id="status" value="<?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="created_at" class="form-label">Member Since</label>
                                <input type="text" class="form-control" id="created_at" value="<?php echo date('F j, Y', strtotime($user['created_at'])); ?>" disabled>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($active_tab == 'password'): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo BASE_URL; ?>/user/change-password">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? SecurityHelper::generateCSRFToken(); ?>">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
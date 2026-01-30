<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?></title>
    <?php assets()->css('css/dashboard.css', 'head', 10); ?>
    <?php assets()->js('js/dashboard.js', 'body_end', 10); ?>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Dashboard</h1>
            <form method="POST" action="<?= url('/logout') ?>">
                <?= csrf_field() ?>
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="welcome">
            <h2>Welcome, <?= e($user->name) ?>!</h2>
            <p>Manage all users in the system</p>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= e($success) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <div class="tabs">
            <div class="tab-buttons">
                <button class="tab-button active" data-tab="traditional">Traditional Mode</button>
                <button class="tab-button" data-tab="ajax">AJAX Mode</button>
            </div>

            <!-- Traditional Mode Tab -->
            <div class="tab-content active" id="traditional">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="color: #333; margin: 0;">User Management (Page-Based)</h3>
                    <a href="<?= url('/dashboard/users/create') ?>" class="btn btn-primary">+ Create User</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $listUser): ?>
                            <tr>
                                <td><?= e($listUser->id) ?></td>
                                <td><?= e($listUser->name) ?></td>
                                <td><?= e($listUser->email) ?></td>
                                <td><?= e($listUser->created_at) ?></td>
                                <td>
                                    <a href="<?= url('/dashboard/users/' . $listUser->id . '/edit') ?>" class="btn btn-edit">Edit</a>

                                    <?php if ($listUser->id !== $user->id): ?>
                                        <form method="POST" action="<?= url('/dashboard/users/' . $listUser->id) ?>" style="display:inline;">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- AJAX Mode Tab -->
            <div class="tab-content" id="ajax">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="color: #333; margin: 0;">User Management (AJAX-Based)</h3>
                    <button class="btn btn-primary" onclick="openCreateModal()">+ Create User</button>
                </div>

                <div id="ajax-alert" style="display: none;" class="alert"></div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ajax-users-table">
                        <tr>
                            <td colspan="5" style="text-align: center;">Loading users...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create/Edit User Modal -->
    <div class="modal" id="userModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Create User</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form id="userForm">
                <input type="hidden" id="userId" name="id">

                <div class="form-group">
                    <label for="userName">Name</label>
                    <input type="text" id="userName" name="name" required>
                    <div class="form-error" id="error-name"></div>
                </div>

                <div class="form-group">
                    <label for="userEmail">Email</label>
                    <input type="email" id="userEmail" name="email" required>
                    <div class="form-error" id="error-email"></div>
                </div>

                <div class="form-group">
                    <label for="userPassword">Password <span id="passwordOptional" style="display:none; color: #999;">(leave blank to keep current)</span></label>
                    <input type="password" id="userPassword" name="password">
                    <div class="form-error" id="error-password"></div>
                </div>

                <div class="form-group">
                    <label for="userPasswordConfirm">Confirm Password</label>
                    <input type="password" id="userPasswordConfirm" name="password_confirmation">
                    <div class="form-error" id="error-password_confirmation"></div>
                </div>

                <div class="form-buttons">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.DashboardConfig = {
            currentUserId: <?= $user->id ?>,
            csrfToken: '<?= e(csrf_token()) ?>',
            apiBaseUrl: '<?= e(url('/api/users')) ?>'
        };
    </script>
    <?= render_assets('body_end') ?>
</body>
</html>

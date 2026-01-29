<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-size: 1.5em;
        }
        .header form {
            display: inline;
        }
        .btn-logout {
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background 0.3s;
        }
        .btn-logout:hover {
            background: rgba(255,255,255,0.3);
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .welcome {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .welcome h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .welcome p {
            color: #666;
            font-size: 0.95em;
        }
        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9em;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        .tabs {
            background: white;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .tab-buttons {
            display: flex;
            border-bottom: 2px solid #e9ecef;
        }
        .tab-button {
            flex: 1;
            padding: 15px 30px;
            background: #f8f9fa;
            border: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: 500;
            color: #666;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
        }
        .tab-button:hover {
            background: #e9ecef;
        }
        .tab-button.active {
            background: white;
            color: #667eea;
            border-bottom-color: #667eea;
        }
        .tab-content {
            display: none;
            padding: 30px;
            background: white;
            border-radius: 0 0 10px 10px;
        }
        .tab-content.active {
            display: block;
        }
        .table-container {
            background: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: #f8f9fa;
        }
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            color: #666;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85em;
            display: inline-block;
            margin-right: 5px;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-edit {
            background: #667eea;
            color: white;
        }
        .btn-edit:hover {
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
        }
        .btn-delete {
            background: #e74c3c;
            color: white;
        }
        .btn-delete:hover {
            box-shadow: 0 3px 10px rgba(231, 76, 60, 0.3);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.4);
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background: white;
            border-radius: 10px;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .modal-header h3 {
            color: #333;
            margin: 0;
        }
        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
            padding: 0;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
        }
        .modal-close:hover {
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
            font-size: 0.9em;
        }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.95em;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        .form-error {
            color: #e74c3c;
            font-size: 0.85em;
            margin-top: 5px;
        }
        .form-buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }
        .form-buttons button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 0.95em;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-cancel {
            background: #e9ecef;
            color: #666;
        }
        .btn-cancel:hover {
            background: #dee2e6;
        }
    </style>
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
        // Tab switching
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                const tab = this.dataset.tab;

                // Update buttons
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Update content
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                document.getElementById(tab).classList.add('active');

                // Load users when AJAX tab is activated
                if (tab === 'ajax') {
                    loadUsers();
                }
            });
        });

        // AJAX functionality
        const currentUserId = <?= $user->id ?>;
        const csrfToken = '<?= csrf_token() ?>';

        function loadUsers() {
            fetch('<?= url('/api/users') ?>')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderUsers(data.users);
                    }
                })
                .catch(error => {
                    console.error('Error loading users:', error);
                    showAlert('Error loading users', 'error');
                });
        }

        function renderUsers(users) {
            const tbody = document.getElementById('ajax-users-table');

            if (users.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No users found</td></tr>';
                return;
            }

            tbody.innerHTML = users.map(user => `
                <tr>
                    <td>${escapeHtml(user.id)}</td>
                    <td>${escapeHtml(user.name)}</td>
                    <td>${escapeHtml(user.email)}</td>
                    <td>${escapeHtml(user.created_at || '')}</td>
                    <td>
                        <button class="btn btn-edit" onclick="editUser(${user.id})">Edit</button>
                        ${user.id !== currentUserId ?
                            `<button class="btn btn-delete" onclick="deleteUser(${user.id}, '${escapeHtml(user.name)}')">Delete</button>`
                            : ''}
                    </td>
                </tr>
            `).join('');
        }

        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Create User';
            document.getElementById('userForm').reset();
            document.getElementById('userId').value = '';
            document.getElementById('userPassword').required = true;
            document.getElementById('passwordOptional').style.display = 'none';
            clearErrors();
            document.getElementById('userModal').classList.add('active');
        }

        function editUser(id) {
            fetch(`<?= url('/api/users') ?>/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('modalTitle').textContent = 'Edit User';
                        document.getElementById('userId').value = data.user.id;
                        document.getElementById('userName').value = data.user.name;
                        document.getElementById('userEmail').value = data.user.email;
                        document.getElementById('userPassword').value = '';
                        document.getElementById('userPassword').required = false;
                        document.getElementById('passwordOptional').style.display = 'inline';
                        clearErrors();
                        document.getElementById('userModal').classList.add('active');
                    }
                })
                .catch(error => {
                    console.error('Error loading user:', error);
                    showAlert('Error loading user', 'error');
                });
        }

        function closeModal() {
            document.getElementById('userModal').classList.remove('active');
        }

        function deleteUser(id, name) {
            if (!confirm(`Are you sure you want to delete user "${name}"?`)) {
                return;
            }

            fetch(`<?= url('/api/users') ?>/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    loadUsers();
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error deleting user:', error);
                showAlert('Error deleting user', 'error');
            });
        }

        document.getElementById('userForm').addEventListener('submit', function(e) {
            e.preventDefault();
            clearErrors();

            const userId = document.getElementById('userId').value;
            const isEdit = userId !== '';

            const formData = {
                name: document.getElementById('userName').value,
                email: document.getElementById('userEmail').value,
                password: document.getElementById('userPassword').value,
                password_confirmation: document.getElementById('userPasswordConfirm').value
            };

            const url = isEdit ? `<?= url('/api/users') ?>/${userId}` : '<?= url('/api/users') ?>';
            const method = isEdit ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    showAlert(data.message, 'success');
                    loadUsers();
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const errorEl = document.getElementById(`error-${field}`);
                            if (errorEl) {
                                errorEl.textContent = data.errors[field][0];
                            }
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error saving user:', error);
                showAlert('Error saving user', 'error');
            });
        });

        function showAlert(message, type) {
            const alertEl = document.getElementById('ajax-alert');
            alertEl.textContent = message;
            alertEl.className = 'alert alert-' + type;
            alertEl.style.display = 'block';
            setTimeout(() => {
                alertEl.style.display = 'none';
            }, 5000);
        }

        function clearErrors() {
            document.querySelectorAll('.form-error').forEach(el => el.textContent = '');
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Close modal when clicking outside
        document.getElementById('userModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>

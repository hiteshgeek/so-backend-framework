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
const currentUserId = DashboardConfig.currentUserId;
const csrfToken = DashboardConfig.csrfToken;

function loadUsers() {
    fetch(DashboardConfig.apiBaseUrl)
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
    fetch(`${DashboardConfig.apiBaseUrl}/${id}`)
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

    fetch(`${DashboardConfig.apiBaseUrl}/${id}`, {
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

    const url = isEdit ? `${DashboardConfig.apiBaseUrl}/${userId}` : DashboardConfig.apiBaseUrl;
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

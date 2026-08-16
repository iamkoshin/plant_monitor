document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('changePasswordForm');
    const submitBtn = document.getElementById('submitBtn');
    const errorAlert = document.getElementById('errorAlert');
    const successAlert = document.getElementById('successAlert');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        errorAlert.classList.add('d-none');
        successAlert.classList.add('d-none');
        errorAlert.textContent = '';
        successAlert.textContent = '';

        if (!currentPassword || !newPassword || !confirmPassword) {
            errorAlert.textContent = 'Please fill in all fields.';
            errorAlert.classList.remove('d-none');
            return;
        }

        if (newPassword !== confirmPassword) {
            errorAlert.textContent = 'New password and confirm password do not match.';
            errorAlert.classList.remove('d-none');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Updating...';

        try {
            const response = await fetch('../api/change_password.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    current_password: currentPassword,
                    new_password: newPassword
                })
            });

            const result = await response.json();

            if (result.status === 'success') {
                Swal.fire({
                    title: "Success!",
                    text: result.message || "Password updated successfully.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    form.reset();
                    // Optionally redirect or do nothing
                });
            } else {
                errorAlert.textContent = result.message || 'Failed to update password.';
                errorAlert.classList.remove('d-none');
            }
        } catch (error) {
            errorAlert.textContent = 'An error occurred while connecting to the server.';
            errorAlert.classList.remove('d-none');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Change Password';
        }
    });
});

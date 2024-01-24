


<style>
    #staticBackdrop img {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    .modal-dialog {
        max-width: 30%; /* Adjusted maximum width */
        margin: 5% auto; /* Centered on the screen */
    }

    .modal-body {
        text-align: left;
    }

    .modal-body label {
        display: block;
        margin-bottom: 5px;
        font-size: 0.9rem; /* Adjusted font size */
    }

    .modal-body input,
    .modal-body select {
        width: calc(100% - 12px); /* Adjusted width */
        padding: 6px;
        border: 1px solid #aaa;
        border-radius: 3px;
        margin-bottom: 15px;
        box-sizing: border-box;
        font-size: 0.9rem; /* Adjusted font size */
    }

    .error-message {
        color: red;
        font-size: 0.7rem;
    }

    .modal-footer {
        text-align: center; /* Centered buttons */
    }
</style>

<!-- Modal -->
<div class="modal fade" id="Changepass" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="backend_cpassword.php" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <h5 class="modal-title" style="font-size: 12px; color: darkred; margin-bottom: 10px;">
                        Your password must be at least 8 characters.
                    </h5>

                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required />

                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required />
                    <span id="newPasswordError" class="error-message"></span>

                    <label for="copassword">Confirm Password</label>
                    <input type="password" id="copassword" name="copassword" required />
                    <span id="confirmPasswordError" class="error-message"></span><br>

                    <a href="forgot-password.php" style="font-size: 0.9rem">Forget Password</a><br><br>
            </div>
            <div class="modal-footer">
                <button type="submit" name="change" class="btn btn-primary" style="background-color: #182061;">Change</button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function validateForm() {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('copassword').value;

        document.getElementById('newPasswordError').innerText = '';
        document.getElementById('confirmPasswordError').innerText = '';

        // Validate new password length
        if (newPassword.length < 8) {
            document.getElementById('newPasswordError').innerText = 'New password must be at least 8 characters.';
            return false;
        }

        // Validate confirm password
        if (newPassword !== confirmPassword) {
            document.getElementById('confirmPasswordError').innerText = 'New password and confirm password do not match.';
            return false;
        }

        return true;
    }
</script>

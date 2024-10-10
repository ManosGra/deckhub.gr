<div class="card shadow-lg login-form">
    <div class="card-body">
        <h2 class="mb-4 login-header" style="max-width: 400px; margin: 0 auto;">Σύνδεση</h2>
        <form action="functions/authcode.php" method="post" style="max-width: 400px; margin: 0 auto;">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control border border-black" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control border border-black" required>
            </div>

            <input type="submit" name="login_btn" class="btn btn-primary" value="Login">
        </form>
    </div>
</div>
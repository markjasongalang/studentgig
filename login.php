<?php
    $title = 'Login';
    include './partials/header.php';
?>

<div class="container">
    <div class="account-options">

    </div>

    <form id="login-form" method="POST">
        <h1>Login</h1>

        <h3 class="input-label">Account Type</h3>
        <select name="" id="">
            <option value="student">Student</option>
            <option value="student">Gig Creator</option>
        </select>

        <h3 class="input-label">Username</h3>
        <input type="text" placeholder="Enter username">
        
        <h3 class="input-label">Password</h3>
        <input type="password" placeholder="Enter password">
        <p class="input-help"></p>
        
        <div id="loader"><div class="spinner"></div></div>
        <input type="submit" value="Login">
    </form>
</div>

<script>

</script>

<?php
    include './partials/footer.php';
?>
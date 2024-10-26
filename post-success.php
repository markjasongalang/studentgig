<?php
    $title = 'Post Success';
    include './partials/header.php';

    if (isset($_SESSION['post_successful'])) {
        unset($_SESSION['post_successful']);
    } else {
        header('Location: ./');
        exit;
    }
?>

<div class="container">
    <h2>Gig successfully posted!</h2>
    <p class="content">Students will now be able to apply to it.</p>
    <p class="content">Thank you for using this platform <br> - Jason</p>

    <br>
    <a href="./" class="text-btn">Back to home</a>
</div>

<?php
    include './partials/footer.php';
?>
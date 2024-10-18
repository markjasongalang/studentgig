<?php
    $title = 'View applicants';
    $css_file_name = 'view-applicants';
    include './partials/header.php';
?>

<div class="container">
    <button type="button" class="back-btn"><i class="ri-arrow-left-fill"></i> Back</button>

    <div class="applicant-item">
        <div>
            <h3 class="applicant-name">Mark Jason</h3>
        </div>
        <p>FEU Institute of Technology</p>
        <div>
            <a href="./student-profile?u=" target="_blank">View</a>
            <button class="outline-btn" type="button">Message</button>
            <button type="button">Hire</button>
        </div>
    </div>
</div>

<script>
    
</script>

<?php
    include './partials/footer.php';
?>
<?php
    $title = "Find gigs for students <3";
    $css_file_name = "index";
    include './partials/header.php';
?>

<div class="container">
    <h1 class="tagline">Your next hire is here! <span>23</span> students are eager for gigs!</h1>

    <form id="search-gig-form">
        <i class="ri-search-line"></i>
        <input name="search_gig" id="search-gig" type="text" placeholder="Search for a gig...">
    </form>

    <div class="gig-list">
        <a href="#" class="gig-item">
            <h3 class="gig-title">English Tutor</h3>
            <div>
                <p>Payment</p>
                <p>420 per hour</p>
            </div>
            <div>
                <p>Start</p>
                <p>Oct 25, 2024</p>
            </div>
            <div>
                <p>Duration</p>
                <p>2 weeks</p>
            </div>
            <i class="ri-arrow-right-line"></i>
        </a>
    </div>
</div>

<script>
    const gigList = document.querySelector('.gig-list');
    for (let i = 0; i < 7; i++) {
        const gigItem = document.querySelector('.gig-item').cloneNode(true);
        gigList.appendChild(gigItem);
    }
</script>

<?php
    include './partials/footer.php';
?>
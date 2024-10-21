<?php
    $title = "Find gigs for students <3";
    $css_file_name = "index";
    include './partials/header.php';

    if (isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role'] == 'gig creator') {
        header('Location: ./gig-creator-profile');
        exit;
    }
?>

<div class="container">
    <!-- <h1 class="tagline">Your next hire is here! <span>23</span> students are eager for gigs!</h1> -->
     <h1 class="tagline">Earn While You Learn: Flexible <span>Gigs for Students</span>, Tailored to Fit Your Schedule!</h1>

    <form id="search-gig-form" method="GET">
        <i class="ri-search-line"></i>
        <input name="search_gig" id="search-gig" type="text" placeholder="Search for a gig...">
    </form>

    <div class="gig-list">
        <a href="./gig-details?g=" class="gig-item">
            <h3 class="gig-title">Online Tutor for High School Math (Flexible Hours)</h3>
            <p class="gig-type">Remote</p>
            <div>
                <p>Payment</p>
                <p>420 per hour</p>
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
        if (i % 2 == 0) {
            gigItem.querySelector('.gig-type').innerHTML = 'Onsite';
            gigItem.querySelector('.gig-title').innerHTML = 'Graphic Designer Needed for Quick Logo Project';
        }
        if (i % 3 == 0) {
            gigItem.querySelector('.gig-type').innerHTML = 'Hybrid';
            gigItem.querySelector('.gig-title').innerHTML = 'Content Moderator for Online Community';
        }
        gigList.appendChild(gigItem);
    }
</script>

<?php
    include './partials/footer.php';
?>
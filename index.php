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
        <!-- <a href="./gig-details?g=" class="gig-item">
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
        </a> -->
    </div>
</div>

<script>
    const searchGigForm = document.querySelector('#search-gig-form');
    const gigList = document.querySelector('.gig-list');
    
    retrieveActiveGigs();

    function retrieveActiveGigs() {
        const searchQuery = getQueryParameter('search_gig') || '';
        fetch(`./api/handle-index?search_query=${searchQuery}`)
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                
                if (data.success) {
                    data.gigs.forEach(gig => {
                        const gigItem = document.createElement('a');
                        gigItem.setAttribute('href', `./gig-details?g=${gig.id}`);
                        gigItem.setAttribute('class', 'gig-item');

                        gigItem.innerHTML = `
                            <h3 class="gig-title">${gig.title}</h3>
                            <p class="gig-type">${gig.gig_type}</p>
                            <div>
                                <p>Payment</p>
                                <p>Php ${formatToPesos(gig.payment_amount)} per ${gig.payment_unit}</p>
                            </div>
                            <div>
                                <p>Duration</p>
                                <p>${gig.duration_value} ${gig.duration_unit}</p>
                            </div>
                            <i class="ri-arrow-right-line"></i>
                        `;

                        gigList.appendChild(gigItem);
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }

    searchGigForm.addEventListener('submit', () => {
        retrieveActiveGigs();
    });

    // ========================== GET QUERY PARAMETER ==========================
    function getQueryParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    // FORMAT MONEY AMOUNT 
    function formatToPesos(amount) {
        let numericAmount = parseFloat(amount);
        if (isNaN(numericAmount)) {
            return 'Invalid amount';
        }
        return numericAmount.toLocaleString('en-PH');
    }
</script>

<?php
    include './partials/footer.php';
?>
<?php
    $title = 'View applicants';
    $css_file_name = 'view-applicants';
    include './partials/header.php';

    if (!isset($_GET['g'])) {
        header('Location: ./');
        exit;
    }
?>

<div class="container">
    <button type="button" class="back-btn"><i class="ri-arrow-left-fill"></i> Back</button>

    <!-- <div class="applicant-item">
        <div>
            <h3 class="applicant-name">Mark Jason</h3>
        </div>
        <p>FEU Institute of Technology</p>
        <div>
            <a href="./student-profile?u=" target="_blank">View</a>
            <button class="outline-btn" type="button">Message</button>
            <button type="button">Invite to Hire</button>
            <button type="button">Invited</button>
            <button type="button">Student Accepted</button>
        </div>
    </div> -->
</div>

<script>
    const gigId = getQueryParameter('g');

    const container = document.querySelector('.container');

    // Get gig post applicants

    retrieveApplicants();

    function retrieveApplicants() {
        fetch(`./api/handle-applicants?g=${gigId}&get_applicants=true`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                
                if (data.success) {
                    data.applicants.forEach(applicant => {
                        const applicantItem = document.createElement('div');
                        applicantItem.classList.add('applicant-item');

                        applicantItem.innerHTML = `
                            <div>
                                <h3 class="applicant-name">${applicant.first_name} ${applicant.last_name}</h3>
                            </div>
                            <p>${applicant.university}</p>
                            <div>
                                <a href="./student-profile?u=${applicant.student}" target="_blank">View</a>
                                <button class="outline-btn" type="button">Message</button>
                                <button type="button">Invite to Hire</button>
                                <button type="button">Invited</button>
                                <button type="button">Student Accepted</button>
                            </div>
                        `;
                        container.appendChild(applicantItem);
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // GET QUERY PARAMETER
    function getQueryParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
</script>

<?php
    include './partials/footer.php';
?>
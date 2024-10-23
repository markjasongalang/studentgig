<?php
    $title = 'View applicants';
    $css_file_name = 'view-applicants';
    include './partials/header.php';

    if (!isset($_GET['g']) || ($_GET['u'] != $_SESSION['username'])) {
        header('Location: ./');
        exit;
    }
?>

<!-- Applicant Modal -->
<div id="applicant-modal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Confirm Invitation</h2>
        </div>
        <div class="modal-body">
            <p>By sending this invitation, you are offering this student the opportunity to be hired for the gig. Once accepted, the gig will be assigned to them.</p>
            <form id="invite-applicant-form" method="POST">
                <input name="gig_id" id="gig-id" type="hidden">
                <input name="student" id="student" type="hidden">

                <input name="invite_applicant" id="invite-applicant" type="submit" value="Yes, I want to invite this student for this gig">
            </form>
        </div>
    </div>
</div>

<div class="container">
    <button type="button" class="back-btn"><i class="ri-arrow-left-fill"></i> Back</button>

    <div class="applicant-list">
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
</div>

<script>
    const gigId = getQueryParameter('g');

    // ========================== APPLICANT MODAL ==========================
    const applicantModal = document.querySelector('#applicant-modal');
    const closeApplicantModalBtn = applicantModal.querySelector('.close');

    closeApplicantModalBtn.addEventListener('click', () => {
        applicantModal.style.display = 'none';
    });

    // Shared
    document.addEventListener('click', (e) => {
        if (e.target === applicantModal) {
            applicantModal.style.display = 'none';
        }
    });

    // Get gig post applicants
    const applicantList = document.querySelector('.applicant-list');
    retrieveApplicants();

    function retrieveApplicants() {
        applicantList.innerHTML = '';

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
                                <button id="invite-to-hire-btn" type="button">Invite to Hire</button>
                                <p id="status-preview" class="disabled-preview"></p>
                                <p id="accepted-preview" class="disabled-preview">Student Accepted</p>
                            </div>
                        `;

                        if (applicant.status !== 'Pending') {
                            applicantItem.querySelector('#invite-to-hire-btn').style.display = 'none';
                            applicantItem.querySelector('#status-preview').innerHTML = applicant.status;
                            applicantItem.querySelector('#status-preview').style.display = 'inline-block';
                            if (applicant.status === 'Accepted') {
                                applicantItem.querySelector('#status-preview').style.backgroundColor = 'var(--secondary-color)';
                            }
                        }
                        
                        applicantItem.querySelector('#invite-to-hire-btn').addEventListener('click', () => {
                            applicantModal.style.display = 'block';
                            applicantModal.querySelector('#gig-id').value = applicant.gig_id;
                            applicantModal.querySelector('#student').value = applicant.student;
                        });

                        applicantList.appendChild(applicantItem);
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Invite Applicant
    const inviteApplicantForm = applicantModal.querySelector('#invite-applicant-form');
    inviteApplicantForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);
        
        fetch('./api/handle-applicants', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                
                if (data.success) {
                    applicantModal.style.display = 'none';
                    retrieveApplicants();
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // GET QUERY PARAMETER
    function getQueryParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
</script>

<?php
    include './partials/footer.php';
?>
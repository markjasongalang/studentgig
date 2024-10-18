<?php
    $title = 'Profile';
    $css_file_name = 'profile';
    include './partials/header.php';
?>

<div class="container">
    <div class="left">
        <img id="profile-image" src="./images/profile-image.png" alt="Profile image">
        <button id="change-photo-btn" class="text-btn" type="button">Change photo</button>

        <h2>Mark Galang</h2>
        <p>FEU Tech</p>
        <p>Bachelor of Science in Computer Science with Specialization in Software Engineering</p>
        <p>(2nd Year)</p>

        <button id="edit-profile-btn" class="text-btn" type="button">Edit profile</button>
    </div>

    <div class="main">
        <ul class="top-nav">
            <li id="about-me-tab">About Me</li>
            <li id="applied-gigs-tab" class="active">Applied Gigs</li>
            <li id="hired-gigs-tab">Hired Gigs</li>
        </ul>

        <div class="about-me">
            <form method="POST">
                <!-- Skills -->
                <h3 class="input-label">SKILLS</h3>
                <p class="content">Sample skills</p>
                <textarea name="" id="" placeholder="Share your skills to everyone..."></textarea>
                <p class="input-help"></p>
                
                <!-- Work Experience -->
                <h3 class="input-label">WORK EXPERIENCE</h3>
                <p class="content">Sample work experience</p>
                <textarea name="" id="" placeholder="This part is optional :)"></textarea>
                
                <!-- Certifications/Awards -->
                <h3 class="input-label">CERTIFICATIONS/AWARDS</h3>
                <p class="content">Sample certifications or awards</p>
                <textarea name="" id="" placeholder="This part is optional as well :)"></textarea>
                
                <!-- Contact Information -->
                <h3 class="input-label">Contact Information</h3>
                <p class="content">sample@example.com</p>
                <textarea name="" id="" placeholder="Enter contact details"></textarea>
                <p class="input-help"></p>

                <input name="save_about_me" id="save-about-me" type="submit" value="Save">
                <button id="edit-about-me" class="outline-btn" type="button">Edit About Me</button>
            </form>
        </div>

        <div class="applied-gigs">
            <div class="gig-item">
                <h3 class="gig-title">English Tutor</h3>
                <p class="gig-type">Remote</p>
                <p>420 per hour</p>
                <div class="with-actions">
                    <a href="./gig-details?g=">View</a>
                </div>
                <div class="with-actions">
                    <button>Messages</button>
                </div>
            </div>
        </div>

        <div class="hired-gigs">

        </div>
    </div>
</div>

<script>
    const aboutMeTab = document.querySelector('#about-me-tab');
    const appliedGigsTab = document.querySelector('#applied-gigs-tab');
    const hiredGigsTab = document.querySelector('#hired-gigs-tab');

    aboutMeTab.addEventListener('click', () => {
        // TODO: Continue this
    });

    document.querySelector('#edit-about-me').addEventListener('click', (e) => {
        if (e.target.innerHTML === 'Edit About Me') {
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.style.display = 'block';
            });
            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'none';
            });

            document.querySelector('#save-about-me').style.display = 'block';
            e.target.innerHTML = 'Cancel';
            e.target.setAttribute('class', 'text-btn');
            e.target.style.display = 'block';
            e.target.style.margin = '10px auto';
        } else {
            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'block';
            });
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.style.display = 'none';
            });

            document.querySelector('#save-about-me').style.display = 'none';
            e.target.innerHTML = 'Edit About Me';
            e.target.setAttribute('class', 'outline-btn');
            e.target.style.margin = '20px 0 0 0';
        }
    });
</script>

<?php
    include './partials/footer.php';
?>
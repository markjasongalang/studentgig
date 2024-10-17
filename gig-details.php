<?php
    $title = 'Gig Details';
    $css_file_name = 'gig-details';
    include './partials/header.php';
?>

<div class="container">
    <button class="back-btn" type="button"><i class="ri-arrow-left-fill"></i> Back</button>
    
    <div class="inner">
        <div class="main">
            <!-- Gig Title -->
            <h1>English Tutor</h1>
            <h3 class="input-label gig-title-label">Gig Title</h3>
            <input name="" id="" type="text" placeholder="Examples: English Tutor, Graphic Designer, Social Media Manager, etc...">
            <p class="input-help"></p>

            <!-- Duration -->
            <h3 class="input-label">Duration:</h3>
            <p class="content">2 weeks</p>
            <input class="short-input" type="number" min="1" value="1" step="1">
            <select class="short-select" name="" id="">
                <option value="days">day(s)</option>
                <option value="weeks">week(s)</option>
                <option value="months">month(s)</option>
            </select>
            <p class="input-help"></p>

            <!-- Description -->
            <h3 class="input-label">Description</h3>
            <p class="content">Sample description</p>
            <textarea name="" id="" placeholder="Provide some description about the gig..."></textarea>
            <p class="input-help"></p>

            <!-- Preferred Skills -->
            <h3 class="input-label">Preferred Skills</h3>
            <p class="content">Sample skills</p>
            <textarea name="" id="" placeholder="What are the skills that the student should preferably have?"></textarea>
            <p class="input-help"></p>

            <!-- Schedule/Time Commitment -->
            <h3 class="input-label">Schedule/Time Commitment</h3>
            <p class="content">Sample schedule</p>
            <textarea name="" id="" placeholder="Examples:
1) 9:00 PM to 11:30 PM (Mon, Wed, Fri)
2) Flexible Schedule (work on your own time)
3) Submit weekly reports every Friday, with flexible working hours"></textarea>
            <p class="input-help"></p>

            <!-- Payment information -->
            <h3 class="input-label">Payment Information</h3>
            <p class="content">200 per hour</p>
            <input name="" id="" class="short-input" type="number" min="0" step="0.01" placeholder="Enter amount">
            <select class="short-select" name="" id="">
                <option value="hour">per hour</option>
                <option value="day">per day</option>
                <option value="week">per week</option>
                <option value="month">per month</option>
                <option value="submission">per submission</option>
            </select>
            <p class="input-help"></p>

            <!-- Gig Type -->
            <h3 class="input-label">Gig Type</h3>
            <p class="content">Remote</p>
            <select name="" id="">
                <option value="remote">Remote</option>
                <option value="onsite">Onsite</option>
                <option value="hybrid">Hybrid</option>
            </select>
            <input name="" id="" type="text" placeholder="Enter complete address">
            <p class="input-help"></p>

            <div id="loader"><div class="spinner"></div></div>

            <form method="POST">
                <input type="submit" value="Apply">
            </form>

            <form id="update-gig-details-form" method="POST">
                <input type="submit" value="Update">
            </form>
        </div>

        <div class="side">
            <!-- <button id="view-applicants-btn" type="button"><a href="./view-applicants?g=">View Applicants</a></button>
            <button id="edit-btn" class="outline-btn" type="button">Edit</button>

            <form method="POST">
                <input id="close-gig-btn" class="outline-btn" type="submit" value="Close Gig">
            </form> -->
        </div>
    </div>
    
</div>

<script>
    // Edit Button
    const editBtn = document.querySelector('#edit-btn');
    editBtn.addEventListener('click', () => {
        if (editBtn.innerHTML === 'Edit') {
            document.querySelector('h1').style.display = 'none';

            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'none';
            });

            document.querySelector('.gig-title-label').style.display = 'block';
            document.querySelectorAll('input[type=text]').forEach(inputText => {
                inputText.style.display = 'block';
            });
            document.querySelectorAll('input[type=number]').forEach(inputNumber => {
                inputNumber.style.display = 'inline-block';
            });
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.style.display = 'block';
            });
            document.querySelectorAll('select').forEach(select => {
                select.classList.add('show');
            });
            document.querySelector('#update-gig-details-form').style.display = 'block';

            editBtn.innerHTML = 'Cancel';
        } else {
            document.querySelector('h1').style.display = 'block';

            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'block';
            });

            document.querySelector('.gig-title-label').style.display = 'none';
            document.querySelectorAll('input[type=text]').forEach(inputText => {
                inputText.style.display = 'none';
            });
            document.querySelectorAll('input[type=number]').forEach(inputNumber => {
                inputNumber.style.display = 'none';
            });
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.style.display = 'none';
            });
            document.querySelectorAll('select').forEach(select => {
                select.classList.remove('show');
            });
            document.querySelector('#update-gig-details-form').style.display = 'none';

            editBtn.innerHTML = 'Edit';
        }
    });


</script>

<?php
    include './partials/footer.php';
?>
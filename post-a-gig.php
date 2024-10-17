<?php
    $title= 'Post a gig';
    include './partials/header.php'
?>

<div class="container">
    <form method="POST">
        <!-- Gig Title -->
        <h3 class="input-label">Gig Title</h3>
        <input name="" id="" type="text" placeholder="Examples: English Tutor, Graphic Designer, Social Media Manager, etc...">
        <p class="input-help"></p>

        <!-- Duration -->
        <h3 class="input-label">How long will the student be required to work?</h3>
        <input class="short-input" type="number" min="1" value="1" step="1">
        <select class="short-select" name="" id="">
            <option value="days">day(s)</option>
            <option value="weeks">week(s)</option>
            <option value="months">month(s)</option>
        </select>
        <p class="input-help"></p>

        <!-- Description -->
        <h3 class="input-label">Description</h3>
        <textarea name="" id="" placeholder="Provide some description about the gig..."></textarea>
        <p class="input-help"></p>

        <!-- Preferred Skills -->
        <h3 class="input-label">Preferred Skills</h3>
        <textarea name="" id="" placeholder="What are the skills that the student should preferably have?"></textarea>
        <p class="input-help"></p>

        <!-- Schedule/Time Commitment -->
        <h3 class="input-label">Schedule/Time Commitment</h3>
        <textarea name="" id="" placeholder="Examples:
1) 9:00 PM to 11:30 PM (Mon, Wed, Fri)
2) Flexible Schedule (work on your own time)
3) Submit weekly reports every Friday, with flexible working hours"></textarea>
        <p class="input-help"></p>

        <!-- Payment Information -->
        <h3 class="input-label">Payment Information</h3>
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
        <select name="" id="">
            <option value="remote">Remote</option>
            <option value="onsite">Onsite</option>
            <option value="hybrid">Hybrid</option>
        </select>
        <input name="" id="" type="text" placeholder="Enter complete address">
        <p class="input-help"></p>

        <div id="loader"><div class="spinner"></div></div>
        <input type="submit" value="Post Gig">
    </form>
</div>

<script>

</script>

<?php
    include './partials/footer.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>StudentGig - <?php echo $title; ?></title>

        <!-- External CSS -->
        <link rel="stylesheet" href="./css/style.css">
        <?php if (isset($css_file_name)) { ?>
            <link rel="stylesheet" href="./css/<?php echo $css_file_name; ?>.css">
        <?php } ?>

        <!-- Remix Icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css" integrity="sha512-MqL4+Io386IOPMKKyplKII0pVW5e+kb+PI/I3N87G3fHIfrgNNsRpzIXEi+0MQC0sR9xZNqZqCYVcC61fL5+Vg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body>
        <nav>
            <a href="./">
                <img class="website-logo" src="./images/studentgig-logo-cropped.png" alt="StudentGig logo">
            </a>

            <ul>
                <li><a class="special-link" href="./post-a-gig"><i class="ri-edit-fill"></i> Post a Gig</a></li>
                <li><a href="./login">Login</a></li>
                <li><a href="./signup">Signup</a></li>
            </ul>
        </nav>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Poppins:wght@200;300&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL; ?>/css/participant/style.css">

</head>

<body>
    <nav class="nav shadow bg-royal fixed-top">
        <button class="btn btn-royal btn-sidenav" data-target="side-nav">+</button>

        <ul class="side-nav" id="side-nav">
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Participant/tryOut">My Try Out</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Participant/forum">My Forum</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Participant/myClass">My Class</a></li>
        </ul>

        <!-- Navbar -->
        <ul class="mx-auto">
            <li class="nav-item text-gold"><a href="<?= BASE_URL; ?>/Participant" class="nav-link">SIAPKULIAH.COM</a>
            </li>
        </ul>
        <ul class="ml-auto">
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Participant/message">Message</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Participant/profile">My Profile</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Participant/logout">Logout</a>
            </li>
        </ul>
    </nav>
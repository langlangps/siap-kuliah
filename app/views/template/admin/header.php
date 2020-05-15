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
    <link rel="stylesheet" href="<?= BASE_URL; ?>/css/admin/style.css">

</head>

<body>
    <nav class="nav shadow bg-royal fixed-top">
        <button class="btn btn-sidenav btn-gold" data-target="side-nav">+</button>


        <?php if (isset($_SESSION['admin']['org_id'])) : ?>
        <!-- Side Nav -->
        <ul class="side-nav" id="side-nav">
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Admin/toManager">Kelola Try Out</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Admin/orgManager">Kelola Organisasi</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Admin/statistics">Statistik</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Admin/orgAuth">Pilih Organisasi</a></li>
        </ul>
        <?php else : ?>
        <ul class="side-nav" id="side-nav">
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Admin/orgAuth">Pilih Organisasi</a></li>
        </ul>
        <?php endif; ?>


        <!-- Navbar -->
        <ul class="mx-auto">
            <li class="nav-item"><a class="nav-link text-gold" href="<?= BASE_URL ?>/Admin/">SIAPKULIAH.COM</a></li>
        </ul>
        <ul class="ml-auto">
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Admin/message">Message</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Admin/logout">Logout</a>
            </li>
        </ul>
    </nav>
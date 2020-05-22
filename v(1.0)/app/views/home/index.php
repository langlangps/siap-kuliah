<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/home/style.css">
</head>

<body class="bg-gradient-royal">
    <nav class="nav shadow bg-royal fixed-top">

        <!-- Navbar -->
        <ul class="mr-auto">
            <li class="nav-item text-white">SiapKuliah</li>
        </ul>
        <ul class="ml-auto">
            <li class="nav-item"><a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Auth/">Login</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Auth/signup">Sign Up</a>
            </li>
        </ul>
    </nav>
    <div class="jumbotron shadow mt-4 flex flex-column justify-content-center">
        <h1 class="display-2 text-center title" id="siapkuliah">SiapKuliah.com</h1>
        <a href="<?= BASE_URL; ?>/Auth/login" class="btn btn-reverse-gold">Join Us</a>
    </div>
    <div class="container">
        <div class="row">
            <div class="home-card col-3 offset-2 text-white">
                <h1 class="header display-4 text-gold">Cari Try Out</h1>
                Kini, kamu bisa mencari berbagai jenis Try Out baik itu Try Out Kedinasan, PTN, UN, dan lainnya. Cari
                sesuai kebutuhan dan keinginanmu bersama SiapKuliah.com
            </div>
        </div>
        <div class="row">
            <div class="home-card col-3 offset-5 text-white">
                <h1 class="header display-4 text-gold">Flexible</h1>
                Dimanapun, kapanpun, siapapun, apapun try outnya, semua bisa didapat di SiapKuliah.com. Cari, nikmati,
                kerjakan, terima hasilnya dalam satu aplikasi
            </div>
        </div>
        <div class="row">
            <div class="home-card col-3 offset-2 text-white">
                <h1 class="header display-4 text-gold">Ciptakan Try Out Sendiri</h1>
                Bekerja sama dengan orang lain dalam satu organisasi untuk menciptakan try out mu sendiri? Kini semua
                bisa dilakukan dengan siapkuliah.com
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-8 offset-1">
                <div id="about" class="text-white">
                    <h1 class="display-2 text-center text-gold">SiapKuliah.com v1.0</h1>
                    <h1 class="text-center">langlangps</h1>
                    <p class="text-center">SiapKuliah.com adalah wadah untuk para pelajar di Indonesia agar dapat
                        melatih dan melakukan simulasi terhadap ujian perguruan tinggi. Selain itu, SiapKuliah.com juga
                        memberikan kesempatan bagi setiap individu maupun organisasi untuk menciptakan try out sesuai
                        keinginan</p>
                    <p class="text-center">Dikembangkan saat 2020 ini, siapKuliah.com diharapkan dapat digunakan
                        semaksimal mungkin oleh berbagai kalangan.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
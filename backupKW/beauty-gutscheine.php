<?php
include 'database/database.php';
$db = Database::conncect();
$fair = 2;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Messe-Gutscheine Graz</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.4/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/stylesBeauty.css" rel="stylesheet" />
    <link href="css/stylesCupon.css" rel="stylesheet" />
    <script src="js/scripts.js"></script>
    <script src="js/countdownBeauty.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="css/countdownBeauty.scss">
    <link rel="icon" href="assets/img/messeRel.jpeg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container px-4 px-lg-5">
            <img class="navbar-brand" src="assets/img/messelogo.png" alt="Logo" width="15%">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#Gutschein">Gutschein</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://mcg.at/events/trends-of-beauty/" target="_blank">Messe</a></li>
                    <!--<li class="nav-item"><a class="nav-link" href="https://mcg.at/events/trends-of-beauty/#Programm" target="_blank">Zum Programm</a></li>-->
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-center">

                    <!--
                        Text vom Bild in der Mitte    
                        <h1 class="mx-auto my-0 text-uppercase">Messe Graz</h1>
                        <h2 class="text-white-50 mx-auto mt-2 mb-5">Gutscheine, freie Fahrten und vieles mehr ... </h2>
                        <a class="btn btn-primary" href="#Gutschein">Hol dir deinen Gutschein</a>-->
                </div>
            </div>
        </div>
    </header>
    <!--Shape Divider -->
    <div class="custom-shape-divider-top-1675247421" style="background-color: black;">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
        </svg>
    </div>



    <!-- About-->
    <section class="about-section text-center">
        <!--<div class="container" style="color: white;">
            <a style="color: white" href="https://mcg.at/events/fruehjahrsmesse/" target="_blank">
                <h1 class="font-header">WANN STARTET DIE <span style="color: #b96378;">TRENDS OF BEAUTY</span> 2024?</h1>
            </a>
            <div id="countdown">
                <ul>
                    <li class="countdownli font-text"><span class="countdownspan font-text" id="days"></span>TAGE</li>
                    <li class="countdownli font-text"><span class="countdownspan font-text" id="hours"></span>STUNDEN
                    </li>
                    <li class="countdownli font-text"><span class="countdownspan font-text" id="minutes"></span>MINUTEN
                    </li>
                    <li class="countdownli font-text"><span class="countdownspan font-text" id="seconds"></span>SEKUNDEN
                    </li>
                </ul>
            </div>
        </div>
        <br><br>-->

        <!--Schrift Effekt
        <div class="schriftanimation d-flex justify-content-center">
            <div class="animation"  style="display: flex; align-items: center;">
                <a href="https://mcg.at/events/fruehjahrsmesse/#GEWINNSPIEL">
                    <h1 style="width: 100%;" class="font-header">ZUM GEWINNSPIEL</h1>
                </a>
            </div>
        </div>-->
        <!--Ende Schrift Effekt-->

        <h2 class="text-white mb-4 font-header dagutscheine" id="Gutschein"><u>SAVE THE DATE: Bald sind hier deine GUTSCHEINE</u></h2>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 Gutschein">
                    <p class="font-text">
                        Hier findest du attraktive Gutscheine von ausgewählten Aussteller:innen. Ganz einfach den Gutschein beim gewünschten Stand vorzeigen und von tollen Messeangeboten profitieren. Super clever. Super smart. Einfach Trends of Beauty Graz.
                    </p>
                </div>
                <hr style="border: 1px solid white; width: 50%;">
            </div>
        </div><br><br>
        <!--<div class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">Filter</button>
            <ul class="dropdown-menu" id="list">
                <li><a class='dropdown-item active' id='0' onclick='filterCupons(0);'>Alle Gutscheine</a></li>
                <?php
                /*echo $db->getCategoryLiTag($fair);*/
                ?>
            </ul>
        </div>-->
        </div>
        <br><br>

        <!--<div class="card-group container justify-content-center">
            <?php
            /*echo $db->getCuponImage($fair);*/
            ?>
        </div>-->

        <br><br>

        <br><br>
    </section>

    <!-- Footer-->
    <footer class="footer bg-black small text-center text-white-50">
        <a href="https://www.facebook.com/Kosmetikfachmesse" target="_blank" title="facebook"><iconify-icon icon="ic:baseline-facebook" style="color: white;" width="75" height="75"></iconify-icon></a>
        <a href="https://www.instagram.com/trendsofbeauty_graz/" target="_blank" title="instagram"><iconify-icon icon="ph:instagram-logo-fill" style="color: white;" width="75" height="75"></iconify-icon></a>
        <br>
        <br>
        <p>Messe Graz</p>
        <br>
        <br>
        <div class="container px-4 px-lg-5">Copyright &copy; Manuel Bodlos, Gabriel Haikal, Roman Lanschützer, Christoph Kohlweg 2022
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->

    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>
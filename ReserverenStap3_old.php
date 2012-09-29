<?php
include_once '/icepay/icepay.php';

$filmpjeIdeal = new FilmpjeIdeal();

$icepayInfo = $filmpjeIdeal->ParseReservernPostValues($_POST);
?>

<!doctype html>

<html lang="nl">

    <head> 
        <meta charset="utf-8" />
        <title>Filmpje</title>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/reserveren.css"> 
        <script>
    
            ​</script>

        <meta name="description" content="Filmpje, Bioscoop">
        <meta name="keywords" content="">

        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Modrnizr.com -->

    </head>

    <body>
        <div id="wrapper">

            <img src="image/Logo.png" />


            <section class="content">
                <nav>
                    <ul id="menu">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#">Films</a>
                            <ul class="submenu">
                                <li><a href="#">Films binnekort</a></li>
                                <li><a href="#">Films vandaag</a></li>
                                <li><a href="#">Alle films</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Informatie</a>
                            <ul class="submenu">
                                <li><a href="#">Routebeschrijving</a></li>
                                <li><a href="#">Events</a></li>
                                <li><a href="#">Hoe kom ik er?</a></li>
                                <li><a href="#">Prijzen</a></li>
                            </ul>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </nav>
            </section>
            <br>
            <br>
            <hr>
            <div id="ReserverenMainContent">    
                <div id="CoverAndMovieInfo">
                    <img src="image/cover.jpg" id="coverImage" alt="Cover">
                    <br>
                    <br>
                    <p>        
                        <span class="filmtitel">The planet of the apes</span><br>
                        <span style="margin-left: 10px;">☆</span><span>☆</span><span>☆</span><span>☆</span><br>
                        <span class="filmtijd">16-2-2012 - 13:00 UUR</span><br>
                        <span class="filmbeschrijving">Een geweldige film met apen.</span><br>
                    </p>
                </div>
                <div id="IdealBetaling">
                    <h2>IDEAL Betaling.</h2>
                    <p>
<?php
try {
    $filmpjeIdeal->Pay($icepayInfo['amount'], $icepayInfo['reference'], $icepayInfo['description'], $icepayInfo['issuer'], $icepayInfo['orderId']);
} catch (Exception $e) {
    $error = $e->getMessage(); //blaat
}
if (isset($url)) {
?>
              <iframe class="icepayframe" src="<?php echo $url; ?>">
                        <?php
                        }
                        if (isset($error)) {
                            echo 'Error: ' . $error;
                        }
                        ?>
                </div> 
            </div>
            <footer>
                <hr />
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="films.html">Films</a></li>
                    <li><a href="informatie.html">Informatie</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </footer>
        </div>
    </body>

</html>

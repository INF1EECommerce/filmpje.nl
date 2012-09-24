<!doctype html>

<html lang="nl">

<head>

   <meta charset="utf-8" />
   <title>Filmpje</title>
   <link rel="stylesheet" href="css/main.css">
   <link rel="stylesheet" href="css/reserveren.css">
   <?php include_once '/icepay/icepay.php' ?>;
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
            <span>☆</span><span>☆</span><span>☆</span><span>☆</span><br>
            <span class="filmtijd">16-2-2012 - 13:00 UUR</span><br>
            <span class="filmbeschrijving">Een geweldige film met apen.</span><br>
        </p>
    </div>
    <div id="PrijzenEnForm">
        <div id="ReserverenHeader">
        <h1>Reservering afronden</h1>
        The planet of the apes - 16-2-2010 - 13:00 UUR
        </div>
        <div id="StoelPrijzen">
            <h2>Ticketoverzicht</h2>    
            <table>
                <thead>
                <th>Stoel</th><th>Prijs</th>
                </thead>
                <tbody>
                    <tr><td>12</td><td>15</td></tr>
                    <tr><td>25</td><td>15</td></tr>
                    <tr><td>12</td><td>15</td></tr>
                    <tr><td>25</td><td>15</td></tr>
                    <tr><td>12</td><td>15</td></tr>
                    <tr><td>25</td><td>15</td></tr>
                    <tr><td>&nbsp;</td></tr>
                </tbody>
                <tfoot>

                    <tr><td>Totaal:</td><td>150</td></tr>
                </tfoot>
            </table>
            
        </div>
        <div id="formulier">
        <h2>Uw contactinformatie:</h2>
        <form method="POST" id="ReserverenForm" action="ReserverenStap3.php">
            <table>
                <tr>
                    <td><label>Voornaam:</label></td>
                    <td><input type="text" value="" name="voornaam"><td>
            </tr>
            <tr>
                <td><label>Achternaam:</label></td>
                <td><input type="text" value="" name="achternaam"></td>
            </tr>
            <tr>
                <td><label>Adres:</label></td>
                <td><input type="text" value="" name="adres"></td>
            </tr>
            <tr>
                <td><label>Postcode:</label></td>
                <td><input type="text" value="" name="postcode"></td>
            </tr>
            <tr>
                <td><label>Email:</label></td>
                <td><input type="text" value="" name="email"></td>
            </tr>
            <tr>
                <td><label>Telefoon:</label></td>
                <td><input type="text" value="" name="telefoon"></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
            
                <td><label>Uw bank:</label></td>
                <td><select name="bank">
                <option>ABN-Amro</option>
                <option>ING</option>
                <option>Rabobank</option>
            </select>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td><input type="hidden" name="payurl" value="<?php FilmpjeIDeal ?>">
                    <input type="hidden" name="amount" value="15.00">
                    <input type="submit" value="Bestelling plaatsen"></td>
        </table>
        </form>
        </div>
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

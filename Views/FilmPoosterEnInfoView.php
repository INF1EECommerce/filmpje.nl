<?php
class FilmPoosterEnInfoView
{
    public function FilmPoosterEnInfoView()
    {
        require_once('backend/DBFunctions.php');
        //require_once('/backend/DBFunctions.php');
    }
    
    public function Render($voortstelling)
    {
        $dbfunctions = new DBFunctions();
        
        $film = $dbfunctions ->FilmInfoVanVoorstelling($voortstelling);
        
           $kijwijzericonen = explode(",",$film['Kijkwijzer']);
        $kijkwijzerhtml = "";
        
        foreach ($kijwijzericonen as $icon) {
            $kijkwijzerhtml .= "<img class=\"kijkwijzer\" src=\"image/".$icon.".png\"/>";
        }
        
        
        echo ("
        <div id=\"filmPoosterEnInfo\">
                <p class=\"blockheader\">Uw film</p>
                <img class=\"pooster\" src=\"image/Covers/". $film['Cover']."\">
                <div id=\"filmInfo\">
                    <h2>". $film['Naam'] ."</h2>
                    <strong>Tijd: </strong>".substr($film['Tijd'], 0,5)." UUR <br>
                    <strong>Datum: </strong>".date("d-m-Y", strtotime($film['Datum']))."<br><br>    
                    <strong>Duur: </strong>". $film['Duur'] ." minuten.<br>
                    <strong>Genre: </strong>". $film['Genre'] ."<br>
                    <strong>Regisseur: </strong>".$film['Regisseur'] ."<br>
                    <strong>IMDB: </strong>".$film['Beoordeling'] ."<br>
                    <p>". $film['KorteBeschrijving']."</p>
                    ".$kijkwijzerhtml ."
                </div>
         </div>
       ");
        
    }
    
     public function RenderVoorFilm($filmdata)
    {

        
        $kijwijzericonen = explode(",",$filmdata['Kijkwijzer']);
        $kijkwijzerhtml = "";
        
        foreach ($kijwijzericonen as $icon) {
            $kijkwijzerhtml .= "<img class=\"kijkwijzer\" src=\"image/".$icon.".png\"/>";
        }
        
        
        echo ("
        <div id=\"filmPoosterEnInfo\">
                <p class=\"blockheader\">".$filmdata['Naam']."</p>
                <img class=\"pooster\" src=\"image/Covers/". $filmdata['Cover']."\">
                <div id=\"filmInfo\">
                    <h2>". $filmdata['Naam'] ."</h2>
                    <strong>Duur: </strong>". $filmdata['Duur'] ." minuten.<br>
                    <strong>Genre: </strong>". $filmdata['Genre'] ."<br>
                    <strong>Regisseur: </strong>".$filmdata['Regisseur'] ."<br>
                    <strong>IMDB: </strong>".$filmdata['Beoordeling'] ."<br><br>
                    ".$kijkwijzerhtml ."
                </div>
         </div>
       ");
        
    }
    
    public function RenderVoorPopup($voorstelling)
    {
            $dbfunctions = new DBFunctions();
        
        $film = $dbfunctions ->FilmInfoVanVoorstelling($voorstelling);
        
        echo ("
        <div id=\"TitleTijdPopup\">
        <h2>". $film['Naam'] ."  - ".$film['Datum']." -  ".substr($film['Tijd'], 0,5)." uur - ". $film['ZaalNaam'] ."</h2>        
        <div id=\"PopupCover\">
        <img src=\"image/Covers/". $film['Cover']."\">  
        </div>
        <div id=\"filmInfoPopup\">
                    Duur: ". $film['Duur'] ." minuten 
                    <p>". $film['KorteBeschrijving'] ."</p></div>
                </div>
         </div>
       <form action=\"\" method=\"POST\" id=\"PopUpForm\">
       <input type=\"hidden\" name=\"Naam\" value=\"".$film['Naam']."\">
       <input type=\"hidden\" name=\"Tijd\" value=\"".$film['Tijd']."\">
       <input type=\"hidden\" name=\"ZaalNaam\" value=\"".$film['ZaalNaam']."\">
       <input type=\"hidden\" name=\"Datum\" value=\"".$film['Datum']."\">
       <input type=\"hidden\" name=\"KorteBeschrijving\" value=\"".$film['KorteBeschrijving']."\">
       <input type=\"hidden\" name=\"Duur\" value=\"".$film['Duur']."\">  
       <input type=\"hidden\" name=\"cover\" value=\"".$film['Cover']."\">
       <input type=\"submit\" name=\"submit\" value=\"Event aanmaken\">
       ");
    }
}
?>

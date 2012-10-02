<?php
class FilmPoosterEnInfoView
{
    public function FilmPoosterEnInfoView()
    {
        require_once('/backend/DBFunctions.php');
    }
    
    public function Render($voortstelling)
    {
        $dbfunctions = new DBFunctions();
        
        $film = $dbfunctions ->FilmInfoVanVoorstelling($voortstelling);
        
        echo ("
        <div id=\"filmPoosterEnInfo\">
                <p class=\"blockheader\">Uw film</p>
                <img src=\"image/Covers/". $film['Cover']."\">
                <div id=\"filmInfo\">
                    <h2>". $film['Naam'] ."</h2>
                    Duur: ". $film['Duur'] ." minuten.
                    <p>". $film['KorteBeschrijving'] ."</p>
                    <div id=\"tijdEnZaal\">" . substr($film['Tijd'], 0,5) ." uur<br>
                    ". $film['ZaalNaam'] ."<br></div>
                </div>
       </div>
       ");
        
    }
}
?>

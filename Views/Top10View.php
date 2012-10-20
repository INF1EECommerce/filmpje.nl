<?php
class Top10View {
    public function  Top10View()
    {
        include_once 'backend/DBFunctions.php';
    }
    
    public function Render()
    {
        $dbFunctions = new DBFunctions();
        
        $top10films = $dbFunctions->HaalTop10FilmsOp();
        
        echo("
          <ul id=\"top10list\">
                    <li id=\"top10header\"><p>Top 10 films</p></li>
                        ");
        $i = 1;
        foreach ($top10films as $film) {
            
        echo ("
                    <li onclick=\"window.location='films.php?filmid=".$film['FilmID']."'\"><button onclick=\"window.location='films.php?filmid=".$film['FilmID']."'\">".$i."</button>".$film['FilmNaam']."</li>
        ");
        $i++;
        }
        
        echo ("</ul>");
    }
}

?>

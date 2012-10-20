<?php
/**
 * Description of CarouselView
 *
 * @author Chivan
 */
class CarouselView {
    //put your code here

    var $banners;
    
    
    public function CarouselView()
    {
        include_once 'backend/DBFunctions.php';
        $dbFunctions = new DBFunctions();
        $this->banners = $dbFunctions->HaalBannersOp();
    }
    
    
    public function Render() {
        
        if (count($this->banners) != 0) {
         
        echo ("    
        <div class=\"container\">
            <div class=\"wt-rotator\">
                <div class=\"screen\">
                    <noscript>
                        <!-- placeholder 1st image when javascript is off -->
                        <img src=\"image/logo.png\" alt=\"Logo\"/>
                    </noscript>
                </div>
                <div class=\"c-panel\">
                        <div class=\"thumbnails\">
                        <ul>");
        
        foreach ($this->banners as $banner) {
            
        echo("
                            <li>
                                <a href=\"image/Rotator/".$banner['Banner']."\" title=\"".$banner['Naam']."\"></a>
                                <a href=\"films.php?filmid=".$banner['FilmID']."\"></a>                        
                                <div style=\"top:160px; left:0px; width:640px; color:#FFF; background-color:#000;\">
                                   <h1><a href=\"films.php?filmid=".$banner['FilmID']."\">".$banner['Naam']."</a></h1>
                                </div>
                            </li> 
             ");
        }
        echo ("
                        </ul>
                        </div>     
                       <div class=\"buttons\">
                        <div class=\"prev-btn\"></div>
                        <div class=\"play-btn\"></div>    
                        <div class=\"next-btn\"></div>               
                    </div>
                </div>
            </div>	
        </div>");
            
            
            
        }
        
    }
    
    
}

?>

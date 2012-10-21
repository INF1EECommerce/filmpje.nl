<?php
class SpecialGalleryView {
   
    public function Render($special)
    {
        echo ("
            <div id=\"SpecialFotos\">
            <p class=\"blockheader\" style=\"margin-bottom:0px;\">Foto's</p><div id=\"gallery\">");  
    		   
	$filesLarge = glob('image/Specials/'.$special.'/*.{jpg,png,gif}', GLOB_BRACE);
                foreach($filesLarge as $file) {
                echo ("<img src=\"".$file."\" />");
               }       

       echo ("
        </div>        
       <div id=\"thumbs\">");
    	$fileSmall = glob('image/Specials/'.$special.'/Thumbs/*.{jpg,png,gif}', GLOB_BRACE);
                foreach($fileSmall as $file2) {   	   
       echo ("
                    <img height=\"100\" src=\"".$file2."\" />   
               ");	        

               
    }
           echo ("</div>
       <div id=\"next\">&nbsp;</div></div>");
    }
    
}
?>

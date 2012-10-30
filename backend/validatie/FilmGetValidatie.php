<?php
class FilmGetValidatie {

    public function FilmGetValidatie()
    {
        include_once 'backend/Films.php';
    }
    
    public function Valideer($getWaardes)
    {
        if (!isset($getWaardes['filmid']) || !is_numeric($getWaardes['filmid'])) {
            throw new Exception("FilmID is niet gezet of is geen nummer.");
        }
        
       $films = new Films();
       
       if (!$films->BestaatFilm($getWaardes['filmid'], TRUE)) {
           throw new Exception("Deze film komt niet voor in de database.");
       }
       
       $result = array();
       $result['FilmID'] = intval($getWaardes['filmid']);
       $result['Filminfo'] = $films->FilmInfo(intval($getWaardes['filmid']), TRUE);
       
       return $result;
    }
    
}

?>

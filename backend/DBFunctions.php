<?php

class DBFunctions
{
  var $connection;
  
  function DBFunctions()
  {
      require_once(dirname(__FILE__).'/DBConnection.php');
      
      $this-> connection = new DBConnection();
  }
  
  public function FilmsMetVoorstellingenKomendeXDagen($dagenPlusMin)
  {
        if (!is_int($dagenPlusMin)) {
          throw new Exception("dagenPlusMin is geen nummer.");
      }
      
      $this -> connection -> dbConnect();
      $query = mysql_query("SELECT  DISTINCT films.Naam AS FilmNaam, films.FilmID AS FilmID
                            FROM films
                            INNER JOIN voorstellingen on voorstellingen.FilmID = films.FilmID
                            WHERE voorstellingen.Datum <= DATE_ADD(NOW(), INTERVAL + " . $dagenPlusMin . " DAY)
                            ORDER BY films.naam") or die (mysql_error());
      $result = array(); 
      
     while ($row = mysql_fetch_array($query)) {
     
         $result[] = $row;
         
     }
      $this -> connection -> dbClose();
      return $result;
  }
  
//  public function VoorstellingenVanFilmInKomendeXDagen($filmID, $dagenPlusMin)
//  {
//              if (!is_int($dagenPlusMin)) {
//          throw new Exception("dagenPlusMin is geen nummer.");
//      }
//      
//        $this -> connection -> dbConnect();
//      $query = mysql_query("SELECT voorstellingen.VoorstellingID AS VoorstellingID, 
//                            voorstellingen.Datum AS VoorstellingDatum,
//                            voorstellingen.Tijd AS VoorstellingTijd,
//                            voorstellingen.FilmID AS FilmID 
//                            FROM voorstellingen
//                            WHERE voorstellingen.FilmID = " . $filmID ."
//                            AND voorstellingen.Datum <= DATE_ADD(NOW(), INTERVAL + ". $dagenPlusMin ." DAY)") or die (mysql_error());
//      $result = array(); 
//      
//     while ($row = mysql_fetch_array($query)) {
//     
//         $result[] = $row;
//         
//     }
//      $this -> connection -> dbClose();
//      return $result;
//  }
  
  
  public function StoelInfo($stoelnummers)
  {
      
      if (!strlen($stoelnummers) > 0) {
          throw new Exception("stoelnummer kan niet leeg zijn.");
      }
      
      
      $this -> connection -> dbConnect();
      $query = mysql_query("SELECT stoelen.Nummer AS StoelNummer, rijen.Nummer AS RijNummer, stoelTypes.Naam AS StoelType, stoelTypes.Prijs AS StoelPrijs FROM stoelen 
          INNER JOIN stoeltypes on stoeltypes.StoelTypeID = stoelen.StoelTypeID     
          INNER JOIN rijen on rijen.RijID = stoelen.RijID
          WHERE stoelen.StoelID IN (
      " . $stoelnummers . "
      )") or die (mysql_error());
      $result = array(); 
      
     while ($row = mysql_fetch_array($query)) {
     
         $result[] = $row;
         
     }
      $this -> connection -> dbClose();
      return $result;
  }
  
  public function AlleVoorstellingen()
  {
      $this -> connection -> dbConnect();
      $query = mysql_query("SELECT Films.FilmID, films.Naam, voorstellingen.VoorstellingID, voorstellingen.Datum, voorstellingen.Tijd 
          FROM films 
          INNER JOIN voorstellingen ON voorstellingen.FilmID = films.FilmID") or die (mysql_error());
      $result = array(); 
      
     while ($row = mysql_fetch_array($query)) {
     
         $result[] = $row;
         
     }
      $this -> connection -> dbClose();
      return $result;
  }
  
  public function VoorstellingenKomendeXDagen($dagenPlusMin)
  {
      if (!is_int($dagenPlusMin)) {
          throw new Exception("dagenPlusMin is geen nummer.");
      }
      
      $this -> connection -> dbConnect();
      $query = mysql_query("SELECT 
                            Naam AS FilmNaam,
                            voorstellingen.VoorstellingID AS VoorstellingID,
                            voorstellingen.Datum AS VoorstellingDatum,
                            voorstellingen.Tijd AS VoorstellingTijd
                            FROM films
                            INNER JOIN voorstellingen on voorstellingen.FilmID = films.FilmID
                            WHERE voorstellingen.Datum <= DATE_ADD(NOW(), INTERVAL + ". $dagenPlusMin . " DAY)
                            ORDER BY films.naam, voorstellingen.Datum, voorstellingen.Tijd") or die (mysql_error());
      $result = array(); 
      
     while ($row = mysql_fetch_array($query)) {
     
         $result[] = $row;
         
     }
      $this -> connection -> dbClose();
      return $result;
  }
  
  public function BeschikbareStoelenVoorVoorstelling($voorstelling)
  {
      $this -> connection -> dbConnect();
      $query = mysql_query("SELECT stoelen.StoelID, stoelen.Nummer AS StoelNummer, rijen.Nummer AS RijNummer, stoeltypes.Naam AS StoelType 
                            FROM voorstellingen
                            INNER JOIN zalen ON zalen.ZaalID = voorstellingen.ZaalID
                            INNER JOIN stoelen ON stoelen.ZaalID = zalen.ZaalID
                            INNER JOIN stoeltypes ON stoeltypes.StoelTypeID = stoelen.StoelTypeID
                            INNER JOIN rijen ON rijen.RijID = stoelen.RijID
                            WHERE stoelen.StoelID NOT IN 
                            (
                                SELECT StoelID FROM bestellingstoelen
                                INNER JOIN bestellingen on bestellingen.BestellingID = bestellingstoelen.BestellingID AND bestellingen.BestellingStatusID = 3 
                                AND bestellingen.VoorstellingID = " . $voorstelling . "
                            )
                            AND voorstellingen.VoorstellingID = " . $voorstelling . " ") 
              or die (mysql_error());
     
     $result = array(); 
      
     while ($row = mysql_fetch_array($query)) {
     
         $result[] = $row;
         
     }
      $this -> connection -> dbClose();
      return $result;
  }
  
    public function ZaalInfo($voorstelling)
  {
      $this -> connection -> dbConnect();
      $query = mysql_query("SELECT zalen.Rijen, zalen.MaxStoelenPerRij 
                            FROM voorstellingen
                            INNER JOIN zalen ON zalen.ZaalID = voorstellingen.ZaalID
                            AND voorstellingen.VoorstellingID = " . $voorstelling . " ") 
              or die (mysql_error());
     
     $result = array(); 
      
     while ($row = mysql_fetch_array($query)) {
     
         $result[] = $row;
         
     }
      $this -> connection -> dbClose();
      return $result;
  }
       
}


?>

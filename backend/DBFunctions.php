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
      $query = mysql_query("SELECT Stoelen.Nummer AS StoelNummer, Rijen.Nummer AS RijNummer, StoelTypes.Naam AS StoelType, StoelTypes.Prijs AS StoelPrijs FROM Stoelen 
          INNER JOIN StoelTypes on StoelTypes.StoelTypeID = Stoelen.StoelTypeID     
          INNER JOIN Rijen on Rijen.RijID = Stoelen.RijID
          WHERE Stoelen.StoelID IN (
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
      $query = mysql_query("SELECT Films.FilmID, Films.Naam, Voorstellingen.VoorstellingID, Voorstellingen.Datum, Voorstellingen.Tijd 
          FROM Films 
          INNER JOIN Voorstellingen ON Voorstellingen.FilmID = Films.FilmID") or die (mysql_error());
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
      $query = mysql_query("SELECT Stoelen.StoelID, Stoelen.Nummer AS StoelNummer, Rijen.Nummer AS RijNummer, StoelTypes.Naam AS StoelType 
                            FROM Voorstellingen
                            INNER JOIN Zalen ON Zalen.ZaalID = Voorstellingen.ZaalID
                            INNER JOIN Stoelen ON Stoelen.ZaalID = Zalen.ZaalID
                            INNER JOIN StoelTypes ON StoelTypes.StoelTypeID = Stoelen.StoelTypeID
                            INNER JOIN Rijen ON Rijen.RijID = Stoelen.RijID
                            WHERE Stoelen.StoelID NOT IN 
                            (
                                SELECT StoelID FROM BestellingStoelen
                                INNER JOIN Bestellingen on Bestellingen.BestellingID = BestellingStoelen.BestellingID AND Bestellingen.BestellingStatusID = 3 
                                AND Bestellingen.VoorstellingID = " . $voorstelling . "
                            )
                            AND Voorstellingen.VoorstellingID = " . $voorstelling . " ") 
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
      $query = mysql_query("SELECT Zalen.Rijen, Zalen.MaxStoelenPerRij 
                            FROM Voorstellingen
                            INNER JOIN Zalen ON Zalen.ZaalID = Voorstellingen.ZaalID
                            AND Voorstellingen.VoorstellingID = " . $voorstelling . " ") 
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

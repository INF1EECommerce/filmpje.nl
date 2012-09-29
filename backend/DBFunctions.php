<?php

class DBFunctions
{
  var $connection;
  
  function DBFunctions()
  {
      require_once(dirname(__FILE__).'/DBConnection.php');
      
      $this-> connection = new DBConnection();
  }
  
  public function StoelInfo($stoelnummers)
  {
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
      $query = mysql_query("SELECT Films.FilmID, Films.Naam, Voorstellingen.VoorstellingID, Voorstellingen.Datum, Voorstellingen.Tijd FROM Films INNER JOIN Voorstellingen ON Voorstellingen.FilmID = Films.FilmID") or die (mysql_error());
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

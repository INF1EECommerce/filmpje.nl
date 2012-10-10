<?php
//update beschikbare stoelen script.
$conf = array
(
    'db_host' => 'localhost',
    'db_user' => 'filmpje',
    'db_pass' => 'filmpje',
    'db_data' => 'filmpje'
);

    
$connection =  mysql_connect($conf['db_host'], $conf['db_user'], $conf['db_pass']) or die(mysql_error());
mysql_select_db($conf['db_data'], $connection) or die(mysql_error());

$sql = "
UPDATE voorstellingen
INNER JOIN zalen on zalen.ZaalID = voorstellingen.ZaalID
SET voorstellingen.BeschikbareStoelen = zalen.AantalStoelen
";

$sql2 = "
UPDATE voorstellingen
INNER JOIN
    (SELECT 
        VoorstellingID, StoelenOver
		FROM
        (SELECT 
			voorstellingen.VoorstellingID,
			zalen.AantalStoelen - (IFNULL(bestelde.BesteldeStoelen, 0) + IFNULL(reserveer.GereserveerdeStoelen, 0)) AS StoelenOver
			FROM
			voorstellingen
			INNER JOIN zalen ON zalen.ZaalID = voorstellingen.ZaalID
			LEFT JOIN 
			    (SELECT 
				voorstellingen.VoorstellingID,
			    COUNT(bestellingstoelen.BestellingStoelID) as BesteldeStoelen
				FROM
				voorstellingen
				INNER JOIN bestellingen ON bestellingen.VoorstellingID = voorstellingen.VoorstellingID AND bestellingen.BestellingStatusID != 4
				INNER JOIN bestellingstoelen ON bestellingstoelen.BestellingID = bestellingen.BestellingID
				GROUP BY voorstellingen.VoorstellingID
				) bestelde ON bestelde.VoorstellingID = voorstellingen.VoorstellingID
			LEFT JOIN
				(
				SELECT gs.VoorstellingID, COUNT(*) AS GereserveerdeStoelen
				FROM (
				SELECT
				voorstellingen.VoorstellingID,
				reserveringen.ReserveringStatusID,
				voorstellingen.Datum,
				voorstellingen.Tijd
				FROM voorstellingen
				INNER JOIN reserveringen on reserveringen.VoorstellingID = voorstellingen.VoorstellingID AND reserveringen.ReserveringStatusID != 3
				INNER JOIN reserveringstoelen on reserveringstoelen.ReserveringID = reserveringen.ReserveringID
				)gs
                WHERE (TIMESTAMP(gs.Datum, gs.Tijd) > TIMESTAMP(DATE_ADD(NOW(), INTERVAL 30 MINUTE)) AND gs.ReserveringStatusID = 1)
                OR (gs.ReserveringStatusID = 2) 
				GROUP BY gs.VoorstellingID
				)reserveer ON reserveer.VoorstellingID = voorstellingen.VoorstellingID
		) extra 
	) extra2 ON extra2.VoorstellingID = voorstellingen.VoorstellingID
SET 
    voorstellingen.BeschikbareStoelen= extra2.StoelenOver;";
        
if (!mysql_query($sql, $connection)) {
    die('Error: ' . mysql_error());
}

if (!mysql_query($sql2, $connection)) {
    die('Error: ' . mysql_error());
}

mysql_close($connection) or die(mysql_error());

?>

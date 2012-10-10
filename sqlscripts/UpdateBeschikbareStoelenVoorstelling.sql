USE filmpje;

UPDATE voorstellingen
INNER JOIN zalen on zalen.ZaalID = voorstellingen.ZaalID
SET voorstellingen.BeschikbareStoelen = zalen.AantalStoelen;


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
    voorstellingen.BeschikbareStoelen= extra2.StoelenOver;


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
			zalen.AantalStoelen - bestelde.BesteldeStoelen AS StoelenOver
			FROM
			voorstellingen
			INNER JOIN zalen ON zalen.ZaalID = voorstellingen.ZaalID
			INNER JOIN 
			    (SELECT 
				voorstellingen.VoorstellingID,
			    COUNT(bestellingstoelen.BestellingStoelID) as BesteldeStoelen
				FROM
				voorstellingen
				INNER JOIN bestellingen ON bestellingen.VoorstellingID = voorstellingen.VoorstellingID
				INNER JOIN bestellingstoelen ON bestellingstoelen.BestellingID = bestellingen.BestellingID
				GROUP BY voorstellingen.VoorstellingID
				) bestelde ON bestelde.VoorstellingID = voorstellingen.VoorstellingID
		) extra 
	) extra2 ON extra2.VoorstellingID = voorstellingen.VoorstellingID
SET 
    voorstellingen.BeschikbareStoelen= extra2.StoelenOver;


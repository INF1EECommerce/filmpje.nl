SELECT voorstellingen.VoorstellingID AS VoorstellingID, 
voorstellingen.Datum AS VoorstellingDatum,
voorstellingen.Tijd AS VoorstellingTijd,
voorstellingen.FilmID AS FilmID 
FROM voorstellingen
WHERE voorstellingen.FilmID = 2
AND voorstellingen.Datum <= DATE_ADD(NOW(), INTERVAL + 3 DAY)

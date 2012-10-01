SELECT 
Naam AS FilmNaam,
voorstellingen.VoorstellingID AS VoorstellingID,
voorstellingen.Datum AS VoorstellingDatum,
voorstellingen.Tijd AS VoorStellingTijd
FROM films
INNER JOIN voorstellingen on voorstellingen.FilmID = films.FilmID
WHERE voorstellingen.Datum <= DATE_ADD(NOW(), INTERVAL + 7 DAY)
ORDER BY films.naam, voorstellingen.Datum, voorstellingen.Tijd

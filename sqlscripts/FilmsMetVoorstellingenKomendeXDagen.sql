SELECT  DISTINCT films.Naam AS FilmNaam, films.FilmID AS FilmID
FROM films
INNER JOIN voorstellingen on voorstellingen.FilmID = films.FilmID
WHERE voorstellingen.Datum <= DATE_ADD(NOW(), INTERVAL + 7 DAY)
ORDER BY films.naam

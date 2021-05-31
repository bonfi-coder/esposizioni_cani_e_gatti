USE esposizioni_cani_e_gatti;

-- Query che ritorna le informazioni sulle iscrizioni a cui partecipano i gatti del proprietario "utente"
SELECT * FROM iscrizioneGatto WHERE gatto IN (
    SELECT IdGatto 
    FROM gatto as G INNER JOIN utente as U ON G.proprietario = U.IdUtente 
    WHERE U.username = "utente"
    );

-- Query che ritorna le informazioni dei concorsi a cui partecipa il gatto "Fulmine";
SELECT C.IdConcorso, C.descrizione, C.categoria, C.luogo, c.data
FROM concorso AS C INNER JOIN iscrizioneGatto AS IG ON C.IdConcorso = IG.concorso 
INNER JOIN gatto as G ON IG.gatto = G.IdGatto
WHERE G.nome = "Fulmine";
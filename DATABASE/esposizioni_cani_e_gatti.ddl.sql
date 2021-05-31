/**
@author: Bonfante Stefano
@version: 1.0 2021-05-30
Schema logico relazionale del database esposizioni_cani_e_gatti
utente(IdUtente, username, password, ruolo) -- PRIMARY KEY(IdUtente)
gatto(IdGatto, nome, genere, razza, immagine, proprietario) -- PRIMARY KEY(IdGatto)
cane(IdCane, nome, genere, razza, immagine, proprietario) -- PRIMARY KEY(IdCane)
concorso(IdConcorso, descrizione, animale, categoria, luogo, data, immagine) -- PRIMARY KEY(IdConcorso)
iscrizioneGatto(concorso, gatto) -- PRIMARY KEY(concorso, gatto)
iscrizioneCane(concorso, cane) -- PRIMARY KEY(concorso, cane)

Vincoli di integrità referenziale tra:
- concorso di iscrizioneGatto e Idconcorso di concorso
- gatto di iscrizioneGatto e IdGatto di gatto
- concorso di iscrizioneCane e Idconcorso di concorso
- cane di iscrizioneCane e IdCane di cane
- proprietario di gatto e IdUtente di utente
- proprietario di cane e IdUtente di utente

*/
DROP DATABASE IF EXISTS esposizioni_cani_e_gatti;
CREATE DATABASE esposizioni_cani_e_gatti;
USE esposizioni_cani_e_gatti;

-- Creazione della tabella per l'utente/proprietario
CREATE TABLE utente(
    IdUtente INT AUTO_INCREMENT,
    username VARCHAR(25) NOT NULL,
    password VARBINARY(300) NOT NULL,
    ruolo VARCHAR(25) NOT NULL,
    PRIMARY KEY(IdUtente),
    CHECK(ruolo IN('utente', 'admin')),
    UNIQUE(username)
);

-- Creazione della tabella dei concorsi
CREATE TABLE concorso(
    IdConcorso INT AUTO_INCREMENT,
    descrizione VARCHAR(50) NOT NULL,
    animale VARCHAR(10) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    luogo VARCHAR(25) NOT NULL,
    data DATE NOT NULL,
    immagine TINYTEXT NOT NULL,
    PRIMARY KEY(IdConcorso),
    CHECK(animale IN ("cani", "gatti")),
    CHECK(categoria IN ("Classe Juniores", "Gatti di razza", "Gatti di casa", "cucciolate e cuccioli dai 3 ai 6 mesi", "classe Ph Premio d’Onore", "Campionato e Premior"))
);


-- Creazione della tabella per il gatto che parteciperà al concorso
CREATE TABLE gatto(
    IdGatto INT AUTO_INCREMENT,
    nome VARCHAR(25) NOT NULL,
    genere VARCHAR(10) NOT NULL,
    razza VARCHAR(25) NOT NULL,
    immagine TINYTEXT NOT NULL,
    proprietario INT NOT NULL,
    PRIMARY KEY(IdGatto),
    FOREIGN KEY(proprietario) REFERENCES utente(IdUtente)
);

-- Creazione della tabella delle iscrizioni dei gatti ai concorsi
CREATE TABLE iscrizioneGatto(
    concorso INT,
    gatto INT,
    PRIMARY KEY(concorso, gatto),
    FOREIGN KEY(concorso) REFERENCES concorso(IdConcorso),
    FOREIGN KEY(gatto) REFERENCES gatto(IdGatto)
);

-- Creazione della tabella per il cane che parteciperà al concorso
CREATE TABLE cane(
    IdCane INT AUTO_INCREMENT,
    nome VARCHAR(25) NOT NULL,
    genere VARCHAR(10) NOT NULL,
    razza VARCHAR(25) NOT NULL,
    immagine TINYTEXT NOT NULL,
    proprietario INT NOT NULL,
    PRIMARY KEY(IdCane),
    FOREIGN KEY(proprietario) REFERENCES utente(IdUtente)
);

-- Creazione della tabella delle iscrizioni dei cani ai concorsi
CREATE TABLE iscrizioneCane(
    concorso INT,
    cane INT,
    PRIMARY KEY(concorso, cane),
    FOREIGN KEY(concorso) REFERENCES concorso(IdConcorso),
    FOREIGN KEY(cane) REFERENCES cane(IdCane)
);
USE esposizioni_cani_e_gatti;

-- INSERT INTO TABLE utente
INSERT INTO utente VALUES
    (1, "admin", "$2y$10$5c6U4REeEwUvJTHJFzS2ueTL8prpMZf.EOuwtcwdeO84gsBad3m.S", "admin"),
    (2, "utente", "$2y$10$W9OUHHjz./XQ9qmqz5CbpexsmOQFlpSWYhMGS9QV//074nYfdfqU6", "utente");

-- INSERT INTO TABLE cane
INSERT INTO cane VALUES
    (1, "Rufus", "maschio", "Beagle", "cane_1.jpg", 2),
    (2, "Hana", "femmina", "Golden retriever", "cane_2.jpg", 2),
    (3, "Pallino", "maschio", "Rottweiler", "cane_3.jpg", 2);

-- INSERT INTO TABLE concorso
INSERT INTO concorso VALUES
    (1, "Concorso super cane 2020", "cani", "cucciolate e cuccioli dai 3 ai 6 mesi", "Bonavicina", "2020-08-31", "concorso_1.jpg"),
    (2, "Concorso super gatto 2020", "gatti", "Gatti di razza", "Verona", "2020-09-22", "concorso_2.jpg"),
    (3, "Concorso super cane 2021", "cani", "Classe Juniores", "Bovolone", "2021-07-31", "concorso_3.jpg"),
    (4, "Concorso super gatto 2021", "gatti", "Gatti di casa", "Verona", "2021-08-23", "concorso_4.jpg"),
    (5, "Concorso cane d'oro 2021", "cani", "Campionato e Premior", "Bonavicina", "2021-10-31", "concorso_5.jpg");

-- INSERT INTO TABLE iscrizioniCani
INSERT INTO iscrizioneCane VALUES
    (1, 1),
    (1, 2),
    (1, 3);

-- INSERT INTO TABLE gatto
INSERT INTO gatto VALUES
    (1, "Pallino", "maschio", "Norvegese", "gatto_1.jpg", 2),
    (2, "Neve", "femmina", "Certosino", "gatto_2.jpg", 2),
    (3, "Fulmine", "maschio", "Siberiano", "gatto_3.jpg", 2);

-- INSERT INTO TABLE iscrizioniGatti
INSERT INTO iscrizioneGatto VALUES
    (2, 1),
    (2, 2),
    (2, 3);
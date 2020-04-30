-- Création ED pour stocké des données des ventes

CREATE DATABASE BD_SQL;

DROP TABLE IF EXISTS Abonner;
DROP TABLE IF EXISTS DiffuserPU;
DROP TABLE IF EXISTS Publication;
DROP TABLE IF EXISTS Calend2;
DROP TABLE IF EXISTS Calendrier;


-- -----------------------------------------------------------------------------
--       création des tableaux
-- -----------------------------------------------------------------------------

CREATE TABLE Publication (
  CodePU int(6) NOT NULL,
  NomPU VARCHAR(255),
  Periodicite VARCHAR(255) ,
  PRIMARY KEY (CodePU)
);

CREATE TABLE CALEND2 (
  Annee int(6) NOT NULL,
  PRIMARY KEY (Annee)
);

CREATE TABLE Calendrier (
  DateDeb DATETIME,
  PRIMARY KEY (DateDeb)
);

CREATE TABLE Abonner (
  CodeC int(6) NOT NULL,
  CodePU int(6) NOT NULL,
  DateDeb DATETIME,
  PrixNumAb int(6) ,
  Nbnum int(6),
  PRIMARY KEY (CodeC,CodePU,DateDeb)
);

CREATE TABLE DiffuserPU (
  CodePU int(6) NOT NULL,
  Annee int(6) NOT NULL,
  NbDiffusions int(6) ,
  PRIMARY KEY (CodePU,Annee)
);

-- -----------------------------------------------------------------------------
--       création des références de table
-- -----------------------------------------------------------------------------
alter table Abonner
add constraint fk_Publication foreign key (CodePU) references Publication (CodePU);

alter table Abonner
add constraint fk_Calendrier foreign key (DateDeb) references Calendrier (DateDeb);

alter table DiffuserPU
add constraint fk_Publication_DPU foreign key (CodePU) references Publication (CodePU);

alter table DiffuserPU
add constraint fk_Calend2_DPU foreign key (Annee) references Calend2 (Annee);


-- -----------------------------------------------------------------------------
--       insertion des données dans ED
-- -----------------------------------------------------------------------------
INSERT INTO Publication VALUES('23','La Croix','quotidien');
INSERT INTO Publication VALUES('24','Le Parisien','hebdomadaire');


INSERT INTO Calend2 VALUES('2018');
INSERT INTO Calend2 VALUES('2019');
INSERT INTO Calend2 VALUES('2020');


INSERT INTO Calendrier VALUES('2018-07-02 17:10:00');
INSERT INTO Calendrier VALUES('2018-03-14 17:10:00');
INSERT INTO Calendrier VALUES('2019-07-23 17:10:00');
INSERT INTO Calendrier VALUES('2019-04-14 17:10:00');
INSERT INTO Calendrier VALUES('2018-06-25 17:10:00');
INSERT INTO Calendrier VALUES('2019-06-30 17:10:00');
INSERT INTO Calendrier VALUES('2020-06-30 17:10:00');
INSERT INTO Calendrier VALUES('2020-06-25 17:10:00');


INSERT INTO Abonner VALUES('1023','23','2018-07-02 17:10:00','1','6');
INSERT INTO Abonner VALUES('1024','24','2018-03-14 17:10:00','1','12');
INSERT INTO Abonner VALUES('1025','23','2019-07-23 17:10:00','2','24');
INSERT INTO Abonner VALUES('1020','24','2019-04-14 17:10:00','2','10');
INSERT INTO Abonner VALUES('1029','23','2018-06-25 17:10:00','2','48');
INSERT INTO Abonner VALUES('1032','24','2019-06-30 17:10:00','2','48');
INSERT INTO Abonner VALUES('1023','24','2020-06-30 17:10:00','1','50');
INSERT INTO Abonner VALUES('1025','23','2020-06-25 17:10:00','1','30');


INSERT INTO DiffuserPU VALUES('23','2018','534320');
INSERT INTO DiffuserPU VALUES('24','2018','506610');
INSERT INTO DiffuserPU VALUES('24','2019','479112');
INSERT INTO DiffuserPU VALUES('23','2019','486145');
INSERT INTO DiffuserPU VALUES('23','2020','488645');
INSERT INTO DiffuserPU VALUES('24','2020','306145');



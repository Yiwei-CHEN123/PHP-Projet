-- MySQL dump 10.13  Distrib 5.7.9, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: videoclub
-- ------------------------------------------------------
-- Server version	5.6.10

CREATE DATABASE BDD_ProjetPHP;

DROP TABLE IF EXISTS Indicateurs;
DROP TABLE IF EXISTS Rapports;
DROP TABLE IF EXISTS Postes;
DROP TABLE IF EXISTS Employes;
DROP TABLE IF EXISTS SuiviEdition;
DROP TABLE IF EXISTS Demander;
DROP TABLE IF EXISTS Faire;
DROP TABLE IF EXISTS Comporter;



CREATE TABLE Indicateurs (
  IDIndi int(6) NOT NULL,
  NomIndi VARCHAR(250),
  AnalyseIndi Varchar(255),
  Requete Varchar(255),
  PRIMARY KEY (IDIndi)
);


CREATE TABLE Rapports (
  NumeroR int(10) NOT NULL,
  TitreR VARCHAR(255),
  DateCreR DATETIME,
  Etat Varchar(255),
  SyntheseR VARCHAR(255),
  PRIMARY KEY (NumeroR)
);


CREATE TABLE Postes (
  IDPoste int(6) NOT NULL,
  NomPoste VARCHAR(255),
  PRIMARY KEY (IDPoste)
);


CREATE TABLE Employes (
  MatriculeE int(6) NOT NULL,
  NomE VARCHAR(20),
  PrenomE VARCHAR(20),
  AdrEmailE VARCHAR(30),
  MotPasseE VARCHAR(8),
  IDPoste int(6) NOT NULL,
  PRIMARY KEY (MatriculeE)
);


CREATE TABLE SuiviEdition (
  IDSuivi int(6) NOT NULL,
  DateHeure DATETIME,
  Commentaire VARCHAR(255),
  MatriculeE int(6) NOT NULL,
  NumeroR int(10) NOT NULL,
  PRIMARY KEY (IDSuivi)
);


CREATE TABLE Demander (
  IDPoste int(6) NOT NULL,
  NumeroR int(10) NOT NULL,
  MatriculeE int(6) NOT NULL,
  CONSTRAINT PK_DEMANDER PRIMARY KEY (IDPoste, NumeroR, MatriculeE),
  CONSTRAINT Demande_fk_1 FOREIGN KEY (IDPoste) REFERENCES Postes (IDPoste),
  CONSTRAINT Demande_fk_2 FOREIGN KEY (NumeroR) REFERENCES Rapports (NumeroR),
  CONSTRAINT Demande_fk_3 FOREIGN KEY (MatriculeE) REFERENCES Employes (MatriculeE)  
);


CREATE TABLE Faire (
    MatriculeE int(6) NOT NULL,
    NumeroR int(10) NOT NULL,
    CONSTRAINT PK_FAIRE PRIMARY KEY (NumeroR, MatriculeE),
    CONSTRAINT Faire_fk_1 FOREIGN KEY (NumeroR) REFERENCES Rapports (NumeroR),
    CONSTRAINT Faire_fk_2 FOREIGN KEY (MatriculeE) REFERENCES Employes (MatriculeE) 
);


CREATE TABLE Comporter (
    IDIndi int(6) NOT NULL,
    NumeroR int(10) NOT NULL,
    CONSTRAINT PK_COMPORTER PRIMARY KEY (NumeroR, IDIndi),
    CONSTRAINT Comporter_fk_1 FOREIGN KEY (NumeroR) REFERENCES Rapports (NumeroR),
    CONSTRAINT Comporter_fk_2 FOREIGN KEY (IDIndi) REFERENCES Indicateurs (IDIndi) 
);

-- -----------------------------------------------------------------------------
--       CREATION DES REFERENCES DE TABLE
-- -----------------------------------------------------------------------------

ALTER TABLE Employes ADD CONSTRAINT FK_EMPLOYES FOREIGN KEY (IDPoste) REFERENCES Postes (IDPoste);
ALTER TABLE SuiviEdition ADD CONSTRAINT FK_SUIVIEDITION_1 FOREIGN KEY (MatriculeE) REFERENCES Employes (MatriculeE);
ALTER TABLE SuiviEdition ADD CONSTRAINT FK_SUIVIEDITION_2 FOREIGN KEY (NumeroR) REFERENCES Rapports (NumeroR);


-- -----------------------------------------------------------------------------
--       CREATION DES DONNEES DE TABLE
-- -----------------------------------------------------------------------------

INSERT INTO Indicateurs VALUES ('01','Nombre total des abonnements en 2019','Analyse indicateur 1','SELECT sum(Ab.Nbnum) as [Nombre abonnés] FROM Abonner Ab, Calendrier C WHERE C.DateDeb = Ab.DateDeb AND TODATE("C.DateDeb", YYYY) = "2019";');
INSERT INTO Indicateurs VALUES ('02','Nombre total des abonnements pour la publication "Le Parisien" en 2018','Analyse indicateur 2','SELECT P.NomPU, sum(Ab.Nbnum) as [Nombre abonnés] FROM Publication P, Abonner Ab, Calendrier C WHERE P.CodePU = Ab.CodePU AND C.DateDeb = Ab.DateDeb AND TODATE("C.DateDeb", YYYY) = "2018" AND P.NomPU = "Le Parisien" GROUP BY P.NomPU;');
INSERT INTO Indicateurs VALUES ('03','Nombre total des abonnements pour la publication "La Croix" en 2019','Analyse indicateur 3','SELECT P.NomPU, sum(Ab.Nbnum) as [Nombre abonnés] FROM Publication P, Abonner Ab, Calendrier C WHERE P.CodePU = Ab.CodePU AND C.DateDeb = Ab.DateDeb AND TODATE("C.DateDeb", YYYY) = "2019" AND P.NomPU = "La Croix" GROUP BY P.NomPU;');
INSERT INTO Indicateurs VALUES ('04','Nombre total des diffusions pour la publication "La Croix" en 2018','Analyse indicateur 4','SELECT P.NomPU, sum(DPU.NbDiffusions) as [Nombre diffusions] FROM Publication P, DiffuserPU DPU, Calend2 C WHERE P.CodePU = DPU.CodePU AND C.Annee = DPU.Annee AND C.Annee = "2018" AND P.NomPU = "La Croix" GROUP BY P.NomPU;');
INSERT INTO Indicateurs VALUES ('05','Nombre total des diffusions pour la publication "Le parisien" en 2019','Analyse indicateur 5','SELECT P.NomPU, sum(DPU.NbDiffusions) as [Nombre diffusions] FROM Publication P, DiffuserPU DPU, Calend2 C WHERE P.CodePU = DPU.CodePU AND C.Annee = DPU.Annee AND C.Annee = "2019" AND P.NomPU = "Le Parisien" GROUP BY P.NomPU;');

INSERT INTO Rapports VALUES ('1001','Rapport sur analyse abonnement','2018-01-01 17:10:00','Création du rapport','Synthèse Rapport 1');
INSERT INTO Rapports VALUES ('1002','Rapport financier sur le nombre abonnement ','2018-02-01 17:10:00','Ouvert','Synthèse Rapport 2');


INSERT INTO Postes VALUES ('1','Directeur');
INSERT INTO Postes VALUES ('2','Directeur Adjoint');
INSERT INTO Postes VALUES ('3','Directeur des ventes');
INSERT INTO Postes VALUES ('4','Directeur de la publication');
INSERT INTO Postes VALUES ('5','Directeur des ressources humaines');
INSERT INTO Postes VALUES ('6','Service Marketing');
INSERT INTO Postes VALUES ('7','Service Financier');


INSERT INTO Employes VALUES ('001','Jack','Jones','jackjones@gmail.com','0011Jack','1');
INSERT INTO Employes VALUES ('002','Louis','Vitons','louisvitons@gmail.com','0012Loui','2');
INSERT INTO Employes VALUES ('003','Coco','Chanel','cocochanel@gmail.com','0013Coco','3');
INSERT INTO Employes VALUES ('004','Marie','Dior','mariedior@163.com','0014Dior','4');
INSERT INTO Employes VALUES ('005','Mickel','Jackson','mickeljackson@qq.com','0015Mkel','5');
INSERT INTO Employes VALUES ('006','David','Richard','davidrich@msn.com','0016Davd','6');
INSERT INTO Employes VALUES ('007','Bill','Roux','billroux@msn.com','0017Bill','7');


INSERT INTO SuiviEdition VALUES ('0001','2020-03-14 17:10:00','Clôture du rapport','006','1001');
INSERT INTO SuiviEdition VALUES ('0002','2019-07-23 17:10:00','Validé','006','1001');
INSERT INTO SuiviEdition VALUES ('0003','2019-04-14 17:10:00','Soumis','006','1001');
INSERT INTO SuiviEdition VALUES ('0004','2018-06-25 17:10:00','Edition du rapport','007','1002');
INSERT INTO SuiviEdition VALUES ('0005','2019-06-30 17:10:00','Il me faudrait une étude pour évaluer si le nombre abonnement a eu un impact positif sur le nombre de vente.','007','1002');
INSERT INTO SuiviEdition VALUES ('0006','2018-01-01 17:10:00','Création du rapport','006','1001');


INSERT INTO Demander VALUES ('001','1001','1');
INSERT INTO Demander VALUES ('003','1002','2');


INSERT INTO Faire VALUES ('006','1001');
INSERT INTO Faire VALUES ('007','1002');


INSERT INTO Comporter VALUES ('01','1001');
INSERT INTO Comporter VALUES ('02','1002');
INSERT INTO Comporter VALUES ('03','1001');
INSERT INTO Comporter VALUES ('04','1002');
INSERT INTO Comporter VALUES ('05','1002');

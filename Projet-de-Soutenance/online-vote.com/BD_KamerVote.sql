CREATE TABLE users (
    id_user INT PRIMARY KEY AUTO_INCREMENT, 
    photo_user VARCHAR (255),
    nom_user VARCHAR (100) NOT NULL, 
    prenom_user VARCHAR (100) NOT NULL, 
    email VARCHAR (100) UNIQUE NOT NULL, 
    pwd VARCHAR (255) NOT NULL, 
    role_user ENUM('admin', 'organisateur', 
    'votant') NOT NULL DEFAULT 'Votant',
    status_user BOOLEAN DEFAULT FALSE, 
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE concours(
    id_concours INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR (150) NOT NULL, 
    description_concours TEXT, 
    photo_concours VARCHAR (255),
    type_vote ENUM('gratuit', 'payant') NOT NOT DEFAULT 'payant', 
    prix_vote decimal (10,2) DEFAULT 00.0,
    id_organisateur INT NOT NULL, 
    status_concours ENUM('attente', 'ouvert', 'ferme') NOT NULL DEFAULT 'attente', 
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    foreign key (id_organisateur) references users(id_user) on delete cascade
);

create table candidats (
    id_candidat int PRIMARY key AUTO_INCREMENT, 
    nom_candidat VARCHAR (100) NOT NULL, 
    prenom_candidat VARCHAR (100) not NULL, 
    email_candidat VARCHAR(100) UNIQUE NULL, 
    photo_candidat VARCHAR (255),
    biography text,
    id_concours int not NULL,
    foreign key (id_concours) references concours(id_concours) on delete cascade
);

create table paiement (
    id_paiement int PRIMARY key AUTO_INCREMENT, 
    ref_transaction VARCHAR(100) UNIQUE, 
    montant decimal (10,2) not NULL, 
    methode ENUM('Orange', 'MTN', 'Carte') NOT NULL, 
    status_paiement ENUM('attente', 'succes', 'echec') DEFAULT 'attente',
    id_votant int not NULL, 
    date_paeiement TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    foreign key (id_votant) references users(id_user) on delete set null
); 

create table vote (
    id_vote int PRIMARY key AUTO_INCREMENT, 
    id_candidat int not null, 
    id_concours int not null, 
    id_votant int null, 
    id_paiement int not null UNIQUE,
    adr_ip VARCHAR (50),
    date_vote TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    foreign key (id_candidat) references candidats(id_candidat) on delete cascade, 
    foreign key (id_concours) references concours(id_concours) on delete cascade, 
    foreign key (id_paiement) references paiement(id_paiement) on delete set null
);


/*éetudier les moteurs de stockages */
/* on doit voir l'id de l'oorganisateur dans la yable candidat
/*Faire un lien unique par candidats, 
revoirs la structure de la table user pour les organisateurs 
faire en sorte que les liens qui s'affichent au navigateurs soient personnalisé sans l'extention du fichier php
date fin concours
l'aministrateur peut tout faire : donc insérer son id 

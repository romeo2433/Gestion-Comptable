CREATE TABLE clients (
    id_client SERIAL PRIMARY KEY,
    nom_complet VARCHAR(150),
    email VARCHAR(100),
    mdp VARCHAR(20)
);

CREATE TABLE fournisseurs (
    id_fournisseur SERIAL PRIMARY KEY,
    nom VARCHAR(150)
);  

CREATE TABLE comptes (
    id_compte SERIAL PRIMARY KEY,
    numero_compte VARCHAR(10) UNIQUE,
    intitule VARCHAR(200),
    classe INT
);



CREATE TABLE factures (
    id_facture SERIAL PRIMARY KEY,
    numero_facture VARCHAR(50),
    id_client INT,
    date_facture DATE,
    date_echeance DATE,
    montant_ht DECIMAL(12,2),
    montant_tva DECIMAL(12,2),
    montant_ttc DECIMAL(12,2),
    statut VARCHAR(20) DEFAULT 'En attente',

    FOREIGN KEY (id_client)
    REFERENCES clients(id_client)
);



CREATE TABLE ligne_factures (
    id_ligne SERIAL PRIMARY KEY,
    id_facture INT,
    designation VARCHAR(200),
    quantite INT,
    prix_unitaire DECIMAL(12,2),
    montant DECIMAL(12,2),

    FOREIGN KEY(id_facture)
    REFERENCES factures(id_facture)
);



CREATE TABLE paiements (
    id_paiement SERIAL PRIMARY KEY,
    id_facture INT,
    date_paiement DATE,
    montant DECIMAL(12,2),
    mode_paiement VARCHAR(50),

    FOREIGN KEY(id_facture)
    REFERENCES factures(id_facture)
);

CREATE TABLE charges (
    id_charge SERIAL PRIMARY KEY,
    id_compte INT,
    id_fournisseur INT,
    date_charge DATE,
    montant DECIMAL(12,2),
    description TEXT,

    FOREIGN KEY(id_compte)
    REFERENCES comptes(id_compte),

    FOREIGN KEY(id_fournisseur)
    REFERENCES fournisseurs(id_fournisseur)
);

CREATE TABLE journal (
    id_journal SERIAL PRIMARY KEY,
    numero_piece VARCHAR(50),
    date_operation DATE,
    libelle VARCHAR(200)
);

CREATE TABLE ecritures (
    id_ecriture SERIAL PRIMARY KEY,
    id_journal INT,
    id_compte INT,
    debit DECIMAL(12,2),
    credit DECIMAL(12,2),

    FOREIGN KEY(id_journal)
    REFERENCES journal(id_journal),

    FOREIGN KEY(id_compte)
    REFERENCES comptes(id_compte)
);

CREATE TABLE tva (
    id_tva SERIAL PRIMARY KEY,
    taux DECIMAL(5,2),
    montant DECIMAL(12,2),
    type_tva VARCHAR(50)
);


CREATE TABLE utilisateurs (
    id_utilisateur SERIAL PRIMARY KEY,
    nom VARCHAR(150),
    email VARCHAR(100),
    mot_de_passe VARCHAR(255),
    role VARCHAR(50)
);



php artisan make:migration create_clients_table
php artisan make:migration create_fournisseurs_table
php artisan make:migration create_comptes_table
php artisan make:migration create_factures_table
php artisan make:migration create_ligne_factures_table
php artisan make:migration create_paiements_table
php artisan make:migration create_charges_table
php artisan make:migration create_journal_table
php artisan make:migration create_ecritures_table
php artisan make:migration create_tva_table



php artisan make:model Utilisateur
php artisan make:model Client
php artisan make:model Fournisseur
php artisan make:model Compte
php artisan make:model Facture
php artisan make:model LigneFacture
php artisan make:model Paiement
php artisan make:model Charge
php artisan make:model Journal
php artisan make:model Ecriture
php artisan make:model Tva


1. utilisateurs
2. clients
3. fournisseurs
4. comptes
5. factures
6. ligne_factures
7. paiements
8. charges
9. journal
10. ecritures
11. tva


INSERT INTO clients
(nom_complet, email, mdp)
VALUES
('Entreprise Alpha', 'alpha@gmail.com', 'password123'),
('Société Beta', 'beta@gmail.com', 'password123'),
('Mada Construction', 'contact@madaconstruction.mg', 'password123'),
('Digital Services', 'contact@digitalservices.mg', 'password123'),
('Commerce Andry', 'andry@gmail.com', 'password123');

INSERT INTO fournisseurs
(nom)
VALUES
('Telma Madagascar'),
('Orange Madagascar'),
('Jovenna Madagascar'),
('Bureau Plus Madagascar'),
('Informatique Mada'),
('Star Distribution'),
('Espace Imprimerie');

INSERT INTO comptes
(numero_compte, intitule, classe)
VALUES
('401', 'Fournisseurs', 4),
('411', 'Clients', 4),
('44566', 'TVA déductible', 4),
('44571', 'TVA collectée', 4),
('512', 'Banque', 5),
('530', 'Caisse', 5),
('606', 'Achats non stockés', 6),
('607', 'Achats de marchandises', 6),
('613', 'Locations', 6),
('615', 'Entretien et réparations', 6),
('622', 'Rémunérations intermédiaires', 6),
('706', 'Prestations de services', 7),
('707', 'Ventes de marchandises', 7);



INSERT INTO tva
(taux, montant, type_tva)
VALUES
(20.00, 100000.00, 'TVA déductible'),
(20.00, 200000.00, 'TVA déductible'),
(20.00, 300000.00, 'TVA collectée'),
(10.00, 50000.00, 'TVA déductible'),
(20.00, 150000.00, 'TVA déductible');


INSERT INTO factures
(
    numero_facture,
    id_fournisseur,
    id_compte_charge,
    id_tva,
    date_facture,
    date_echeance,
    montant_ht,
    montant_tva,
    montant_ttc,
    statut
)
VALUES
(
    'ACH-2026-001',
    1,
    7,
    1,
    '2026-08-01',
    '2026-08-31',
    500000.00,
    100000.00,
    600000.00,
    'Payée'
),
(
    'ACH-2026-002',
    2,
    7,
    2,
    '2026-08-02',
    '2026-09-02',
    1000000.00,
    200000.00,
    1200000.00,
    'Payée'
),
(
    'ACH-2026-003',
    3,
    8,
    3,
    '2026-08-03',
    '2026-09-03',
    1500000.00,
    300000.00,
    1800000.00,
    'En attente'
),
(
    'ACH-2026-004',
    4,
    7,
    4,
    '2026-08-04',
    '2026-09-04',
    250000.00,
    50000.00,
    300000.00,
    'Payée'
),
(
    'ACH-2026-005',
    5,
    7,
    5,
    '2026-08-05',
    '2026-09-05',
    750000.00,
    150000.00,
    900000.00,
    'En attente'
),
(
    'ACH-2026-006',
    6,
    9,
    1,
    '2026-08-06',
    '2026-09-06',
    800000.00,
    160000.00,
    960000.00,
    'Payée'
),
(
    'ACH-2026-007',
    7,
    7,
    2,
    '2026-08-07',
    '2026-09-07',
    300000.00,
    60000.00,
    360000.00,
    'En attente'
);


INSERT INTO ligne_factures
(
    id_facture,
    designation,
    quantite,
    prix_unitaire,
    montant
)
VALUES
(1, 'Abonnement internet professionnel', 1, 500000.00, 500000.00),

(2, 'Forfait télécommunication entreprise', 2, 500000.00, 1000000.00),

(3, 'Carburant véhicule entreprise', 3, 500000.00, 1500000.00),

(4, 'Fournitures de bureau', 5, 50000.00, 250000.00),

(5, 'Ordinateur portable professionnel', 3, 250000.00, 750000.00),

(6, 'Location matériel', 2, 400000.00, 800000.00),

(7, 'Impression documents professionnels', 10, 30000.00, 300000.00);

INSERT INTO paiements
(
    id_facture,
    date_paiement,
    montant,
    mode_paiement
)
VALUES
(1, '2026-08-05', 600000.00, 'Virement bancaire'),

(2, '2026-08-06', 1200000.00, 'Virement bancaire'),

(4, '2026-08-07', 300000.00, 'Espèces'),

(6, '2026-08-08', 960000.00, 'Virement bancaire');



INSERT INTO charges
(
    id_compte,
    id_fournisseur,
    date_charge,
    montant,
    description
)
VALUES
(7, 1, '2026-08-01', 500000.00, 'Abonnement internet professionnel'),

(7, 2, '2026-08-02', 1000000.00, 'Télécommunications'),

(7, 3, '2026-08-03', 1500000.00, 'Carburant pour véhicules'),

(7, 4, '2026-08-04', 250000.00, 'Fournitures de bureau'),

(7, 5, '2026-08-05', 750000.00, 'Matériel informatique'),

(9, 6, '2026-08-06', 800000.00, 'Location de matériel'),

(7, 7, '2026-08-07', 300000.00, 'Travaux d''impression');


INSERT INTO journal
(
    numero_piece,
    date_operation,
    libelle
)
VALUES
('ACH-001', '2026-08-01', 'Facture Telma Madagascar'),
('ACH-002', '2026-08-02', 'Facture Orange Madagascar'),
('ACH-003', '2026-08-03', 'Facture Jovenna Madagascar'),
('ACH-004', '2026-08-04', 'Facture Bureau Plus'),
('ACH-005', '2026-08-05', 'Facture Informatique Mada'),
('ACH-006', '2026-08-06', 'Facture Star Distribution'),
('ACH-007', '2026-08-07', 'Facture Espace Imprimerie');



INSERT INTO ecritures
(
    id_journal,
    id_compte,
    debit,
    credit
)
VALUES
-- Facture Telma
(1, 7, 500000.00, 0.00),
(1, 3, 100000.00, 0.00),
(1, 1, 0.00, 600000.00),

-- Facture Orange
(2, 7, 1000000.00, 0.00),
(2, 3, 200000.00, 0.00),
(2, 1, 0.00, 1200000.00),

-- Facture Jovenna
(3, 8, 1500000.00, 0.00),
(3, 4, 300000.00, 0.00),
(3, 1, 0.00, 1800000.00),

-- Facture Bureau Plus
(4, 7, 250000.00, 0.00),
(4, 3, 50000.00, 0.00),
(4, 1, 0.00, 300000.00),

-- Facture Informatique Mada
(5, 7, 750000.00, 0.00),
(5, 3, 150000.00, 0.00),
(5, 1, 0.00, 900000.00);



SELECT
    f.date_facture AS `Date de facture`,
    fo.nom AS `Nom du fournisseur`,
    CONCAT(c.numero_compte, ' - ', c.intitule) AS `Compte de charge`,
    f.montant_ttc AS `Montant total (Ar)`,
    f.montant_tva AS `TVA`,
    CONCAT(ct.numero_compte, ' - ', ct.intitule) AS `Compte TVA`,
    COALESCE(SUM(p.montant), 0) AS `Paiement`
FROM factures f
LEFT JOIN fournisseurs fo
    ON f.id_fournisseur = fo.id_fournisseur
LEFT JOIN comptes c
    ON f.id_compte_charge = c.id_compte
LEFT JOIN tva t
    ON f.id_tva = t.id_tva
LEFT JOIN comptes ct
    ON t.id_compte = ct.id_compte
LEFT JOIN paiements p
    ON f.id_facture = p.id_facture
GROUP BY
    f.id_facture,
    f.date_facture,
    fo.nom,
    c.numero_compte,
    c.intitule,
    f.montant_ttc,
    f.montant_tva,
    ct.numero_compte,
    ct.intitule
ORDER BY f.date_facture DESC;



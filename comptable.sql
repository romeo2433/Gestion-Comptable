-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 19 oct. 2026 à 11:51
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `comptable`
--

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `charges`
--

CREATE TABLE `charges` (
  `id_charge` bigint(20) UNSIGNED NOT NULL,
  `id_compte` bigint(20) UNSIGNED NOT NULL,
  `id_fournisseur` bigint(20) UNSIGNED NOT NULL,
  `date_charge` date NOT NULL,
  `montant` decimal(12,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id_client` bigint(20) UNSIGNED NOT NULL,
  `nom_complet` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom_complet`, `created_at`, `updated_at`) VALUES
(1, 'OUVRAGES ET CONSTRUCTIONS METALLIQUES', '2026-09-07 08:13:36', '2026-09-07 08:13:36'),
(2, ':', '2026-10-07 03:21:39', '2026-10-07 03:21:39'),
(3, 'OUVRAGES ET CONSTRUCTIONS METALLIQUES IN', '2026-10-07 04:25:38', '2026-10-07 04:25:38'),
(4, 'OUVRAGES ET CONSTRUCTION METALLIQUES INDUSTRIEL', '2026-10-08 03:47:55', '2026-10-08 03:47:55'),
(5, 'OUVRAGES ET CONSTRUCTION METALIQUE', '2026-10-08 03:49:47', '2026-10-08 03:49:47');

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `id_compte` bigint(20) UNSIGNED NOT NULL,
  `numero_compte` varchar(10) NOT NULL,
  `intitule` varchar(200) NOT NULL,
  `classe` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`id_compte`, `numero_compte`, `intitule`, `classe`, `created_at`, `updated_at`) VALUES
(1, '601', 'Achats de matières premières', 6, '2026-09-07 06:30:51', '2026-09-07 06:30:51'),
(2, '445600', 'TVA déductible', 4, '2026-09-07 06:30:51', '2026-09-07 06:30:51'),
(3, '613', 'Locations', 6, '2026-09-07 06:59:27', '2026-09-07 06:59:27'),
(4, '706', 'Prestations de services', 7, '2026-09-07 08:13:36', '2026-09-07 08:13:36'),
(5, '443000', 'TVA collectée', 4, '2026-09-07 08:13:36', '2026-09-07 08:13:36'),
(6, '607', 'Achats de marchandises', 6, '2026-09-11 05:34:26', '2026-09-11 05:34:26'),
(7, '707000', 'Ventes de marchandises', 7, '2026-10-07 04:25:38', '2026-10-07 04:25:38'),
(8, '706000', 'Prestations de services', 7, '2026-10-08 03:47:55', '2026-10-08 03:47:55'),
(9, '445700', 'TVA collectée', 4, '2026-10-08 03:47:55', '2026-10-08 03:47:55'),
(10, '707', 'Ventes de marchandises', 7, '2026-10-08 03:49:47', '2026-10-08 03:49:47'),
(11, '606', 'Achats non stockés de matières et fournitures', 6, '2026-10-18 11:22:43', '2026-10-18 11:22:43'),
(12, '604', 'Achats d\'études et prestations de services', 6, '2026-10-18 12:49:34', '2026-10-18 12:49:34');

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

CREATE TABLE `departements` (
  `id_departement` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `departements`
--

INSERT INTO `departements` (`id_departement`, `nom`, `description`, `created_at`, `updated_at`) VALUES
(5, 'Client X', 'Gestion des employes et informations RH', '2026-09-14 17:18:04', '2026-09-14 17:18:04'),
(6, 'Client Y', 'Suivi et supervision de activite', '2026-09-14 17:18:04', '2026-09-14 17:18:04');

-- --------------------------------------------------------

--
-- Structure de la table `ecritures`
--

CREATE TABLE `ecritures` (
  `id_ecriture` bigint(20) UNSIGNED NOT NULL,
  `id_journal` bigint(20) UNSIGNED NOT NULL,
  `id_compte` bigint(20) UNSIGNED NOT NULL,
  `debit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `credit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

CREATE TABLE `entreprises` (
  `id_entreprise` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `nom_commercial` varchar(255) DEFAULT NULL,
  `forme_juridique` varchar(255) DEFAULT NULL,
  `secteur_activite` varchar(255) DEFAULT NULL,
  `date_creation` date DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `site_web` varchar(255) DEFAULT NULL,
  `nif` varchar(255) DEFAULT NULL,
  `stat` varchar(255) DEFAULT NULL,
  `rcs` varchar(255) DEFAULT NULL,
  `nom_banque` varchar(255) DEFAULT NULL,
  `numero_compte` varchar(255) DEFAULT NULL,
  `titulaire_compte` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`id_entreprise`, `id_utilisateur`, `nom`, `nom_commercial`, `forme_juridique`, `secteur_activite`, `date_creation`, `adresse`, `ville`, `telephone`, `email`, `site_web`, `nif`, `stat`, `rcs`, `nom_banque`, `numero_compte`, `titulaire_compte`, `created_at`, `updated_at`) VALUES
(1, 4, 'BICI', NULL, 'Entreprise individuelle', 'Informatique', '2017-07-11', 'Lot av 586 ambolikandrina', 'Antananarivo', '0330452042', NULL, 'https://chatgpt.com/c/6a9278ae-34e8-83e9-a462-5e760173f4d8', '5222222222444', '424552525', '25424', NULL, NULL, NULL, '2026-09-07 11:44:47', '2026-09-11 05:27:04'),
(2, 10, 'Ritec', NULL, 'Entreprise individuelle', 'Informatique', NULL, 'Lot av 586 ambolikandrina', 'Antananarivo', '0330452045', NULL, NULL, '7', NULL, NULL, NULL, NULL, NULL, '2026-09-14 05:37:34', '2026-09-14 05:37:34');

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `id_facture` bigint(20) UNSIGNED NOT NULL,
  `type` enum('achat','vente') NOT NULL DEFAULT 'achat',
  `id_utilisateur` bigint(20) UNSIGNED DEFAULT NULL,
  `id_departement` bigint(20) UNSIGNED DEFAULT NULL,
  `numero_facture` varchar(50) DEFAULT NULL,
  `fichier_facture` varchar(255) DEFAULT NULL,
  `id_fournisseur` bigint(20) UNSIGNED DEFAULT NULL,
  `id_client` bigint(20) UNSIGNED DEFAULT NULL,
  `id_compte_charge` bigint(20) UNSIGNED DEFAULT NULL,
  `id_compte_produit` bigint(20) UNSIGNED DEFAULT NULL,
  `id_tva` bigint(20) UNSIGNED DEFAULT NULL,
  `date_facture` date NOT NULL,
  `date_echeance` date DEFAULT NULL,
  `montant_ht` decimal(12,2) NOT NULL DEFAULT 0.00,
  `montant_tva` decimal(12,2) NOT NULL DEFAULT 0.00,
  `montant_ttc` decimal(12,2) NOT NULL DEFAULT 0.00,
  `statut` varchar(20) NOT NULL DEFAULT 'En attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `factures`
--

INSERT INTO `factures` (`id_facture`, `type`, `id_utilisateur`, `id_departement`, `numero_facture`, `fichier_facture`, `id_fournisseur`, `id_client`, `id_compte_charge`, `id_compte_produit`, `id_tva`, `date_facture`, `date_echeance`, `montant_ht`, `montant_tva`, `montant_ttc`, `statut`, `created_at`, `updated_at`) VALUES
(2, 'achat', 3, NULL, '015-01-2026', 'factures/OInGk0Rz2XtDpJ6MD0S4orhLhgJxaAR1SBLPnadB.pdf', 2, NULL, 3, NULL, 2, '2026-01-05', NULL, 1666666.67, 333333.33, 2000000.00, 'Terminer', '2026-09-07 06:59:27', '2026-09-07 06:59:27'),
(3, 'vente', 3, NULL, '015-01-2026', 'factures/jWYqKiEE8X8g3IosxOSwSNzoEwjfhxHm5g52Ts8m.pdf', NULL, 1, NULL, 4, 3, '2026-01-05', NULL, 1666666.67, 333333.33, 2000000.00, 'En attente', '2026-09-07 08:13:36', '2026-09-07 08:13:36'),
(4, 'achat', 4, NULL, 'FA01600/25', 'factures/YpppLJwJCsLk248TntVnUQrxq20BIh4OXvudC346.pdf', 1, NULL, 1, NULL, 4, '2025-10-02', '2025-10-02', 9478000.00, 1895600.00, 11373600.00, 'Terminer', '2026-09-09 14:59:38', '2026-09-09 14:59:38'),
(5, 'achat', 3, NULL, 'FA01600/25', 'factures/q3dyqxFYlcD2PhIEZ7H1fIvq3ahVrgAowti267Rc.pdf', 1, NULL, 1, NULL, 5, '2025-10-02', '2025-10-02', 9478000.00, 1895600.00, 11373600.00, 'Terminer', '2026-09-09 15:53:42', '2026-09-09 15:53:42'),
(6, 'achat', 3, NULL, 'FV-2026-00147', 'factures/kLMavraxHV5KQ42nMcWNXURph7IPl48Z3MySvX6l.pdf', 3, NULL, 6, NULL, 6, '2026-07-24', '2026-08-23', 1280000.00, 256000.00, 1536000.00, 'Terminer', '2026-09-11 05:34:26', '2026-09-11 05:34:26'),
(7, 'achat', 11, 6, 'FV-2026-00148', 'factures/Hyho7FxbTRs705CSttueuNVbXfxAlc1ePVRouV1W.pdf', 3, NULL, 6, NULL, 7, '2026-08-11', '2026-09-10', 1280000.00, 256000.00, 1536000.00, 'Terminer', '2026-09-24 10:33:32', '2026-09-24 10:33:32'),
(9, 'vente', 11, 6, 'FA01597/25', 'factures/KkO3IerL4WzM1yTxGr83PZF1xQsDDAzZwO7iVEW5.pdf', NULL, 3, NULL, 7, 8, '2025-10-02', '2025-10-02', 690840.00, 138168.00, 829008.00, 'Terminer', '2026-10-07 04:25:38', '2026-10-07 04:25:38'),
(10, 'achat', 11, 6, 'FA-2509-05068', 'factures/AlSqEYmKOM8GJXfQ8casNOHgSlDiAEMQMWDn1WR8.pdf', 4, NULL, 3, NULL, 9, '2025-09-11', NULL, 150000.00, 30000.00, 180000.00, 'Terminer', '2026-10-07 04:28:13', '2026-10-07 04:28:13'),
(11, 'achat', 2, NULL, 'FA01597/25', 'factures/RsD3HHQXe7C8bdLPZ85XPkqYcNH9q4EoObaXHCxG.pdf', 1, NULL, 1, NULL, 10, '2025-10-02', '2025-10-02', 690840.00, 138168.00, 829008.00, 'Terminer', '2026-10-08 02:59:07', '2026-10-08 02:59:07'),
(12, 'vente', 2, NULL, 'FA-2509-05068', 'factures/AZsta1XBEGwzryIYvzluqJOVN2sYSwIHmsbAsORv.pdf', NULL, 4, NULL, 8, 11, '2025-09-11', NULL, 150000.00, 30000.00, 180000.00, 'Terminer', '2026-10-08 03:47:55', '2026-10-08 03:47:55'),
(13, 'vente', 2, NULL, 'S1001233242', 'factures/3k7KucKWsfw0VYwHGfLFOJkSGO3A5rzb3QAn74yj.pdf', NULL, 5, NULL, 10, 12, '2025-01-10', '2025-01-10', 53475.00, 10695.00, 64170.00, 'Terminer', '2026-10-08 03:49:47', '2026-10-08 03:49:47'),
(14, 'achat', 12, 5, 'S1001233242', 'factures/fu1JcjYeXncfpbQPzJLrZu13YCY5GlVLJpfms6C9.pdf', 5, NULL, 11, NULL, 13, '2025-01-10', '2025-01-10', 53475.00, 10695.00, 64170.00, 'Terminer', '2026-10-18 11:22:43', '2026-10-18 11:22:43'),
(15, 'vente', 12, 5, 'S1001233242', 'factures/42PNTgNeqqgZAIY0AekPv5tsJFdscPesQJU9SHZl.pdf', NULL, 5, NULL, 10, 14, '2025-01-10', '2025-01-10', 53475.00, 10695.00, 64170.00, 'Terminer', '2026-10-18 11:31:52', '2026-10-18 11:31:52'),
(16, 'achat', 13, 5, '2024/323', 'factures/QzU9L88WNmOnzCHpr1pMGlh9xWQs4JJ15CWj1hkn.pdf', 6, NULL, 12, NULL, 15, '2024-10-24', NULL, 2031500.00, 406300.00, 2437800.00, 'Terminer', '2026-10-18 12:49:34', '2026-10-18 12:49:34');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id_fournisseur` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id_fournisseur`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'TRANOMBAROTRA MALAZA B', '2026-09-07 06:30:51', '2026-09-07 06:30:51'),
(2, 'SOCIETE MUNICIPALE POUR L\'ENTRETIEN DE VEHICULES (SMEV)', '2026-09-07 06:59:27', '2026-09-07 06:59:27'),
(3, 'SOAFARA DISTRIBUTION SARL', '2026-09-11 05:34:26', '2026-09-11 05:34:26'),
(4, 'Eole', '2026-10-07 04:28:13', '2026-10-07 04:28:13'),
(5, 'SANIFER', '2026-10-18 11:22:43', '2026-10-18 11:22:43'),
(6, 'APAVE MADAGASCAR SARL', '2026-10-18 12:49:34', '2026-10-18 12:49:34');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `journal`
--

CREATE TABLE `journal` (
  `id_journal` bigint(20) UNSIGNED NOT NULL,
  `numero_piece` varchar(50) NOT NULL,
  `date_operation` date NOT NULL,
  `libelle` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_factures`
--

CREATE TABLE `ligne_factures` (
  `id_ligne` bigint(20) UNSIGNED NOT NULL,
  `id_facture` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(200) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` decimal(12,2) NOT NULL,
  `montant` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ligne_factures`
--

INSERT INTO `ligne_factures` (`id_ligne`, `id_facture`, `designation`, `quantite`, `prix_unitaire`, `montant`, `created_at`, `updated_at`) VALUES
(2, 2, 'Loyer mois de Janvier 2026', 1, 1666666.67, 1666666.67, '2026-09-07 06:59:27', '2026-09-07 06:59:27'),
(3, 3, 'Loyer mois de Janvier 2026', 1, 1666666.67, 1666666.67, '2026-09-07 08:13:36', '2026-09-07 08:13:36'),
(4, 4, 'FER I 140', 14, 677000.00, 9478000.00, '2026-09-09 14:59:38', '2026-09-09 14:59:38'),
(5, 5, 'FER I 140', 14, 677000.00, 9478000.00, '2026-09-09 15:53:42', '2026-09-09 15:53:42'),
(6, 6, 'Vente de marchandises - Riz local 50kg', 20, 45000.00, 900000.00, '2026-09-11 05:34:26', '2026-09-11 05:34:26'),
(7, 6, 'Vente de marchandises - Huile alimentaire 20L', 10, 38000.00, 380000.00, '2026-09-11 05:34:26', '2026-09-11 05:34:26'),
(8, 7, 'Vente de marchandises - Riz local 50kg', 20, 45000.00, 900000.00, '2026-09-24 10:33:32', '2026-09-24 10:33:32'),
(9, 7, 'Vente de marchandises - Huile alimentaire 20L', 10, 38000.00, 380000.00, '2026-09-24 10:33:32', '2026-09-24 10:33:32'),
(10, 9, 'FER CORNIERE 60', 3, 230280.00, 690840.00, '2026-10-07 04:25:38', '2026-10-07 04:25:38'),
(11, 10, 'LOCATION ET ENTRETIEN BOUTEILLE GM OXYGENE du 14/03/2025 au 14/03/2026 - 1 Ans 14/03/2025 au 13/03/2026', 1, 150000.00, 150000.00, '2026-10-07 04:28:13', '2026-10-07 04:28:13'),
(12, 11, 'FER CORNIERE 60', 3, 230280.00, 690840.00, '2026-10-08 02:59:07', '2026-10-08 02:59:07'),
(13, 12, 'LOCATION ET ENTRETIEN BOUTEILLE GM OXYGENE du 14/03/2025 au 14/03/2026 - 1 Ans 14/03/2025 au 13/03/2026', 1, 150000.00, 150000.00, '2026-10-08 03:47:55', '2026-10-08 03:47:55'),
(14, 13, 'BROSSE COUPE DEPM 90 M14 ONDUL 0.35', 1, 53475.00, 53475.00, '2026-10-08 03:49:47', '2026-10-08 03:49:47'),
(15, 14, 'BROSSE COUPE DEPM 90 M14 ONDUL 0.35', 1, 57500.00, 53475.00, '2026-10-18 11:22:43', '2026-10-18 11:22:43'),
(16, 15, 'BROSSE COUPE DEPM 90 M14 ONDUL 0.35', 1, 57500.00, 53475.00, '2026-10-18 11:31:52', '2026-10-18 11:31:52'),
(17, 16, 'Contrôle de validation de réparation de citerne de transport d\'hydrocarbure - Transporteur : TENEBRO - Immatricule N°3336 TBN (100% à la commande)', 1, 2031500.00, 2031500.00, '2026-10-18 12:49:34', '2026-10-18 12:49:34');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_03_141151_create_utilisateurs_table', 1),
(5, '2026_08_09_155543_create_clients_table', 1),
(6, '2026_08_09_155544_create_fournisseurs_table', 1),
(7, '2026_08_09_155545_create_comptes_table', 1),
(8, '2026_08_09_155546_create_tva_table', 1),
(9, '2026_08_09_155547_create_factures_table', 1),
(10, '2026_08_09_155548_create_ligne_factures_table', 1),
(11, '2026_08_09_155549_create_paiements_table', 1),
(12, '2026_08_09_155550_create_charges_table', 1),
(13, '2026_08_09_155551_create_journal_table', 1),
(14, '2026_08_09_155552_create_ecritures_table', 1),
(15, '2026_08_10_151314_add_id_compte_to_tva_table', 1),
(16, '2026_08_10_181514_add_fichier_facture_to_factures_table', 1),
(17, '2026_08_11_112411_make_id_compte_charge_nullable_in_factures_table', 1),
(18, '2026_08_31_093729_modify_mode_paiement_in_paiements_table', 1),
(19, '2026_08_31_093810_make_numero_facture_nullable_in_factures_table', 1),
(20, '2026_08_31_152526_add_id_utilisateur_to_factures_table', 1),
(21, '2026_08_31_235755_modifier_role_utilisateurs', 1),
(22, '2026_09_02_182526_create_entreprises_table', 1),
(23, '2026_09_07_090555_add_vente_support_to_factures_table', 1),
(24, '2026_09_07_152702_add_statut_to_utilisateurs_table', 2),
(25, '2026_09_14_091517_create_departements_table', 3),
(26, '2026_09_14_091746_add_id_departement_to_utilisateurs_table', 3),
(27, '2026_09_14_091828_add_id_departement_to_factures_table', 3);

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `id_paiement` bigint(20) UNSIGNED NOT NULL,
  `id_facture` bigint(20) UNSIGNED NOT NULL,
  `date_paiement` date NOT NULL,
  `montant` decimal(12,2) NOT NULL,
  `mode_paiement` enum('Espèces','Virement bancaire','Chèque','Carte bancaire','Mobile Money') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`id_paiement`, `id_facture`, `date_paiement`, `montant`, `mode_paiement`, `created_at`, `updated_at`) VALUES
(2, 2, '2026-01-05', 2000000.00, 'Chèque', '2026-09-07 06:59:27', '2026-09-11 04:44:22'),
(3, 3, '2026-01-05', 2000000.00, 'Espèces', '2026-09-07 08:13:36', '2026-09-07 08:13:36'),
(4, 4, '2025-10-02', 11373600.00, 'Espèces', '2026-09-09 14:59:38', '2026-09-09 14:59:38'),
(5, 5, '2025-10-02', 11373600.00, 'Espèces', '2026-09-09 15:53:42', '2026-09-09 15:53:42'),
(6, 6, '2026-07-24', 1536000.00, 'Espèces', '2026-09-11 05:34:26', '2026-09-11 05:34:26'),
(7, 7, '2026-08-11', 1536000.00, 'Carte bancaire', '2026-09-24 10:33:32', '2026-10-16 01:29:14'),
(8, 9, '2025-10-02', 829008.00, 'Espèces', '2026-10-07 04:25:38', '2026-10-07 04:25:38'),
(9, 10, '2025-09-11', 180000.00, 'Espèces', '2026-10-07 04:28:13', '2026-10-07 04:28:13'),
(10, 11, '2025-10-02', 829008.00, 'Espèces', '2026-10-08 02:59:07', '2026-10-08 02:59:07'),
(11, 12, '2025-09-11', 180000.00, 'Espèces', '2026-10-08 03:47:55', '2026-10-08 03:47:55'),
(12, 13, '2025-01-10', 64170.00, 'Espèces', '2026-10-08 03:49:47', '2026-10-08 03:49:47'),
(13, 14, '2025-01-10', 64170.00, 'Espèces', '2026-10-18 11:22:43', '2026-10-18 11:22:43'),
(14, 15, '2025-01-10', 64170.00, 'Espèces', '2026-10-18 11:31:52', '2026-10-18 11:31:52'),
(15, 16, '2024-10-24', 2437800.00, 'Espèces', '2026-10-18 12:49:34', '2026-10-18 12:49:34');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('QNnl3dhR4M6JIAKJV9ZbkmRGnCRUR4p4VCoOTylf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2xPdDJKR1phMkxod2J4UElEWHVpWTBIT3d3eXhudWo4dVoxY0YwVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1792402852);

-- --------------------------------------------------------

--
-- Structure de la table `tva`
--

CREATE TABLE `tva` (
  `id_tva` bigint(20) UNSIGNED NOT NULL,
  `taux` decimal(5,2) NOT NULL,
  `montant` decimal(12,2) NOT NULL,
  `type_tva` varchar(50) NOT NULL,
  `id_compte` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tva`
--

INSERT INTO `tva` (`id_tva`, `taux`, `montant`, `type_tva`, `id_compte`, `created_at`, `updated_at`) VALUES
(1, 20.00, 1895600.00, 'TVA déductible', 2, '2026-09-07 06:30:51', '2026-09-07 06:30:51'),
(2, 20.00, 333333.33, 'TVA déductible', 2, '2026-09-07 06:59:27', '2026-09-07 06:59:27'),
(3, 20.00, 333333.33, 'TVA collectée', 5, '2026-09-07 08:13:36', '2026-09-07 08:13:36'),
(4, 20.00, 1895600.00, 'TVA déductible', 2, '2026-09-09 14:59:38', '2026-09-09 14:59:38'),
(5, 20.00, 1895600.00, 'TVA déductible', 2, '2026-09-09 15:53:42', '2026-09-09 15:53:42'),
(6, 20.00, 256000.00, 'TVA déductible', 2, '2026-09-11 05:34:26', '2026-09-11 05:34:26'),
(7, 20.00, 256000.00, 'TVA déductible', 2, '2026-09-24 10:33:32', '2026-09-24 10:33:32'),
(8, 20.00, 138168.00, 'TVA collectée', 5, '2026-10-07 04:25:38', '2026-10-07 04:25:38'),
(9, 20.00, 30000.00, 'TVA déductible', 2, '2026-10-07 04:28:13', '2026-10-07 04:28:13'),
(10, 20.00, 138168.00, 'TVA déductible', 2, '2026-10-08 02:59:07', '2026-10-08 02:59:07'),
(11, 20.00, 30000.00, 'TVA collectée', 9, '2026-10-08 03:47:55', '2026-10-08 03:47:55'),
(12, 20.00, 10695.00, 'TVA collectée', 5, '2026-10-08 03:49:47', '2026-10-08 03:49:47'),
(13, 20.00, 10695.00, 'TVA déductible', 2, '2026-10-18 11:22:43', '2026-10-18 11:22:43'),
(14, 20.00, 10695.00, 'TVA collectée', 5, '2026-10-18 11:31:52', '2026-10-18 11:31:52'),
(15, 20.00, 406300.00, 'TVA déductible', 2, '2026-10-18 12:49:34', '2026-10-18 12:49:34');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('admin','caissier','independant') NOT NULL DEFAULT 'caissier',
  `id_departement` bigint(20) UNSIGNED DEFAULT NULL,
  `statut` varchar(20) NOT NULL DEFAULT 'actif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `email`, `mot_de_passe`, `role`, `id_departement`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'Cabinet', 'admin@facture.com', 'admin123', 'admin', NULL, 'actif', '2026-09-07 06:24:22', '2026-09-07 06:24:22'),
(2, 'Jean Rakotovao', 'jean@facture.com', 'caissier123', 'caissier', NULL, 'actif', '2026-09-07 06:24:22', '2026-09-07 12:42:30'),
(3, 'Marie Rabe', 'marie@facture.com', 'caissier456', 'caissier', NULL, 'desactive', '2026-09-07 06:24:22', '2026-10-16 06:47:56'),
(4, 'Romeo', 'romeo@example.com', 'romeo1234', 'independant', NULL, 'actif', '2026-09-07 11:42:58', '2026-09-07 11:42:58'),
(5, 'Antsa', 'antsa@example.com', '$2y$12$zbQvS24iXpZIeCUvj7VnXe4jm8KLHbf8CO3hF0ooxdyLeyL70mwRG', 'admin', NULL, 'actif', '2026-09-09 10:28:30', '2026-09-11 05:19:15'),
(10, 'Colombiana', 'colombiana@example.com', 'col1234', 'independant', NULL, 'actif', '2026-09-14 05:35:17', '2026-09-14 05:35:17'),
(11, 'roro', 'roro@example.com', 'roro1234', 'caissier', 6, 'actif', '2026-09-14 14:28:58', '2026-09-14 14:28:58'),
(12, 'Jaina', 'jaina@gmail.com', 'jaina124', 'caissier', 5, 'actif', '2026-10-08 05:16:05', '2026-10-08 05:16:05'),
(13, 'Rabe', 'rabe@example.com', 'rabe1234', 'caissier', 5, 'actif', '2026-10-18 12:47:16', '2026-10-18 12:47:16');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Index pour la table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id_charge`),
  ADD KEY `charges_id_compte_foreign` (`id_compte`),
  ADD KEY `charges_id_fournisseur_foreign` (`id_fournisseur`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`id_compte`),
  ADD UNIQUE KEY `comptes_numero_compte_unique` (`numero_compte`);

--
-- Index pour la table `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`id_departement`),
  ADD UNIQUE KEY `departements_nom_unique` (`nom`);

--
-- Index pour la table `ecritures`
--
ALTER TABLE `ecritures`
  ADD PRIMARY KEY (`id_ecriture`),
  ADD KEY `ecritures_id_journal_foreign` (`id_journal`),
  ADD KEY `ecritures_id_compte_foreign` (`id_compte`);

--
-- Index pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD PRIMARY KEY (`id_entreprise`),
  ADD UNIQUE KEY `entreprises_id_utilisateur_unique` (`id_utilisateur`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id_facture`),
  ADD KEY `factures_id_fournisseur_foreign` (`id_fournisseur`),
  ADD KEY `factures_id_compte_charge_foreign` (`id_compte_charge`),
  ADD KEY `factures_id_tva_foreign` (`id_tva`),
  ADD KEY `factures_id_utilisateur_foreign` (`id_utilisateur`),
  ADD KEY `factures_id_client_foreign` (`id_client`),
  ADD KEY `factures_id_compte_produit_foreign` (`id_compte_produit`),
  ADD KEY `factures_id_departement_foreign` (`id_departement`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id_fournisseur`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`id_journal`);

--
-- Index pour la table `ligne_factures`
--
ALTER TABLE `ligne_factures`
  ADD PRIMARY KEY (`id_ligne`),
  ADD KEY `ligne_factures_id_facture_foreign` (`id_facture`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id_paiement`),
  ADD KEY `paiements_id_facture_foreign` (`id_facture`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `tva`
--
ALTER TABLE `tva`
  ADD PRIMARY KEY (`id_tva`),
  ADD KEY `tva_id_compte_foreign` (`id_compte`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `utilisateurs_email_unique` (`email`),
  ADD KEY `utilisateurs_id_departement_foreign` (`id_departement`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `charges`
--
ALTER TABLE `charges`
  MODIFY `id_charge` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `comptes`
--
ALTER TABLE `comptes`
  MODIFY `id_compte` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `departements`
--
ALTER TABLE `departements`
  MODIFY `id_departement` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `ecritures`
--
ALTER TABLE `ecritures`
  MODIFY `id_ecriture` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entreprises`
--
ALTER TABLE `entreprises`
  MODIFY `id_entreprise` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id_facture` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id_fournisseur` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `journal`
--
ALTER TABLE `journal`
  MODIFY `id_journal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_factures`
--
ALTER TABLE `ligne_factures`
  MODIFY `id_ligne` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id_paiement` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `tva`
--
ALTER TABLE `tva`
  MODIFY `id_tva` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `charges`
--
ALTER TABLE `charges`
  ADD CONSTRAINT `charges_id_compte_foreign` FOREIGN KEY (`id_compte`) REFERENCES `comptes` (`id_compte`),
  ADD CONSTRAINT `charges_id_fournisseur_foreign` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseurs` (`id_fournisseur`);

--
-- Contraintes pour la table `ecritures`
--
ALTER TABLE `ecritures`
  ADD CONSTRAINT `ecritures_id_compte_foreign` FOREIGN KEY (`id_compte`) REFERENCES `comptes` (`id_compte`),
  ADD CONSTRAINT `ecritures_id_journal_foreign` FOREIGN KEY (`id_journal`) REFERENCES `journal` (`id_journal`) ON DELETE CASCADE;

--
-- Contraintes pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD CONSTRAINT `entreprises_id_utilisateur_foreign` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `factures_id_client_foreign` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`) ON DELETE SET NULL,
  ADD CONSTRAINT `factures_id_compte_charge_foreign` FOREIGN KEY (`id_compte_charge`) REFERENCES `comptes` (`id_compte`),
  ADD CONSTRAINT `factures_id_compte_produit_foreign` FOREIGN KEY (`id_compte_produit`) REFERENCES `comptes` (`id_compte`) ON DELETE SET NULL,
  ADD CONSTRAINT `factures_id_departement_foreign` FOREIGN KEY (`id_departement`) REFERENCES `departements` (`id_departement`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `factures_id_fournisseur_foreign` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseurs` (`id_fournisseur`),
  ADD CONSTRAINT `factures_id_tva_foreign` FOREIGN KEY (`id_tva`) REFERENCES `tva` (`id_tva`) ON DELETE SET NULL,
  ADD CONSTRAINT `factures_id_utilisateur_foreign` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE SET NULL;

--
-- Contraintes pour la table `ligne_factures`
--
ALTER TABLE `ligne_factures`
  ADD CONSTRAINT `ligne_factures_id_facture_foreign` FOREIGN KEY (`id_facture`) REFERENCES `factures` (`id_facture`) ON DELETE CASCADE;

--
-- Contraintes pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD CONSTRAINT `paiements_id_facture_foreign` FOREIGN KEY (`id_facture`) REFERENCES `factures` (`id_facture`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tva`
--
ALTER TABLE `tva`
  ADD CONSTRAINT `tva_id_compte_foreign` FOREIGN KEY (`id_compte`) REFERENCES `comptes` (`id_compte`) ON DELETE SET NULL;

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_id_departement_foreign` FOREIGN KEY (`id_departement`) REFERENCES `departements` (`id_departement`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

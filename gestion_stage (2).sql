-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 06 juin 2026 à 10:28
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
-- Base de données : `gestion_stage`
--

-- --------------------------------------------------------

--
-- Structure de la table `consulter_offre`
--

CREATE TABLE `consulter_offre` (
  `id_etudiant` int(11) NOT NULL,
  `id_offre` int(11) NOT NULL,
  `date_vue` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consulter_offre`
--

INSERT INTO `consulter_offre` (`id_etudiant`, `id_offre`, `date_vue`) VALUES
(18, 1, '2026-06-06 08:28:33'),
(18, 2, '2026-06-06 08:28:30'),
(18, 3, '2026-06-06 08:28:33');

-- --------------------------------------------------------

--
-- Structure de la table `encadre`
--

CREATE TABLE `encadre` (
  `id_professeurs` int(11) NOT NULL,
  `id_stage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `id_entreprise` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `adresse` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`id_entreprise`, `nom`, `contact`, `adresse`) VALUES
(1, 'TechNova', 'contact@technova.fr', '12 Rue de Paris, Paris'),
(2, 'DataVision', 'rh@datavision.fr', '8 Avenue Lumière, Lyon'),
(3, 'NetSecure', 'contact@netsecure.fr', '15 Boulevard National, Marseille'),
(4, 'MobileSoft', 'jobs@mobilesoft.fr', '22 Rue des Lilas, Toulouse'),
(5, 'CyberShield', 'contact@cybershield.fr', '5 Rue Victor Hugo, Nice'),
(6, 'WebInnov', 'recrutement@webinnov.fr', '40 Quai des Chartrons, Bordeaux'),
(7, 'CloudOps', 'contact@cloudops.fr', '18 Rue Faidherbe, Lille'),
(8, 'API Solutions', 'rh@apisolutions.fr', '7 Rue de Strasbourg, Nantes'),
(9, 'HelpTech', 'support@helptech.fr', '30 Avenue Jean Jaurès, Grenoble'),
(10, 'AI Factory', 'contact@aifactory.fr', '50 Rue Lafayette, Paris'),
(11, 'Projectis', 'jobs@projectis.fr', '14 Rue du Dôme, Strasbourg'),
(12, 'SymfonyCorp', 'contact@symfonycorp.fr', '2 Place Comédie, Montpellier'),
(13, 'DB Experts', 'rh@dbexperts.fr', '11 Rue Saint-Michel, Rennes'),
(14, 'BigData France', 'jobs@bigdatafrance.fr', '90 Avenue République, Paris'),
(15, 'CreativeDesign', 'contact@creativedesign.fr', '3 Rue Garibaldi, Lyon'),
(16, 'PySolutions', 'rh@pysolutions.fr', '27 Rue Alsace Lorraine, Toulouse'),
(17, 'ERP Conseil', 'contact@erpconseil.fr', '44 Rue Paradis, Marseille'),
(18, 'JavaTech', 'jobs@javatech.fr', '10 Rue Rivoli, Paris'),
(19, 'Linux Systems', 'contact@linuxsystems.fr', '6 Rue Solférino, Lille'),
(20, '.NET Services', 'rh@dotnetservices.fr', '55 Rue Sainte-Catherine, Bordeaux'),
(21, 'Cloud Infinity', 'contact@cloudinfinity.fr', '101 Avenue Opéra, Paris'),
(22, 'VueStudio', 'jobs@vuestudio.fr', '9 Rue Crébillon, Nantes'),
(23, 'BI Consulting', 'contact@biconsulting.fr', '16 Promenade des Anglais, Nice'),
(24, 'EmbeddedTech', 'rh@embeddedtech.fr', '4 Rue Ampère, Grenoble'),
(25, 'QA Testing', 'contact@qatesting.fr', '12 Rue des Frères, Strasbourg');

-- --------------------------------------------------------

--
-- Structure de la table `etre`
--

CREATE TABLE `etre` (
  `id_professeurs` int(11) NOT NULL,
  `id_jury` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id_etudiant` int(11) NOT NULL,
  `matricule` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(100) DEFAULT NULL,
  `adresse_email` varchar(150) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `promotion` varchar(50) DEFAULT NULL,
  `groupe_TD` varchar(50) DEFAULT NULL,
  `groupe_TP` varchar(50) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `adresse_postale` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id_etudiant`, `matricule`, `nom`, `prenom`, `telephone`, `date_naissance`, `lieu_naissance`, `adresse_email`, `mot_de_passe`, `promotion`, `groupe_TD`, `groupe_TP`, `id_user`, `adresse_postale`) VALUES
(1, 'ETU2026001', 'Martin', 'Lucas', '0612457890', '2003-04-15', 'Paris', 'lucas.martin@edu.fr', 'lulu123456789', 'M1 Informatique', 'TD1', 'TPA', NULL, '12 Rue Victor Hugo, Paris'),
(2, 'ETU2026002', 'Bernard', 'Emma', '0678451230', '2002-11-08', 'Lyon', 'emma.bernard@edu.fr', '', 'M2 Data Science', 'TD2', 'TPB', NULL, '8 Avenue Lumière, Lyon'),
(3, 'ETU2026003', 'Petit', 'Nathan', '0654789123', '2001-09-22', 'Marseille', 'nathan.petit@edu.fr', '', 'Licence Réseaux', 'TD1', 'TPC', NULL, '22 Boulevard National, Marseille'),
(4, 'ETU2026004', 'Robert', 'Chloé', '0611122233', '2003-01-10', 'Toulouse', 'chloe.robert@edu.fr', '', 'M1 Informatique', 'TD3', 'TPA', NULL, '5 Rue des Lilas, Toulouse'),
(5, 'ETU2026005', 'Richard', 'Hugo', '0688997744', '2002-06-18', 'Nice', 'hugo.richard@edu.fr', '', 'Master Cybersécurité', 'TD2', 'TPB', NULL, '18 Rue Victor Hugo, Nice'),
(6, 'ETU2026006', 'Durand', 'Sarah', '0677889900', '2003-02-14', 'Bordeaux', 'sarah.durand@edu.fr', '', 'Licence Informatique', 'TD1', 'TPC', NULL, '30 Quai des Chartrons, Bordeaux'),
(7, 'ETU2026007', 'Dubois', 'Léa', '0666554433', '2002-08-05', 'Lille', 'lea.dubois@edu.fr', '', 'M2 Informatique', 'TD2', 'TPA', NULL, '14 Rue Faidherbe, Lille'),
(8, 'ETU2026008', 'Moreau', 'Tom', '0699887766', '2001-12-01', 'Nantes', 'tom.moreau@edu.fr', '', 'M1 Développement', 'TD3', 'TPB', NULL, '7 Rue de Strasbourg, Nantes'),
(9, 'ETU2026009', 'Simon', 'Camille', '0612345678', '2003-07-27', 'Grenoble', 'camille.simon@edu.fr', '', 'BTS SIO', 'TD1', 'TPC', NULL, '40 Avenue Jean Jaurès, Grenoble'),
(10, 'ETU2026010', 'Laurent', 'Jules', '0688776655', '2002-03-30', 'Paris', 'jules.laurent@edu.fr', '', 'M2 Intelligence Artificielle', 'TD2', 'TPA', NULL, '55 Rue Lafayette, Paris'),
(11, 'ETU2026011', 'Lefebvre', 'Manon', '0655443322', '2001-10-11', 'Strasbourg', 'manon.lefebvre@edu.fr', '', 'Master MIAGE', 'TD3', 'TPB', NULL, '9 Rue du Dôme, Strasbourg'),
(12, 'ETU2026012', 'Michel', 'Enzo', '0677001122', '2003-05-09', 'Montpellier', 'enzo.michel@edu.fr', '', 'Licence Pro Développement', 'TD1', 'TPC', NULL, '3 Place Comédie, Montpellier'),
(13, 'ETU2026013', 'Garcia', 'Inès', '0666112233', '2002-09-14', 'Rennes', 'ines.garcia@edu.fr', '', 'Master Base de Données', 'TD2', 'TPA', NULL, '16 Rue Saint-Michel, Rennes'),
(14, 'ETU2026014', 'David', 'Noah', '0611998877', '2001-11-19', 'Paris', 'noah.david@edu.fr', '', 'M2 Big Data', 'TD3', 'TPB', NULL, '72 Avenue République, Paris'),
(15, 'ETU2026015', 'Roux', 'Alice', '0699001122', '2003-06-25', 'Lyon', 'alice.roux@edu.fr', '', 'Licence Design Numérique', 'TD1', 'TPC', NULL, '11 Rue Garibaldi, Lyon'),
(16, '', 'Summers', 'Buffy', '0548697358', NULL, NULL, 'buffy@gmail.com', '$2y$10$0nM0iBy2CiAH9MXxMPvKIevGRmth09L9KjFXbHWauw/GjERY0xGgS', 'M1', NULL, NULL, NULL, NULL),
(18, 'ETU20263873', 'Land', 'mercury', '0844269776', NULL, NULL, 'hoeirfff@gmail.com', '$2y$10$XrbXnvpuU9cnfxOp7dP6Pe33BdCqIGwXf.la8BHsz.FLrOvsGKWHC', 'M3', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `jury`
--

CREATE TABLE `jury` (
  `id_jury` int(11) NOT NULL,
  `id_soutenance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `maitre_de_stage`
--

CREATE TABLE `maitre_de_stage` (
  `id_maitre_stage` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `id_entreprise` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offre_stage`
--

CREATE TABLE `offre_stage` (
  `id_offre` int(11) NOT NULL,
  `intitule` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `competences` text DEFAULT NULL,
  `duree` varchar(50) DEFAULT NULL,
  `lieu` varchar(100) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `remuneration` decimal(10,2) DEFAULT NULL,
  `promotion` varchar(50) DEFAULT NULL,
  `annee` year(4) DEFAULT NULL,
  `id_entreprise` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `offre_stage`
--

INSERT INTO `offre_stage` (`id_offre`, `intitule`, `description`, `competences`, `duree`, `lieu`, `date_debut`, `date_fin`, `remuneration`, `promotion`, `annee`, `id_entreprise`) VALUES
(1, 'Développeur Web Full Stack', 'Participation au développement d’une plateforme web de gestion interne.', 'PHP, Laravel, MySQL, HTML, CSS, JavaScript', '6 mois', 'Paris', '2026-02-01', '2026-07-31', 850.00, 'M1 Informatique', '2026', 1),
(2, 'Analyste de Données', 'Analyse et visualisation des données commerciales.', 'Python, Power BI, SQL, Excel', '4 mois', 'Lyon', '2026-03-01', '2026-06-30', 700.00, 'M2 Data Science', '2026', 2),
(3, 'Administrateur Réseau', 'Maintenance et supervision des infrastructures réseau.', 'Cisco, TCP/IP, Linux, Sécurité réseau', '5 mois', 'Marseille', '2026-01-15', '2026-06-15', 780.00, 'Licence Réseaux', '2026', 3),
(4, 'Développeur Mobile Android', 'Création d’applications mobiles Android.', 'Java, Kotlin, Android Studio', '6 mois', 'Toulouse', '2026-02-10', '2026-08-10', 900.00, 'M1 Informatique', '2026', 4),
(5, 'Assistant Cybersécurité', 'Audit de sécurité et tests de vulnérabilité.', 'Kali Linux, Sécurité, Python', '4 mois', 'Nice', '2026-04-01', '2026-07-31', 850.00, 'Master Cybersécurité', '2026', 5),
(6, 'Développeur Front-End', 'Développement d’interfaces utilisateurs modernes.', 'ReactJS, HTML, CSS, JavaScript', '5 mois', 'Bordeaux', '2026-02-15', '2026-07-15', 820.00, 'Licence Informatique', '2026', 6),
(7, 'Ingénieur DevOps Junior', 'Automatisation et déploiement des applications.', 'Docker, Kubernetes, Jenkins, Linux', '6 mois', 'Lille', '2026-01-20', '2026-07-20', 950.00, 'M2 Informatique', '2026', 7),
(8, 'Développeur Back-End', 'Conception d’API REST et gestion de bases de données.', 'Node.js, Express, MongoDB', '5 mois', 'Nantes', '2026-03-01', '2026-08-01', 870.00, 'M1 Développement', '2026', 8),
(9, 'Technicien Support Informatique', 'Assistance technique et maintenance du parc informatique.', 'Windows, Linux, Support utilisateur', '3 mois', 'Grenoble', '2026-05-01', '2026-07-31', 600.00, 'BTS SIO', '2026', 9),
(10, 'Développeur IA', 'Développement de modèles de machine learning.', 'Python, TensorFlow, Machine Learning', '6 mois', 'Paris', '2026-02-01', '2026-07-31', 1100.00, 'M2 Intelligence Artificielle', '2026', 10),
(11, 'Chef de Projet Junior', 'Gestion et suivi des projets informatiques.', 'Gestion de projet, Scrum, Jira', '4 mois', 'Strasbourg', '2026-03-10', '2026-07-10', 750.00, 'Master MIAGE', '2026', 11),
(12, 'Développeur PHP', 'Maintenance d’une application e-commerce.', 'PHP, Symfony, MySQL', '5 mois', 'Montpellier', '2026-02-15', '2026-07-15', 830.00, 'Licence Pro Développement', '2026', 12),
(13, 'Administrateur Base de Données', 'Optimisation et sauvegarde des bases de données.', 'Oracle, SQL Server, MySQL', '6 mois', 'Rennes', '2026-01-15', '2026-07-15', 920.00, 'Master Base de Données', '2026', 13),
(14, 'Data Engineer', 'Mise en place de pipelines de données.', 'Python, Spark, Hadoop, SQL', '6 mois', 'Paris', '2026-02-20', '2026-08-20', 1200.00, 'M2 Big Data', '2026', 14),
(15, 'UX/UI Designer', 'Conception d’interfaces ergonomiques et modernes.', 'Figma, Adobe XD, UX Design', '4 mois', 'Lyon', '2026-04-01', '2026-07-31', 700.00, 'Licence Design Numérique', '2026', 15),
(16, 'Développeur Python', 'Développement d’outils d’automatisation.', 'Python, Flask, API REST', '5 mois', 'Toulouse', '2026-03-01', '2026-08-01', 880.00, 'Licence Informatique', '2026', 16),
(17, 'Consultant ERP Junior', 'Paramétrage et support d’un ERP.', 'SAP, Gestion, SQL', '6 mois', 'Marseille', '2026-02-01', '2026-08-01', 950.00, 'Master Systèmes d’Information', '2026', 17),
(18, 'Développeur Java', 'Développement d’applications métier.', 'Java, Spring Boot, PostgreSQL', '6 mois', 'Paris', '2026-01-10', '2026-07-10', 980.00, 'M1 Génie Logiciel', '2026', 18),
(19, 'Administrateur Système Linux', 'Gestion des serveurs Linux et automatisation.', 'Linux, Bash, Ansible', '5 mois', 'Lille', '2026-03-15', '2026-08-15', 850.00, 'Licence Réseaux', '2026', 19),
(20, 'Développeur .NET', 'Conception d’applications desktop et web.', 'C#, .NET, SQL Server', '5 mois', 'Bordeaux', '2026-02-15', '2026-07-15', 870.00, 'Master Développement Logiciel', '2026', 20),
(21, 'Ingénieur Cloud Junior', 'Déploiement d’infrastructures cloud.', 'AWS, Azure, Docker', '6 mois', 'Paris', '2026-02-01', '2026-08-01', 1150.00, 'M2 Cloud Computing', '2026', 21),
(22, 'Développeur Vue.js', 'Création d’interfaces web dynamiques.', 'Vue.js, JavaScript, CSS', '4 mois', 'Nantes', '2026-04-01', '2026-07-31', 780.00, 'Licence Informatique', '2026', 22),
(23, 'Assistant Business Intelligence', 'Création de tableaux de bord décisionnels.', 'Power BI, SQL, Excel', '5 mois', 'Nice', '2026-03-01', '2026-08-01', 760.00, 'Master BI', '2026', 23),
(24, 'Développeur C++', 'Développement de logiciels embarqués.', 'C++, Qt, Linux embarqué', '6 mois', 'Grenoble', '2026-01-20', '2026-07-20', 990.00, 'Master Systèmes Embarqués', '2026', 24),
(25, 'Testeur QA Logiciel', 'Tests fonctionnels et automatisés des applications.', 'Selenium, Jira, Tests automatisés', '4 mois', 'Strasbourg', '2026-05-01', '2026-08-31', 720.00, 'Licence Informatique', '2026', 25),
(26, 'Développeur Web Full Stack', 'Participation au développement d’une plateforme web de gestion interne.', 'PHP, Laravel, MySQL, HTML, CSS, JavaScript', '6 mois', 'Paris', '2026-02-01', '2026-07-31', 850.00, 'M1 Informatique', '2026', 1),
(27, 'Analyste de Données', 'Analyse et visualisation des données commerciales.', 'Python, Power BI, SQL, Excel', '4 mois', 'Lyon', '2026-03-01', '2026-06-30', 700.00, 'M2 Data Science', '2026', 2),
(28, 'Administrateur Réseau', 'Maintenance et supervision des infrastructures réseau.', 'Cisco, TCP/IP, Linux, Sécurité réseau', '5 mois', 'Marseille', '2026-01-15', '2026-06-15', 780.00, 'Licence Réseaux', '2026', 3),
(29, 'Développeur Mobile Android', 'Création d’applications mobiles Android.', 'Java, Kotlin, Android Studio', '6 mois', 'Toulouse', '2026-02-10', '2026-08-10', 900.00, 'M1 Informatique', '2026', 4),
(30, 'Assistant Cybersécurité', 'Audit de sécurité et tests de vulnérabilité.', 'Kali Linux, Sécurité, Python', '4 mois', 'Nice', '2026-04-01', '2026-07-31', 850.00, 'Master Cybersécurité', '2026', 5),
(31, 'Développeur Front-End', 'Développement d’interfaces utilisateurs modernes.', 'ReactJS, HTML, CSS, JavaScript', '5 mois', 'Bordeaux', '2026-02-15', '2026-07-15', 820.00, 'Licence Informatique', '2026', 6),
(32, 'Ingénieur DevOps Junior', 'Automatisation et déploiement des applications.', 'Docker, Kubernetes, Jenkins, Linux', '6 mois', 'Lille', '2026-01-20', '2026-07-20', 950.00, 'M2 Informatique', '2026', 7),
(33, 'Développeur Back-End', 'Conception d’API REST et gestion de bases de données.', 'Node.js, Express, MongoDB', '5 mois', 'Nantes', '2026-03-01', '2026-08-01', 870.00, 'M1 Développement', '2026', 8),
(34, 'Technicien Support Informatique', 'Assistance technique et maintenance du parc informatique.', 'Windows, Linux, Support utilisateur', '3 mois', 'Grenoble', '2026-05-01', '2026-07-31', 600.00, 'BTS SIO', '2026', 9),
(35, 'Développeur IA', 'Développement de modèles de machine learning.', 'Python, TensorFlow, Machine Learning', '6 mois', 'Paris', '2026-02-01', '2026-07-31', 1100.00, 'M2 Intelligence Artificielle', '2026', 10),
(36, 'Chef de Projet Junior', 'Gestion et suivi des projets informatiques.', 'Gestion de projet, Scrum, Jira', '4 mois', 'Strasbourg', '2026-03-10', '2026-07-10', 750.00, 'Master MIAGE', '2026', 11),
(37, 'Développeur PHP', 'Maintenance d’une application e-commerce.', 'PHP, Symfony, MySQL', '5 mois', 'Montpellier', '2026-02-15', '2026-07-15', 830.00, 'Licence Pro Développement', '2026', 12),
(38, 'Administrateur Base de Données', 'Optimisation et sauvegarde des bases de données.', 'Oracle, SQL Server, MySQL', '6 mois', 'Rennes', '2026-01-15', '2026-07-15', 920.00, 'Master Base de Données', '2026', 13),
(39, 'Data Engineer', 'Mise en place de pipelines de données.', 'Python, Spark, Hadoop, SQL', '6 mois', 'Paris', '2026-02-20', '2026-08-20', 1200.00, 'M2 Big Data', '2026', 14),
(40, 'UX/UI Designer', 'Conception d’interfaces ergonomiques et modernes.', 'Figma, Adobe XD, UX Design', '4 mois', 'Lyon', '2026-04-01', '2026-07-31', 700.00, 'Licence Design Numérique', '2026', 15),
(41, 'Développeur Python', 'Développement d’outils d’automatisation.', 'Python, Flask, API REST', '5 mois', 'Toulouse', '2026-03-01', '2026-08-01', 880.00, 'Licence Informatique', '2026', 16),
(42, 'Consultant ERP Junior', 'Paramétrage et support d’un ERP.', 'SAP, Gestion, SQL', '6 mois', 'Marseille', '2026-02-01', '2026-08-01', 950.00, 'Master Systèmes d’Information', '2026', 17),
(43, 'Développeur Java', 'Développement d’applications métier.', 'Java, Spring Boot, PostgreSQL', '6 mois', 'Paris', '2026-01-10', '2026-07-10', 980.00, 'M1 Génie Logiciel', '2026', 18),
(44, 'Administrateur Système Linux', 'Gestion des serveurs Linux et automatisation.', 'Linux, Bash, Ansible', '5 mois', 'Lille', '2026-03-15', '2026-08-15', 850.00, 'Licence Réseaux', '2026', 19),
(45, 'Développeur .NET', 'Conception d’applications desktop et web.', 'C#, .NET, SQL Server', '5 mois', 'Bordeaux', '2026-02-15', '2026-07-15', 870.00, 'Master Développement Logiciel', '2026', 20),
(46, 'Développeur Web Full Stack', 'Développement d’une application web interne pour la gestion RH.', 'PHP, Laravel, MySQL, HTML, CSS, JavaScript', '6 mois', 'Paris', '2026-02-10', '2026-08-10', 850.00, 'M1 Informatique', '2026', 1),
(47, 'Data Analyst Junior', 'Analyse de données commerciales et création de dashboards.', 'Python, SQL, Power BI, Excel', '5 mois', 'Lyon', '2026-02-15', '2026-07-15', 780.00, 'M2 Data Science', '2026', 2),
(48, 'Administrateur Système Linux', 'Gestion et maintenance de serveurs Linux.', 'Linux, Bash, Ansible, Réseaux', '6 mois', 'Lille', '2026-03-01', '2026-09-01', 900.00, 'Licence Réseaux', '2026', 3),
(49, 'Développeur Mobile Android', 'Création d’une application mobile de réservation.', 'Kotlin, Java, Android Studio', '6 mois', 'Toulouse', '2026-03-10', '2026-09-10', 920.00, 'M1 Informatique', '2026', 4),
(50, 'Ingénieur DevOps Junior', 'Automatisation des déploiements cloud.', 'Docker, Kubernetes, Jenkins, AWS', '6 mois', 'Paris', '2026-03-15', '2026-09-15', 1100.00, 'M2 Informatique', '2026', 5),
(51, 'Développeur Front-End React', 'Création d’interfaces web modernes et responsives.', 'ReactJS, HTML, CSS, JavaScript', '5 mois', 'Nantes', '2026-02-20', '2026-07-20', 800.00, 'Licence Informatique', '2026', 6),
(52, 'Technicien Support IT', 'Support utilisateur et maintenance informatique.', 'Windows, Linux, Réseaux', '4 mois', 'Marseille', '2026-02-25', '2026-06-25', 600.00, 'BTS SIO', '2026', 7),
(53, 'Développeur Python Backend', 'Développement d’API et services backend.', 'Python, Flask, API REST, SQL', '6 mois', 'Bordeaux', '2026-03-05', '2026-09-05', 950.00, 'Licence Informatique', '2026', 8),
(54, 'UX/UI Designer', 'Conception d’interfaces utilisateur modernes.', 'Figma, Adobe XD, UX Design', '4 mois', 'Nice', '2026-02-18', '2026-06-18', 700.00, 'Licence Design Numérique', '2026', 9),
(55, 'Ingénieur Cloud Junior', 'Déploiement d’infrastructures cloud AWS.', 'AWS, Azure, Docker, Linux', '6 mois', 'Paris', '2026-03-20', '2026-09-20', 1150.00, 'M2 Cloud Computing', '2026', 10),
(56, 'Développeur Web Full Stack', 'Développement et maintenance d’une application web interne.', 'PHP, Laravel, MySQL, JavaScript, HTML, CSS', '6 mois', 'Paris', '2026-06-07', '2026-12-07', 900.00, 'M1 Informatique', '2026', 1),
(57, 'Data Analyst Junior', 'Analyse de données et création de tableaux de bord décisionnels.', 'Python, SQL, Power BI, Excel', '5 mois', 'Lyon', '2026-06-07', '2026-11-07', 800.00, 'M2 Data Science', '2026', 2),
(58, 'Développeur Backend API', 'Création et optimisation d’API REST pour services internes.', 'Node.js, Express, MongoDB, API REST', '6 mois', 'Nantes', '2026-06-07', '2026-12-07', 950.00, 'Licence Informatique', '2026', 3),
(59, 'Développeur Web Full Stack', 'Développement et maintenance d’une application web interne.', 'PHP, Laravel, MySQL, JavaScript, HTML, CSS', '6 mois', 'Paris', '2026-06-07', '2026-12-07', 900.00, 'M1 Informatique', '2026', 1),
(60, 'Data Analyst Junior', 'Analyse de données et création de tableaux de bord décisionnels.', 'Python, SQL, Power BI, Excel', '5 mois', 'Lyon', '2026-06-07', '2026-11-07', 800.00, 'M2 Data Science', '2026', 2),
(61, 'Développeur Backend API', 'Création et optimisation d’API REST pour services internes.', 'Node.js, Express, MongoDB, API REST', '6 mois', 'Nantes', '2026-06-07', '2026-12-07', 950.00, 'Licence Informatique', '2026', 3);

-- --------------------------------------------------------

--
-- Structure de la table `postuler`
--

CREATE TABLE `postuler` (
  `id_etudiant` int(11) NOT NULL,
  `id_offre` int(11) NOT NULL,
  `date_postulation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `postuler`
--

INSERT INTO `postuler` (`id_etudiant`, `id_offre`, `date_postulation`) VALUES
(1, 1, '2026-03-01 10:15:00'),
(1, 2, '2026-03-02 11:20:00'),
(2, 3, '2026-03-03 09:10:00'),
(2, 4, '2026-03-04 14:30:00'),
(3, 5, '2026-03-05 16:00:00'),
(3, 6, '2026-03-06 08:45:00'),
(4, 7, '2026-03-07 12:00:00'),
(4, 8, '2026-03-08 13:15:00'),
(5, 9, '2026-03-09 10:00:00'),
(5, 10, '2026-03-10 11:00:00'),
(6, 11, '2026-03-11 09:30:00'),
(6, 12, '2026-03-12 15:20:00'),
(7, 13, '2026-03-13 17:10:00'),
(7, 14, '2026-03-14 10:40:00'),
(8, 15, '2026-03-15 11:25:00'),
(8, 16, '2026-03-16 09:50:00'),
(9, 17, '2026-03-17 14:10:00'),
(9, 18, '2026-03-18 16:45:00'),
(10, 19, '2026-03-19 10:30:00'),
(10, 20, '2026-03-20 11:55:00'),
(18, 1, '2026-06-06 07:24:52'),
(18, 2, '2026-06-06 08:39:11');

-- --------------------------------------------------------

--
-- Structure de la table `professeurs`
--

CREATE TABLE `professeurs` (
  `id_professeurs` int(11) NOT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'professeur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `professeurs`
--

INSERT INTO `professeurs` (`id_professeurs`, `grade`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`) VALUES
(1, 'Administrateur', 'Mathias', 'Admin', 'mathias.admin@gestionstage.fr', '', 'admin'),
(2, 'Administrateur', 'Idriss', 'Admin', 'idriss.admin@gestionstage.fr', '', 'admin'),
(3, 'Administrateur', 'Sarah', 'Admin', 'sarah.admin@gestionstage.fr', '', 'admin'),
(4, 'Jury', 'Martin', 'Claire', 'claire.martin@univ.fr', '$2y$10$8ZkQpQv9qQvX1c8Qk9mO8eYQxZ3kQm2qv8Jt9pQm7vQz6mQp9a1K', 'professeur'),
(5, 'Jury', 'Bernard', 'Lucas', 'lucas.bernard@univ.fr', '$2y$10$9kQpQv8qQvX1c8Qk9mO8eYQxZ3kQm2qv8Jt9pQm7vQz6mQp9a2L', 'professeur'),
(6, 'Jury', 'Durand', 'Sophie', 'sophie.durand@univ.fr', '$2y$10$7kQpQv7qQvX1c8Qk9mO8eYQxZ3kQm2qv8Jt9pQm7vQz6mQp9a3D', 'professeur'),
(7, 'Référent', 'Petit', 'Antoine', 'antoine.petit@univ.fr', '$2y$10$6kQpQv6qQvX1c8Qk9mO8eYQxZ3kQm2qv8Jt9pQm7vQz6mQp9a4P', 'professeur'),
(8, 'Référent', 'Robert', 'Emma', 'emma.robert@univ.fr', '$2y$10$5kQpQv5qQvX1c8Qk9mO8eYQxZ3kQm2qv8Jt9pQm7vQz6mQp9a5R', 'professeur'),
(9, 'Enseignant', 'Lefevre', 'Julien', 'julien.lefevre@univ.fr', '$2y$10$4kQpQv4qQvX1c8Qk9mO8eYQxZ3kQm2qv8Jt9pQm7vQz6mQp9a6L', 'professeur'),
(10, 'Enseignant', 'Moreau', 'Camille', 'camille.moreau@univ.fr', '$2y$10$3kQpQv3qQvX1c8Qk9mO8eYQxZ3kQm2qv8Jt9pQm7vQz6mQp9a7M', 'professeur');

-- --------------------------------------------------------

--
-- Structure de la table `soutenance`
--

CREATE TABLE `soutenance` (
  `id_soutenance` int(11) NOT NULL,
  `date_soutenance` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `salle` varchar(50) DEFAULT NULL,
  `note_oral` decimal(5,2) DEFAULT NULL,
  `note_rapport1` decimal(5,2) DEFAULT NULL,
  `note_rapport2` decimal(5,2) DEFAULT NULL,
  `id_stage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

CREATE TABLE `stage` (
  `id_stage` int(11) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `convention` varchar(255) DEFAULT NULL,
  `id_etudiant` int(11) DEFAULT NULL,
  `id_entreprise` int(11) DEFAULT NULL,
  `id_maitre_stage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivi_recherche`
--

CREATE TABLE `suivi_recherche` (
  `id_suivi` int(11) NOT NULL,
  `entreprises_contactees` int(11) DEFAULT 0,
  `offres_consultees` int(11) DEFAULT 0,
  `candidatures_envoyees` int(11) DEFAULT 0,
  `id_etudiant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivre`
--

CREATE TABLE `suivre` (
  `id_professeurs` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `annee_de_suivi` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `suivre`
--

INSERT INTO `suivre` (`id_professeurs`, `id_etudiant`, `annee_de_suivi`) VALUES
(7, 1, '2019'),
(7, 3, '2021'),
(7, 5, '2023'),
(7, 7, '2025'),
(7, 16, '2026'),
(8, 2, '2020'),
(8, 4, '2022'),
(8, 6, '2024'),
(8, 8, '2026'),
(8, 18, '2026');

-- --------------------------------------------------------

--
-- Structure de la table `transmet`
--

CREATE TABLE `transmet` (
  `id_professeurs` int(11) NOT NULL,
  `id_offre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `consulter_offre`
--
ALTER TABLE `consulter_offre`
  ADD PRIMARY KEY (`id_etudiant`,`id_offre`);

--
-- Index pour la table `encadre`
--
ALTER TABLE `encadre`
  ADD PRIMARY KEY (`id_professeurs`,`id_stage`),
  ADD KEY `fk_encadre_stage` (`id_stage`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`id_entreprise`);

--
-- Index pour la table `etre`
--
ALTER TABLE `etre`
  ADD PRIMARY KEY (`id_professeurs`,`id_jury`),
  ADD KEY `fk_etre_jury` (`id_jury`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id_etudiant`),
  ADD UNIQUE KEY `matricule` (`matricule`),
  ADD UNIQUE KEY `adresse_email` (`adresse_email`);

--
-- Index pour la table `jury`
--
ALTER TABLE `jury`
  ADD PRIMARY KEY (`id_jury`),
  ADD KEY `fk_jury_soutenance` (`id_soutenance`);

--
-- Index pour la table `maitre_de_stage`
--
ALTER TABLE `maitre_de_stage`
  ADD PRIMARY KEY (`id_maitre_stage`),
  ADD KEY `fk_mds_entreprise` (`id_entreprise`);

--
-- Index pour la table `offre_stage`
--
ALTER TABLE `offre_stage`
  ADD PRIMARY KEY (`id_offre`),
  ADD KEY `fk_offre_entreprise` (`id_entreprise`);

--
-- Index pour la table `postuler`
--
ALTER TABLE `postuler`
  ADD PRIMARY KEY (`id_etudiant`,`id_offre`),
  ADD KEY `fk_postuler_offre` (`id_offre`);

--
-- Index pour la table `professeurs`
--
ALTER TABLE `professeurs`
  ADD PRIMARY KEY (`id_professeurs`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `soutenance`
--
ALTER TABLE `soutenance`
  ADD PRIMARY KEY (`id_soutenance`),
  ADD UNIQUE KEY `id_stage` (`id_stage`);

--
-- Index pour la table `stage`
--
ALTER TABLE `stage`
  ADD PRIMARY KEY (`id_stage`),
  ADD UNIQUE KEY `id_etudiant` (`id_etudiant`),
  ADD KEY `fk_stage_entreprise` (`id_entreprise`),
  ADD KEY `fk_stage_maitre` (`id_maitre_stage`);

--
-- Index pour la table `suivi_recherche`
--
ALTER TABLE `suivi_recherche`
  ADD PRIMARY KEY (`id_suivi`),
  ADD UNIQUE KEY `id_etudiant` (`id_etudiant`);

--
-- Index pour la table `suivre`
--
ALTER TABLE `suivre`
  ADD PRIMARY KEY (`id_professeurs`,`id_etudiant`,`annee_de_suivi`);

--
-- Index pour la table `transmet`
--
ALTER TABLE `transmet`
  ADD PRIMARY KEY (`id_professeurs`,`id_offre`),
  ADD KEY `fk_transmet_offre` (`id_offre`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `id_entreprise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id_etudiant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `jury`
--
ALTER TABLE `jury`
  MODIFY `id_jury` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `maitre_de_stage`
--
ALTER TABLE `maitre_de_stage`
  MODIFY `id_maitre_stage` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `offre_stage`
--
ALTER TABLE `offre_stage`
  MODIFY `id_offre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `professeurs`
--
ALTER TABLE `professeurs`
  MODIFY `id_professeurs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `soutenance`
--
ALTER TABLE `soutenance`
  MODIFY `id_soutenance` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stage`
--
ALTER TABLE `stage`
  MODIFY `id_stage` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `suivi_recherche`
--
ALTER TABLE `suivi_recherche`
  MODIFY `id_suivi` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `encadre`
--
ALTER TABLE `encadre`
  ADD CONSTRAINT `fk_encadre_prof` FOREIGN KEY (`id_professeurs`) REFERENCES `professeurs` (`id_professeurs`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_encadre_stage` FOREIGN KEY (`id_stage`) REFERENCES `stage` (`id_stage`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etre`
--
ALTER TABLE `etre`
  ADD CONSTRAINT `fk_etre_jury` FOREIGN KEY (`id_jury`) REFERENCES `jury` (`id_jury`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_etre_prof` FOREIGN KEY (`id_professeurs`) REFERENCES `professeurs` (`id_professeurs`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `jury`
--
ALTER TABLE `jury`
  ADD CONSTRAINT `fk_jury_soutenance` FOREIGN KEY (`id_soutenance`) REFERENCES `soutenance` (`id_soutenance`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `maitre_de_stage`
--
ALTER TABLE `maitre_de_stage`
  ADD CONSTRAINT `fk_mds_entreprise` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id_entreprise`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `offre_stage`
--
ALTER TABLE `offre_stage`
  ADD CONSTRAINT `fk_offre_entreprise` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id_entreprise`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `postuler`
--
ALTER TABLE `postuler`
  ADD CONSTRAINT `fk_postuler_etudiant` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_postuler_offre` FOREIGN KEY (`id_offre`) REFERENCES `offre_stage` (`id_offre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `soutenance`
--
ALTER TABLE `soutenance`
  ADD CONSTRAINT `fk_soutenance_stage` FOREIGN KEY (`id_stage`) REFERENCES `stage` (`id_stage`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `stage`
--
ALTER TABLE `stage`
  ADD CONSTRAINT `fk_stage_entreprise` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id_entreprise`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stage_etudiant` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stage_maitre` FOREIGN KEY (`id_maitre_stage`) REFERENCES `maitre_de_stage` (`id_maitre_stage`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `suivi_recherche`
--
ALTER TABLE `suivi_recherche`
  ADD CONSTRAINT `fk_suivi_etudiant` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `transmet`
--
ALTER TABLE `transmet`
  ADD CONSTRAINT `fk_transmet_offre` FOREIGN KEY (`id_offre`) REFERENCES `offre_stage` (`id_offre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transmet_prof` FOREIGN KEY (`id_professeurs`) REFERENCES `professeurs` (`id_professeurs`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

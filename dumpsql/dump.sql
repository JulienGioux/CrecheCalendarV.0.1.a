-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 12 oct. 2020 à 21:31
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `crechecalendar`
--

-- --------------------------------------------------------

--
-- Structure de la table `calendar_slots_childs`
--

CREATE TABLE `calendar_slots_childs` (
  `calendarSlots_id` int(11) NOT NULL,
  `slots_start` datetime NOT NULL,
  `slots_end` datetime NOT NULL,
  `notes` text DEFAULT NULL,
  `child_id` int(11) NOT NULL,
  `slot_types_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `calendar_slots_employees`
--

CREATE TABLE `calendar_slots_employees` (
  `calendarSlots_id` int(11) NOT NULL,
  `slots_start` date NOT NULL,
  `slots_end` date NOT NULL,
  `notes` text NOT NULL,
  `slot_types_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `employees_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `childs`
--

CREATE TABLE `childs` (
  `child_id` int(11) NOT NULL,
  `fName` varchar(100) NOT NULL,
  `lName` varchar(100) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `photo_profil_name` varchar(255) NOT NULL DEFAULT 'childProfil.png',
  `parent_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `creche_id` int(11) NOT NULL,
  `gender_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `childs`
--

INSERT INTO `childs` (`child_id`, `fName`, `lName`, `dateOfBirth`, `photo_profil_name`, `parent_id`, `section_id`, `creche_id`, `gender_id`) VALUES
(59, 'Gaston', 'De Lajungle', '2020-10-05', 'childProfil.png', 38, 81, 54, 1);

-- --------------------------------------------------------

--
-- Structure de la table `creche`
--

CREATE TABLE `creche` (
  `creche_id` int(11) NOT NULL,
  `crecheName` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `cp` varchar(5) NOT NULL,
  `city` varchar(100) NOT NULL,
  `img_logo_name` varchar(255) DEFAULT 'defaultCrecheLogo.png',
  `description` text DEFAULT NULL,
  `siren` varchar(9) NOT NULL,
  `nic` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `creche`
--

INSERT INTO `creche` (`creche_id`, `crecheName`, `email`, `phone`, `address1`, `address2`, `cp`, `city`, `img_logo_name`, `description`, `siren`, `nic`) VALUES
(53, 'xcvxcv', 'arcencievnvl@mail.fr', '+33613444444', 'ASDDD -21 rue D&#39;all', '1 er étage', '76600', 'Le Havre', 'defaultCrecheLogo.png', NULL, '887633113', NULL),
(54, 'Kid&#39;s HouseBis', 'test@fdd.fr', '+33613444444', '31 rue du Général De Gaule', '', '76620', 'Le Havre', 'defaultCrecheLogo.png', NULL, '887633113', '00014');

-- --------------------------------------------------------

--
-- Structure de la table `employees`
--

CREATE TABLE `employees` (
  `employees_id` int(11) NOT NULL,
  `fName` varchar(100) NOT NULL,
  `lName` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `photo_profil_name` varchar(255) NOT NULL DEFAULT 'defaultProfil.png',
  `email` varchar(150) NOT NULL,
  `userPhone` varchar(25) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `gender_id` int(11) NOT NULL,
  `function_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `employees`
--

INSERT INTO `employees` (`employees_id`, `fName`, `lName`, `password`, `token`, `photo_profil_name`, `email`, `userPhone`, `role_id`, `section_id`, `gender_id`, `function_id`) VALUES
(63, 'jul', 'Dugland', '$2y$10$ljA0In3A3hS6kcBXglXjv.qMKbOUigAqqSKRd4XVJ89fZoU9R4KhO', NULL, 'defaultProfil.png', 'jules.gioux212@gmail.com', '0613444444', 2, NULL, 1, 1),
(64, 'julia', 'La bourgeoise', '$2y$10$WCTeunRLrXcOS.OLBKcYuufIOeEtZCNRGZfjh9VFs33rw79A8d9DK', NULL, 'defaultProfil.png', 'julia@gmail.com', '0235353535', 3, 79, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `functions`
--

CREATE TABLE `functions` (
  `function_id` int(11) NOT NULL,
  `function_name` varchar(100) NOT NULL,
  `function_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `functions`
--

INSERT INTO `functions` (`function_id`, `function_name`, `function_description`) VALUES
(1, 'Directeur(trice)', ''),
(2, 'Assistant(e) maternelle', '');

-- --------------------------------------------------------

--
-- Structure de la table `genders`
--

CREATE TABLE `genders` (
  `gender_id` int(11) NOT NULL,
  `gender` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `genders`
--

INSERT INTO `genders` (`gender_id`, `gender`) VALUES
(1, 'Homme'),
(2, 'Femme'),
(3, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `parents_account`
--

CREATE TABLE `parents_account` (
  `parent_id` int(11) NOT NULL,
  `fName` varchar(100) NOT NULL,
  `lName` varchar(100) NOT NULL,
  `userPhone` varchar(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `gender_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `parents_account`
--

INSERT INTO `parents_account` (`parent_id`, `fName`, `lName`, `userPhone`, `password`, `token`, `email`, `gender_id`) VALUES
(38, 'El Kaliedy', 'Bourahound', '0613445632', '$2y$10$sIFgavApLzOJ9oIYRkKvBO2VqQrXg3iJjV5mr62wrNh/pI/64Th1u', NULL, 'amely.hauguel2@mail.fr', 1);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `role_description`) VALUES
(1, 'Admin', 'Administrateur de la plateforme CrecheCalendar'),
(2, 'Modérateur', 'Gère la ou les crèches, permet d\'administrer toutes les informations liées. (crèches, sections, personnels, enfants,plannings etc...)'),
(3, 'Employé', 'Ne permet que de visualiser son propre planning.');

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

CREATE TABLE `sections` (
  `section_id` int(11) NOT NULL,
  `section_Name` varchar(100) NOT NULL,
  `section_description` text NOT NULL DEFAULT 'Description de la section...',
  `section_logo_name` varchar(255) NOT NULL DEFAULT 'defaultSection.png',
  `creche_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sections`
--

INSERT INTO `sections` (`section_id`, `section_Name`, `section_description`, `section_logo_name`, `creche_id`) VALUES
(79, 'test', 'Description de la section...', 'defaultSection.png', 53),
(81, 'fff', 'Description de la section...', 'defaultSection.png', 54);

-- --------------------------------------------------------

--
-- Structure de la table `slot_types`
--

CREATE TABLE `slot_types` (
  `slot_types_id` int(11) NOT NULL,
  `slot_types` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `slot_types`
--

INSERT INTO `slot_types` (`slot_types_id`, `slot_types`) VALUES
(1, 'Confirmé'),
(2, 'Réservé'),
(3, 'Libre');

-- --------------------------------------------------------

--
-- Structure de la table `workincreche`
--

CREATE TABLE `workincreche` (
  `creche_id` int(11) NOT NULL,
  `employees_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `workincreche`
--

INSERT INTO `workincreche` (`creche_id`, `employees_id`) VALUES
(53, 63),
(53, 64),
(54, 63);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `calendar_slots_childs`
--
ALTER TABLE `calendar_slots_childs`
  ADD PRIMARY KEY (`calendarSlots_id`),
  ADD KEY `calendar_slots_childs_childs_FK` (`child_id`),
  ADD KEY `calendar_slots_childs_slot_types0_FK` (`slot_types_id`),
  ADD KEY `calendar_slots_childs_sections1_FK` (`section_id`);

--
-- Index pour la table `calendar_slots_employees`
--
ALTER TABLE `calendar_slots_employees`
  ADD PRIMARY KEY (`calendarSlots_id`),
  ADD KEY `calendar_slots_employees_slot_types_FK` (`slot_types_id`),
  ADD KEY `calendar_slots_employees_sections0_FK` (`section_id`),
  ADD KEY `calendar_slots_employees_employees1_FK` (`employees_id`);

--
-- Index pour la table `childs`
--
ALTER TABLE `childs`
  ADD PRIMARY KEY (`child_id`),
  ADD KEY `childs_parents_account_FK` (`parent_id`),
  ADD KEY `childs_creche1_FK` (`creche_id`),
  ADD KEY `childs_genders2_FK` (`gender_id`),
  ADD KEY `childs_sections0_FK` (`section_id`) USING BTREE;

--
-- Index pour la table `creche`
--
ALTER TABLE `creche`
  ADD PRIMARY KEY (`creche_id`);

--
-- Index pour la table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employees_id`),
  ADD UNIQUE KEY `employees_AK` (`email`),
  ADD KEY `employees_roles_FK` (`role_id`),
  ADD KEY `employees_sections0_FK` (`section_id`),
  ADD KEY `employees_genders1_FK` (`gender_id`),
  ADD KEY `employees_functions2_FK` (`function_id`);

--
-- Index pour la table `functions`
--
ALTER TABLE `functions`
  ADD PRIMARY KEY (`function_id`);

--
-- Index pour la table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`gender_id`);

--
-- Index pour la table `parents_account`
--
ALTER TABLE `parents_account`
  ADD PRIMARY KEY (`parent_id`),
  ADD UNIQUE KEY `parents_account_AK` (`email`),
  ADD KEY `parents_account_genders_FK` (`gender_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Index pour la table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `sections_creche_FK` (`creche_id`);

--
-- Index pour la table `slot_types`
--
ALTER TABLE `slot_types`
  ADD PRIMARY KEY (`slot_types_id`);

--
-- Index pour la table `workincreche`
--
ALTER TABLE `workincreche`
  ADD PRIMARY KEY (`creche_id`,`employees_id`),
  ADD KEY `workincreche_employees0_FK` (`employees_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `calendar_slots_childs`
--
ALTER TABLE `calendar_slots_childs`
  MODIFY `calendarSlots_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `calendar_slots_employees`
--
ALTER TABLE `calendar_slots_employees`
  MODIFY `calendarSlots_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `childs`
--
ALTER TABLE `childs`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `creche`
--
ALTER TABLE `creche`
  MODIFY `creche_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `employees`
--
ALTER TABLE `employees`
  MODIFY `employees_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `functions`
--
ALTER TABLE `functions`
  MODIFY `function_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `genders`
--
ALTER TABLE `genders`
  MODIFY `gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `parents_account`
--
ALTER TABLE `parents_account`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT pour la table `slot_types`
--
ALTER TABLE `slot_types`
  MODIFY `slot_types_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `calendar_slots_childs`
--
ALTER TABLE `calendar_slots_childs`
  ADD CONSTRAINT `calendar_slots_childs_childs_FK` FOREIGN KEY (`child_id`) REFERENCES `childs` (`child_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calendar_slots_childs_sections1_FK` FOREIGN KEY (`section_id`) REFERENCES `sections` (`section_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calendar_slots_childs_slot_types0_FK` FOREIGN KEY (`slot_types_id`) REFERENCES `slot_types` (`slot_types_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `calendar_slots_employees`
--
ALTER TABLE `calendar_slots_employees`
  ADD CONSTRAINT `calendar_slots_employees_employees1_FK` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`employees_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calendar_slots_employees_sections0_FK` FOREIGN KEY (`section_id`) REFERENCES `sections` (`section_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calendar_slots_employees_slot_types_FK` FOREIGN KEY (`slot_types_id`) REFERENCES `slot_types` (`slot_types_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `childs`
--
ALTER TABLE `childs`
  ADD CONSTRAINT `childs_creche1_FK` FOREIGN KEY (`creche_id`) REFERENCES `creche` (`creche_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `childs_genders2_FK` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`gender_id`),
  ADD CONSTRAINT `childs_parents_account_FK` FOREIGN KEY (`parent_id`) REFERENCES `parents_account` (`parent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `childs_sections0_FK` FOREIGN KEY (`section_id`) REFERENCES `sections` (`section_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_functions2_FK` FOREIGN KEY (`function_id`) REFERENCES `functions` (`function_id`),
  ADD CONSTRAINT `employees_genders1_FK` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`gender_id`),
  ADD CONSTRAINT `employees_roles_FK` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `employees_sections0_FK` FOREIGN KEY (`section_id`) REFERENCES `sections` (`section_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `parents_account`
--
ALTER TABLE `parents_account`
  ADD CONSTRAINT `parents_account_genders_FK` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`gender_id`);

--
-- Contraintes pour la table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_creche_FK` FOREIGN KEY (`creche_id`) REFERENCES `creche` (`creche_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `workincreche`
--
ALTER TABLE `workincreche`
  ADD CONSTRAINT `workincreche_creche_FK` FOREIGN KEY (`creche_id`) REFERENCES `creche` (`creche_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workincreche_employees0_FK` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`employees_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

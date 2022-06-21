-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 15, 2022 at 05:22 PM
-- Server version: 10.5.12-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id18568730_covid19`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `user_id` int(11) NOT NULL,
  `no_of_healed` int(11) NOT NULL,
  `no_of_not_healed` int(11) NOT NULL,
  `last_action` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emmergency_cases`
--

CREATE TABLE `emmergency_cases` (
  `ID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type_of_medical_aid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee_of_supplyments`
--

CREATE TABLE `employee_of_supplyments` (
  `ID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `active_id` int(11) NOT NULL,
  `date_of_assign` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `infected_patients`
--

CREATE TABLE `infected_patients` (
  `ID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `infection_date` date NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `infected_patients` ADD `diseases` VARCHAR(150) NOT NULL, 
  `notes` VARCHAR(256) NOT NULL,
  `prob_of_infection` tinyint(4) NOT NULL,
  `active_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `patient_ct_scans`
--

CREATE TABLE `patient_ct_scans` (
  `ID` int(11) NOT NULL,
  `infected_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `num_of_imgs` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `recovered_patients`
--

CREATE TABLE `recovered_patients` (
  `ID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date_of_recovery` date NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `infection_date` date NOT NULL,
  `covid_type` varchar(20) NOT NULL DEFAULT 'COVID19',
  `alive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `ID` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `active_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `treatment` varchar(100) NOT NULL,
  `symptoms` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` date DEFAULT NULL,
  `job` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `governorate` VARCHAR(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_num` char(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `social_status` varchar(20) DEFAULT NULL,
  `ssn` char(14) NOT NULL,
  `no_of_kids` tinyint(4) DEFAULT NULL,
  `coordinates` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `vaccination_type` varchar(20) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_expire` varchar(10) DEFAULT NULL,
  `img` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_emergency_contact`
--

CREATE TABLE `user_emergency_contact` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_num` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `ID` int(11) NOT NULL,
  `role` varchar(20) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`ID`, `role`, `description`) VALUES
(1, 'Supervisor', '1-Control Users \r\n2-Assign emmergency_cases To Paramedic'),
(2, 'Radiologist', '1- Review Results of CT_Scans\r\n2- Enter Patient Data'),
(3, 'Doctor', '1- Decide if Patient is Suspicion Infected (Insert to Infected_Patients)\r\n2- Decide if Patient is Infected '),
(4, 'Patient', '1-See own data \r\n2-Update(emergency contact)\r\n2-Ask For Emergency '),
(5, 'Paramedic', '1-See Patients (employee_of_supplyments)');

-- --------------------------------------------------------

--
-- Table structure for table `voting_for_infection`
--

CREATE TABLE `voting_for_infection` (
  `ID` int(11) NOT NULL,
  `infected_id` int(11) NOT NULL,
  `diagnose` varchar(20) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `emmergency_cases`
--
ALTER TABLE `emmergency_cases`
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `employee_of_supplyments`
--
ALTER TABLE `employee_of_supplyments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `infected_patients`
--
ALTER TABLE `infected_patients`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `patient_ct_scans`
--
ALTER TABLE `patient_ct_scans`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `infected_id` (`infected_id`);

--
-- Indexes for table `recovered_patients`
--
ALTER TABLE `recovered_patients`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_emergency_contact`
--
ALTER TABLE `user_emergency_contact`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `voting_for_infection`
--
ALTER TABLE `voting_for_infection`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `infected_id` (`infected_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_of_supplyments`
--
ALTER TABLE `employee_of_supplyments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `infected_patients`
--
ALTER TABLE `infected_patients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_ct_scans`
--
ALTER TABLE `patient_ct_scans`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recovered_patients`
--
ALTER TABLE `recovered_patients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treatment`
--
ALTER TABLE `treatment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_emergency_contact`
--
ALTER TABLE `user_emergency_contact`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `voting_for_infection`
--
ALTER TABLE `voting_for_infection`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `emmergency_cases`
--
ALTER TABLE `emmergency_cases`
  ADD CONSTRAINT `emmergency_cases_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_of_supplyments`
--
ALTER TABLE `employee_of_supplyments`
  ADD CONSTRAINT `employee_of_supplyments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_of_supplyments_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `infected_patients`
--
ALTER TABLE `infected_patients`
  ADD CONSTRAINT `infected_patients_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `infected_patients_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patient_ct_scans`
--
ALTER TABLE `patient_ct_scans`
  ADD CONSTRAINT `patient_ct_scans_ibfk_1` FOREIGN KEY (`infected_id`) REFERENCES `infected_patients` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recovered_patients`
--
ALTER TABLE `recovered_patients`
  ADD CONSTRAINT `recovered_patients_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recovered_patients_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `treatment`
--
ALTER TABLE `treatment`
  ADD CONSTRAINT `treatment_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `treatment_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user_emergency_contact`
--
ALTER TABLE `user_emergency_contact`
  ADD CONSTRAINT `user_emergency_contact_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `voting_for_infection`
--
ALTER TABLE `voting_for_infection`
  ADD CONSTRAINT `voting_for_infection_ibfk_1` FOREIGN KEY (`infected_id`) REFERENCES `infected_patients` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `voting_for_infection_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

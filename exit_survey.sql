-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:8111
-- Generation Time: Jun 22, 2021 at 01:22 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exit_survey`
--

-- --------------------------------------------------------

--
-- Table structure for table `consent`
--

CREATE TABLE `consent` (
  `id` int(11) NOT NULL,
  `question_id` int(5) NOT NULL,
  `answers` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `consent`
--

INSERT INTO `consent` (`id`, `question_id`, `answers`) VALUES
(6, 36, 'Yes, Email, 09393338944'),
(1, 36, 'Yes, Snail Mail, 09393338944'),
(3, 36, 'No, Email, 09393338944'),
(5, 36, 'No, Email, Nicole Jade Gonzalo');

-- --------------------------------------------------------

--
-- Table structure for table `demographics`
--

CREATE TABLE `demographics` (
  `id` int(11) NOT NULL,
  `up_mail` text NOT NULL,
  `full_name` text DEFAULT NULL,
  `student_num` text DEFAULT NULL,
  `degree_program` text DEFAULT NULL,
  `grad` text NOT NULL,
  `time_out` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `demographics`
--

INSERT INTO `demographics` (`id`, `up_mail`, `full_name`, `student_num`, `degree_program`, `grad`, `time_out`) VALUES
(1, 'aacacayuran@up.edu.ph', 'Alexis A. Cacayuran', '2018-03829', 'BS Mathematics', '2021', 'Fri, 18 Jun 21 00:33:50 +0800'),
(3, 'ebabad2@up.edu.ph', 'Erick Abad', '2018', 'BS Mathematics', '2022', 'Tue, 22 Jun 21 18:27:22 +0800'),
(5, 'ncgonzalo@up.edu.ph', '', '', 'BS Mathematics', '2021', 'Tue, 22 Jun 21 18:37:32 +0800'),
(6, 'rtandaya@up.edu.ph', 'Lorenzo Andaya', '', 'BS Mathematics', '', 'Wed, 09 Jun 21 14:21:13 +0800');

-- --------------------------------------------------------

--
-- Table structure for table `demog_graph`
--

CREATE TABLE `demog_graph` (
  `degree_program` text NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `demog_graph`
--

INSERT INTO `demog_graph` (`degree_program`, `count`) VALUES
('BS Computer Science', 1),
('BS Mathematics', 4);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `up_mail` varchar(30) NOT NULL,
  `type` int(1) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `up_mail`, `type`, `password`) VALUES
(1, 'aacacayuran@up.edu.ph', 0, 'student1'),
(3, 'ebabad2@up.edu.ph', 0, 'student2'),
(4, 'absalinas@up.edu.ph', 0, 'student3'),
(5, 'ncgonzalo@up.edu.ph', 0, 'student4'),
(6, 'rtandaya@up.edu.ph', 0, 'student5'),
(7, 'admin1', 1, 'admin1');

-- --------------------------------------------------------

--
-- Table structure for table `polar`
--

CREATE TABLE `polar` (
  `id` int(11) NOT NULL,
  `question_id` int(5) NOT NULL,
  `answers` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `polar`
--

INSERT INTO `polar` (`id`, `question_id`, `answers`) VALUES
(6, 29, 'No'),
(6, 30, 'No'),
(6, 35, 'Yes'),
(1, 29, 'No'),
(1, 30, 'Yes'),
(1, 35, 'Yes'),
(3, 29, 'No'),
(3, 30, 'Yes'),
(3, 35, 'Yes'),
(5, 29, 'Yes'),
(5, 30, 'No'),
(5, 35, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire`
--

CREATE TABLE `questionnaire` (
  `question_id` int(5) NOT NULL,
  `question` text NOT NULL,
  `classification` text NOT NULL,
  `rateable` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questionnaire`
--

INSERT INTO `questionnaire` (`question_id`, `question`, `classification`, `rateable`) VALUES
(1, 'How useful was the freshmen orientation in providing academic information?', 'Degree Program', 'True'),
(2, 'How will you rate the quality of faculty advising?', 'Degree Program', 'True'),
(3, 'How will you rate the student - faculty interaction in the program?', 'Degree Program', 'True'),
(4, 'How will you rate the assistance/service provided by the admin staff when lodging \r\nrequests (Certifications, clearance, and other documents)?', 'Degree Program', 'True'),
(5, 'How will you rate the GE programs?\r\n', 'Degree Program', 'True'),
(6, 'How useful was the NSTP in your development as a student?', 'Degree Program', 'True'),
(7, 'How will you rate the relevance of the subjects offered in the degree program?', 'Degree Program', 'True'),
(8, 'How will you rate the availability of the subjects you need in the degree program?', 'Degree Program', 'True'),
(9, 'How will you rate the overall quality of your degree program?', 'Degree Program', 'True'),
(10, 'How do you think can the program be improved?', 'Degree Program', 'False'),
(11, 'How would you rate the quality of advising of your thesis adviser?', 'Degree Program', 'False'),
(12, 'How will you rate the quality of lecture rooms?', 'Facilities and Infrastructure', 'True'),
(13, 'How will you rate the quality of the computer laboratories?', 'Facilities and Infrastructure', 'True'),
(14, 'How will you rate the quality of the equipment and instruments used/provided in \r\nthe laboratory course/s?', 'Facilities and Infrastructure', 'True'),
(15, 'What are the areas that need improvement in the computer laboratories? (Check all \r\nthat applies)', 'Facilities and Infrastructure', 'False'),
(16, 'Canteen', 'Facilities and Infrastructure', 'True'),
(17, 'Cash Office', 'Facilities and Infrastructure', 'True'),
(18, 'Health Services Office (HSO)', 'Facilities and Infrastructure', 'True'),
(19, 'Human Kinetics Program \r\n(e.g gym services)', 'Facilities and Infrastructure', 'True'),
(20, 'Learning Resource Center (LRC)', 'Facilities and Infrastructure', 'True'),
(21, 'Office of Counseling and \r\nGuidance (OCG)', 'Facilities and Infrastructure', 'True'),
(22, 'Office of the College Secretary (OCS)', 'Facilities and Infrastructure', 'True'),
(23, 'Office of the Student \r\nand Financial Assistance (OSFA)', 'Facilities and Infrastructure', 'True'),
(24, 'Office of the University Registrar (OUR)', 'Facilities and Infrastructure', 'True'),
(25, 'Security Office (e.g. blue guards)', 'Facilities and Infrastructure', 'True'),
(26, 'Systems and Network Office (SNO)', 'Facilities and Infrastructure', 'True'),
(27, 'University Library', 'Facilities and Infrastructure', 'True'),
(28, 'UP BREHA Dormitory', 'Facilities and Infrastructure', 'True'),
(29, 'Did you ever seek for financial aid (e.g. stipend, loan, other financial assistance) \r\nfrom the university to support your UP education?', 'Financial Aid', 'False'),
(30, 'Did you seek for financial help in attending conferences?', 'Financial Aid', 'False'),
(31, 'Which events did you participate in?', 'Events', 'False'),
(32, 'Which academic organization did you belong to?', 'Events', 'False'),
(33, 'What other (non-academic) organizations did you belong to?', 'Events', 'False'),
(34, 'What are your plans after graduation?', 'Career Plans', 'False'),
(35, 'Did you receive or attend any career counseling conducted within the university?\r\n', 'Career Plans', 'False'),
(36, 'Will you be willing to be contacted for follow-up interview?', 'Consent for a follow-up interview', 'False'),
(37, 'Other Comments and Suggestions', 'Consent for a follow-up interview', 'False');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `question_id` int(5) NOT NULL,
  `rate` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `question_id`, `rate`) VALUES
(6, 1, 1),
(6, 2, 1),
(6, 3, 1),
(6, 4, 1),
(6, 5, 1),
(6, 6, 1),
(6, 7, 4),
(6, 8, 3),
(6, 9, 4),
(6, 12, 1),
(6, 13, 1),
(6, 14, 1),
(6, 16, 4),
(6, 17, 4),
(6, 18, 4),
(6, 19, 4),
(6, 20, 4),
(6, 21, 4),
(6, 22, 4),
(6, 23, 1),
(6, 24, 1),
(6, 25, 1),
(6, 26, 1),
(6, 27, 1),
(6, 28, 1),
(1, 1, 1),
(1, 2, 2),
(1, 3, 1),
(1, 4, 4),
(1, 5, 3),
(1, 6, 4),
(1, 7, 2),
(1, 8, 1),
(1, 9, 2),
(1, 12, 3),
(1, 13, 4),
(1, 14, 3),
(1, 16, 3),
(1, 17, 2),
(1, 18, 3),
(1, 19, 4),
(1, 20, 2),
(1, 21, 3),
(1, 22, 2),
(1, 23, 2),
(1, 24, 3),
(1, 25, 2),
(1, 26, 3),
(1, 27, 2),
(1, 28, 3),
(3, 1, 1),
(3, 2, 1),
(3, 3, 2),
(3, 4, 1),
(3, 5, 2),
(3, 6, 1),
(3, 7, 3),
(3, 8, 2),
(3, 9, 3),
(3, 12, 2),
(3, 13, 3),
(3, 14, 2),
(3, 16, 3),
(3, 17, 2),
(3, 18, 3),
(3, 19, 1),
(3, 20, 0),
(3, 21, 1),
(3, 22, 2),
(3, 23, 2),
(3, 24, 4),
(3, 25, 3),
(3, 26, 4),
(3, 27, 3),
(3, 28, 1),
(5, 1, 1),
(5, 2, 2),
(5, 3, 1),
(5, 4, 2),
(5, 5, 1),
(5, 6, 3),
(5, 7, 2),
(5, 8, 1),
(5, 9, 3),
(5, 12, 1),
(5, 13, 2),
(5, 14, 1),
(5, 16, 3),
(5, 17, 1),
(5, 18, 2),
(5, 19, 1),
(5, 20, 4),
(5, 21, 1),
(5, 22, 2),
(5, 23, 2),
(5, 24, 3),
(5, 25, 4),
(5, 26, 3),
(5, 27, 5),
(5, 28, 4);

-- --------------------------------------------------------

--
-- Table structure for table `rating_graph`
--

CREATE TABLE `rating_graph` (
  `question_id` int(5) NOT NULL,
  `zero` int(5) DEFAULT NULL,
  `one` int(5) NOT NULL,
  `two` int(5) NOT NULL,
  `three` int(5) NOT NULL,
  `four` int(5) NOT NULL,
  `five` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rating_graph`
--

INSERT INTO `rating_graph` (`question_id`, `zero`, `one`, `two`, `three`, `four`, `five`) VALUES
(1, 0, 5, 0, 0, 0, 0),
(2, 0, 2, 3, 0, 0, 0),
(3, 0, 4, 1, 0, 0, 0),
(4, 0, 2, 1, 0, 2, 0),
(5, 0, 2, 1, 2, 0, 0),
(6, 0, 2, 0, 2, 1, 0),
(7, 0, 0, 3, 1, 1, 0),
(8, 0, 3, 1, 1, 0, 0),
(9, 0, 0, 2, 2, 1, 0),
(12, 0, 2, 2, 1, 0, 0),
(13, 0, 1, 1, 2, 1, 0),
(14, 0, 2, 1, 1, 1, 0),
(16, 0, 0, 0, 4, 1, 0),
(17, 0, 1, 2, 1, 1, 0),
(18, 0, 0, 1, 3, 1, 0),
(19, 1, 2, 0, 0, 2, 0),
(20, 1, 1, 1, 0, 2, 0),
(21, 0, 3, 0, 1, 1, 0),
(22, 0, 1, 3, 0, 1, 0),
(23, 0, 2, 3, 0, 0, 0),
(24, 0, 1, 1, 2, 1, 0),
(25, 0, 2, 1, 1, 1, 0),
(26, 0, 1, 1, 2, 1, 0),
(27, 0, 1, 2, 1, 0, 1),
(28, 0, 2, 0, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `suggestion`
--

CREATE TABLE `suggestion` (
  `id` int(11) NOT NULL,
  `question_id` int(5) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suggestion`
--

INSERT INTO `suggestion` (`id`, `question_id`, `comments`) VALUES
(6, 10, ' 10'),
(6, 11, '11'),
(6, 15, 'None'),
(6, 31, 'CS Week, Tagislakas'),
(6, 32, 'ComSci@UP.BAG'),
(6, 33, ' Shadows'),
(6, 34, 'Scientific Research'),
(6, 37, ' Hehe'),
(1, 10, 'No idea.'),
(1, 11, 'Terrific!'),
(1, 15, 'Lighting, Computer'),
(1, 31, 'CS Week'),
(1, 32, 'UP SIKAT'),
(1, 33, 'Shadows'),
(1, 34, 'Graduate School'),
(1, 37, 'None'),
(3, 10, 'None'),
(3, 11, 'None'),
(3, 15, 'Lighting'),
(3, 31, 'CS Week'),
(3, 32, 'Math-Physics Society'),
(3, 33, ''),
(3, 34, 'Scientific Research'),
(3, 37, ' None'),
(5, 10, 'None'),
(5, 11, 'None'),
(5, 15, 'Blackboards'),
(5, 31, 'CS Week'),
(5, 32, 'Math-Physics Society'),
(5, 33, ''),
(5, 34, 'Teaching, NGO, Private Sector'),
(5, 37, ' None');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consent`
--
ALTER TABLE `consent`
  ADD KEY `id` (`id`);

--
-- Indexes for table `demographics`
--
ALTER TABLE `demographics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polar`
--
ALTER TABLE `polar`
  ADD KEY `id` (`id`);

--
-- Indexes for table `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD KEY `id` (`id`);

--
-- Indexes for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `question_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consent`
--
ALTER TABLE `consent`
  ADD CONSTRAINT `consent_ibfk_1` FOREIGN KEY (`id`) REFERENCES `demographics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `demographics`
--
ALTER TABLE `demographics`
  ADD CONSTRAINT `demographics_ibfk_1` FOREIGN KEY (`id`) REFERENCES `login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `polar`
--
ALTER TABLE `polar`
  ADD CONSTRAINT `polar_ibfk_1` FOREIGN KEY (`id`) REFERENCES `demographics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`id`) REFERENCES `demographics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD CONSTRAINT `suggestion_ibfk_1` FOREIGN KEY (`id`) REFERENCES `demographics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

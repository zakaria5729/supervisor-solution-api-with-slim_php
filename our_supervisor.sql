-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2019 at 10:26 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `our_supervisor`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(255) UNSIGNED NOT NULL,
  `group_email` varchar(255) NOT NULL,
  `student_id` int(255) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `group_email`, `student_id`, `name`, `email`, `phone`) VALUES
(71, 'zakaria@gmail.com', 5729, 'zakaria', 'zakaria@gmail.com', '55455545'),
(72, 'zakaria@gmail.com', 4343, 'zakaria2', 'zakaria@gmail2.com', '53232'),
(73, 'zakaria@gmail.com', 5456, 'zakaria3', 'zakaria@gmail.3com', '87989'),
(74, 'zakariaa@gmail.com', 1234, 'zakaria1', 'zakariaa@gmail.com', '101564564'),
(75, 'zakariaa@gmail.com', 5678, 'mmm2', '2mma@gmail.com', '288864564'),
(76, 'zakariaa@gmail.com', 9111, 'sss3', '3sssria@gmail.com', '3999999');

-- --------------------------------------------------------

--
-- Table structure for table `super`
--

CREATE TABLE `super` (
  `id` int(255) UNSIGNED NOT NULL,
  `group_email` varchar(255) NOT NULL,
  `supervisor_email` text NOT NULL,
  `is_accepted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `super`
--

INSERT INTO `super` (`id`, `group_email`, `supervisor_email`, `is_accepted`) VALUES
(14, 'zakaria@gmail.com', 'malek@diu.edu.bd', 1),
(16, 'zakariaa@gmail.com', 'sattar@gmail.com', 1),
(17, 'zakariaa@gmail.com', 'main@gmail.com', 0),
(18, 'zakariaa@gmail.com', 'eses@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE `supervisors` (
  `id` int(255) UNSIGNED NOT NULL,
  `group_supervisor_email` varchar(255) NOT NULL,
  `supervisor_email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supervisors`
--

INSERT INTO `supervisors` (`id`, `group_supervisor_email`, `supervisor_email`) VALUES
(1, 'zakariaa@gmail.com', 'sattar@gmail.com'),
(2, 'zakariaa@gmail.com', 'main@gmail.com'),
(3, 'zakariaa@gmail.com', 'eses@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `supervisor_list`
--

CREATE TABLE `supervisor_list` (
  `id` int(255) UNSIGNED NOT NULL,
  `supervisor_name` text NOT NULL,
  `supervisor_initial` varchar(500) NOT NULL,
  `designation` text NOT NULL,
  `supervisor_image` varchar(500) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(500) NOT NULL,
  `research_area` text NOT NULL,
  `training_experience` text NOT NULL,
  `membership` text NOT NULL,
  `publication_project` text NOT NULL,
  `profile_link` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supervisor_list`
--

INSERT INTO `supervisor_list` (`id`, `supervisor_name`, `supervisor_initial`, `designation`, `supervisor_image`, `phone`, `email`, `research_area`, `training_experience`, `membership`, `publication_project`, `profile_link`) VALUES
(1, 'Prof. Dr. Syed Akhter Hossain', 'SAH', 'Head', 'http://192.168.0.106/supervisor/images/supervisor_images/akhter.jpg', '+8801817382645', 'akterhossain@daffodilvarsity.edu.bd', '1. SIMULATION AND MODELING\r\n2. DISTRIBUTED SYSTEM DESIGN AND IMPLEMENTATION\r\n3. SIGNAL AND IMAGE PROCESSING\r\n4. INTERNET AND WEB ENGINEERING\r\n5. NETWORK PLANNING AND MANAGEMENT\r\n6. DATABASE AND DATA WAREHOUSE MODELING', 'More than 18 years of experience in the field of teaching, research and development with the core competence in computer science and engineering and Informatics.', '1. Member, Association of Computing\r\n2. Machinery (ACM)\r\n3. Member, IEEE\r\n4. Member, Bangladesh Computer Society\r\n5. Member, Bangladesh Electronic Society', '1. Syed Akhter Hossain, M Lutfar Rahman, Farruk Ahmed, \"Computational  Modeling of Bangla Retroflex and Dental Consonants\", WASET Journal of Signal Processing\r\n\r\n2. Syed Akhter Hossain, M Lutfar Rahman, and Farruk Ahmed, \"Acoustic Classification of Bangla Vowels\", International Journal Of Applied Mathematics and Computer Sciences, Volume 4, Number 2, 2007, Spain , ISSN 1305-5313\r\n\r\n3. Syed Akhter Hossain, M Lutfar Rahman, Farruk Ahmed, \"Automatic Segmentation of Bangla Speech: A New Approach\", Asian Journal of Information Technology, Volume 4, Number 12, 2005, Pakistan, pp. 1127-1130\r\n\r\n4. Syed Akhter Hossain, M Lutfar Rahman, Farruk Ahmed, \"Bangla Phoneme Analysis for Computational Approaches\", World Scientific and Engineering Academy and Society (WSEAS) TRANSACTIONS on SIGNAL PROCESSING, Greece, October 2005, pp. 346-354\r\n\r\n5. Syed Akhter Hossain, M Lutfar Rahman, Farruk Ahmed, \"Vowel Space Illustration of Bangla Phonemes\", World Scientific and Engineering Academy and Society (WSEAS) TRANSACTIONS on COMMUNICATIONS, Greece, Issue 12, Volume 4, December 2005, ISSN: 1109-2742 pp. 1435-1442\r\n\r\n6. Syed Akhter Hossain, M Lutfar Rahman, Farruk Ahmed, \"Vowel Space Identification of Bangla Speech\", Dhaka University Journal of Science, 51(1): 31-38 2003(January), 2003\r\n\r\n7. M A Sobhan, M A Aziz and Syed Akhter Hossain, \"Design of a Low cost stereo Amplifier with Five-Band Graphics Equalizer\", Bangladesh Journal of Scientific and Industrial Research, Vol.XXX, No. 1, 1995', 'http://faculty.daffodilvarsity.edu.bd/profile/cse/akhter.html'),
(2, 'Dr. Md. Ismail Jabiullah', 'MIJ', 'Professor', 'http://192.168.0.106/supervisor/images/supervisor_images/Jabiullah.jpg', '01819299960', 'drismail.cse@diu.edu.bd', '1. Network Security, Web Security, Software Security, Internet Security\r\n2. Image Processing, Computer Vision\r\n3. Wireless Network, Cellular Network, Satellite Network\r\n4. Artificial Intelligence and Neural Networks', '1. Successfully participated as Deputy Co-ordinator in the 15th Rover Moot 2000 Bangladesh Scouts, Rover Region Bahadurpur Rover Palli, Gazipur, from February 4-10, 2000.\r\n\r\n2. Completed Intensive Computer Training program on Information Technology sponsored and organized by Teressa Computers, Tokyo, Japan from 01 September 2002 to October 30 2002.\r\n\r\n3. Completed Intensive Training program on Analyst Programmers Course organized and conducted by Informatics Computer Center (ICC), Dhanmondi, Dhaka, Bangladesh, from 7 January 1992 to 31 July 1992.\r\n\r\n4. Successfully participated in the training workshop on \"Basic English\" organized by the Department of English, University of Dhaka, Bangladesh held on December 23, 1993 to March 18, 1994.', '1. Bangladesh Computer Society (BCS).\r\n2. Bangladesh Association of Advancement of Science (BAAS).\r\n3. Dhaka University Registered Graduate Association.\r\n4. Bangladesh Association of Scientist and Scientific Profession (BASSP).\r\n5. Bangladesh Physical Society (BPS).\r\n6. Bangladesh Solar Energy Society (BSES).\r\n7. Bangladesh Electronics Society (BES).\r\n8. Bangladesh Ganit Samity.\r\n9. Board of Governors, Institute of Science and Technology.\r\n10. Bangladesh Solar Energy Society.\r\n11. Bangladesh Electronic Society.\r\n12. ACM-ICPC International Computer Programming Contest, 2007, Asia Regional, Dhaka Site.\r\n13. NCPC National Computer Programming Contest, 2008.\r\n14. Dhaka University Alumni Association.\r\n15. Dhaka University Batch 83 Forum.', '1. Dipta Dev and Dr. Md. Ismail Jabiullah, \"An Online Shopping Store Management System\", Journal of the Bangladesh Electronic Society, Volume 17, Number 1-2, June-December 2017, ISSN: 1816-1510, pp:75-82.\r\n\r\n2. Niloy Saha, Dipongker Sen, Ayesha Siddika Liza and Dr. Md. Ismail Jabiullah, \"A Review on Security Issues for Wireless LAN\", Journal of the Bangladesh Electronic Society, Volume 16, Number 1-2, June-December 2016, ISSN: 1816-1510, pp:75-82.\r\n\r\n3.Md. Abul Hasanat, Shamim Ara and Dr. Md. Ismail Jabiullah, \"Investigation of Security Issues, Risks and Protecting Mechanisms of Bluetooth Network\", Journal of the Bangladesh Electronic Society, Volume 16, Number 1-2, June-December 2016, ISSN: 1816-1510, pp:99-105.\r\n\r\n4. Md. Abu Toub, Afia Khanum, Rabeya Khatun, Siam Assum Passum and Dr. Md. Ismail Jabiullah, \"A Message-based Symmetric-Key Generation and Encryption-Decryption Process for Cryptographic Applications\", Journal of the Bangladesh Electronic Society, Volume 15, Number 1-2, June-December 2015, ISSN: 1816-1510, pp:77-81.\r\n\r\n5. Alamgir Kabir, Mijanur Rahman and M. Ismail Jabiullah, \"Model for Identifying the Security of a System: A Case Study of Point of Sale System (POS)\", International Journal of Engineering Research and Technology, ESRSA Publication 2012, Vol. 2 (05), 2013, ISSN 2278 - 0181, pp: 1-8. http://www.iosr.org\r\n\r\n6. Sydul Islam Khan, Md. Alamgir Kabir, Anisur Rahman, Md. Ismail Jabiullah and M. Lutfar Rahman, \"Strong Message Authentication and Confidentiality Checking through Authentication Code Tied to Ciphertext\", Journal of the Bangladesh Electronic Society, Volume 12, Number 1-2, January-December 2012, ISSN: 1816-1510, pp:1-6.\r\n\r\n7. Md. Monowar Hossain, Sydul Islam Khan, Md. Anisur Rahman, Md. Ismail Jabiullah and M. Lutfar Rahman, \"Improved Block Cipher-based Secured Message Transactions\", Journal of the Bangladesh Electronic Society, Volume 12, Number 1-2, January-December 2012, ISSN: 1816-1510, pp:15-21.\r\n\r\n8. Alamgir Kabir, Sydul Islam Khan and M. Ismail Jabiullah, \"Life Cycle Implementation of an Android Application for Self-Communication with Increasing Efficiency, Storage Space and High Performance\", Green University Review, Publication of Green University of Bangladesh, Volume 3, Number 2, December 2012, ISSN 2218-5283, pp:74-78.\r\n\r\n9. Md. Shohidul Islam, Manzur Ashraf and M. Ismail Jabiullah, \"A Conceptual Framework of Web-table Mining\", IST Journal on Business and Technology, Vol. 3 & 4, Issue Number 1 & 2, December 2011-2012, ISSN: 2070-4135, pp: 210-216.\r\n\r\n10. Anisur Rahman, M. Ismail Jabiullah and M. Lutfar Rahman, \"A higher Level Technique for Secured Message Transactions\", Journal of the Bangladesh Electronic Society, Volume 11, Number 1-2, June-December 2011, ISSN: 1816-1510, pp:1-8.\r\n\r\n11. Shamima Sultana, M. Ismail Jabiullah and M. Lutfar Rahman, \"Improved Needham-Schroder Protocol for Secured and Efficient Key Distribution\", Dhaka University Journal of Applied Science and Engineering, Vol. 1, Issue Number 1, July 2010, ISSN: 2218-7413. PP: 41-44.\r\n\r\n12. M. Ismail Jabiullah, Md. Zakaria Sarker, Md. Anisur Rahman and M. Lutfar Rahman, \"A Secured Message Transaction Approach by Dynamic Hill Cipher Generation and Message Digest Concatenation\", Daffodil International University Journal of Science and Technology, Vol. 5, Issue Number 1, January 2010, ISSN: 1818-5878. PP: 62-66.\r\n\r\n13. M. Ismail Jabiullah, Sydul Islam Khan and M. Lutfar Rahman \"Analysis of Mobile IP Communication Security Issues\", IST Journal on Business and Technology, Vol. 2, Issue Number 2, December 2009, ISSN: 2070-4135, pp: 88-92.\r\n\r\n14. M. Ismail Jabiullah, Sydul Islam Khan and M. Lutfar Rahman \"Comparative Study on Secure Electronic Payment Systems: SSL and SET\", IST Journal on Business and Technology, Vol. 2, Issue Number 2, December 2009, ISSN: 2070-4135, pp127-132.\r\n\r\n15. M. Ismail Jabiullah, A.N.M. Khaleqdad Khan and Mst. Rosy Sharmin, \"Hash-based Secured Pair-wise Session-Key Agreement for Sensor Network\", the Journal of Computer Science, IBAIS University, Vol. 2, Issue Number 1 and 2, December 2008, ISSN: 1994-6244.', 'http://faculty.daffodilvarsity.edu.bd/profile/cse/jabiullah.html');

-- --------------------------------------------------------

--
-- Table structure for table `title_defense`
--

CREATE TABLE `title_defense` (
  `id` int(255) UNSIGNED NOT NULL,
  `group_email` varchar(255) NOT NULL,
  `project_internship` text NOT NULL,
  `project_internship_type` text NOT NULL,
  `project_internship_title` text NOT NULL,
  `area_of_interest` text NOT NULL,
  `group_supervisor_email` varchar(255) NOT NULL,
  `day_evening` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `title_defense`
--

INSERT INTO `title_defense` (`id`, `group_email`, `project_internship`, `project_internship_type`, `project_internship_title`, `area_of_interest`, `group_supervisor_email`, `day_evening`) VALUES
(36, 'zakaria@gmail.com', 'lll', 'fdfd', 'rere', 'f121', 'zakaria@gmail.com', 'day'),
(37, 'zakariaa@gmail.com', 'group3', 'llop', 'llop', 'llop', 'zakariaa@gmail.com', 'Day');

-- --------------------------------------------------------

--
-- Table structure for table `topic_list`
--

CREATE TABLE `topic_list` (
  `id` int(255) UNSIGNED NOT NULL,
  `topic_name` varchar(500) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `supervisor_initial` varchar(500) NOT NULL,
  `description_one` longtext NOT NULL,
  `description_two` longtext NOT NULL,
  `video_path` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topic_list`
--

INSERT INTO `topic_list` (`id`, `topic_name`, `image_path`, `supervisor_initial`, `description_one`, `description_two`, `video_path`) VALUES
(1, 'Machine Learning & Deep Learning', 'http://192.168.0.106/supervisor/images/topic_images/Machine_Learning_and_Deep_Learning.jpg', 'SAH, SRH, MTH, ZH, SR, SL, RR, SBS, NN, AR, AAM, NJ, DMR, SI, FH, MRH,MOT, SNP, AAH, IF, MMM, RS, MR, ANM, SM, MRA, THT, FA, UD, MRK, RUH, MAH, SDB, SAB, MMR-C, FSN, SMAH, MMM, NSA, FI-C, AHN, MRN, EKM, MSS, AKMM, AA-C, MMH, ATP, LR, WRB, MIJ', 'The one primary reason behind why we need AI is to automate tasks that people feel are redundant. Remember computers are far more intelligent in calculation when it comes to multiplying two or more numbers, they can give results in a fraction of seconds whereas humans struggle.\r\n\r\nSimilarly, if you make a computer learn some data or records, based on the records, it can easily predict the future outcome since it would have understood some patterns & structures from the past data or records.', 'Reason behind why we need AI is to automate tasks t', 'WSbgixdC9g8'),
(2, 'Image Processing & Signal Processing', 'http://192.168.0.106/supervisor/images/topic_images/Image_Processing_and_Signal_Processing.jpg', 'MIJ, MTH, NS, MZB, TA, ZZ, ANM, UH, AR, FI, AAM, NJ, SI, IF, MRA, RAH, SZ, RUH, MMR-C, MHK', 'Image processing is a method to convert an image into digital form and perform some operations on it, in order to get an enhanced image or to extract some useful information from it. It is a type of signal dispensation in which input is image, like video frame or photograph and output may be image or characteristics ', 'The two types of methods used for Image Processing are Analog and Digital Image Processing. Analog or visual techniques of image processing can be used for the hard copies like printouts and photographs. Image analysts', 'QMLbTEQJCaI'),
(3, 'Computer Vision', 'http://192.168.100.16:8080/supervisor/images/topic_images/Computer_Vision.jpg', 'ZH, MTH, MZB, SBS, NS, FI, SNP, MRH, NN, AAH, RAH, RUH, SAB, MMR-C, ANM', 'The one primary reason behind why we need AI is to ', 'Image processing is a method to convert an image into digital form and perform some operations on it, in order to get an enhanced image or to extract some useful information from it. It is a type of signal dispensation in which input is image, like video frame or photograph and output may be image or characteristics associated with that image. Usually Image Processing system includes treating images as two dimensional signals while applying already set signal processing methods to them. ', 'eQLcDmfmGB0'),
(4, 'Human Computer Interaction (HCI)', 'http://192.168.100.16:8080/supervisor/images/topic_images/Human_Computer_Interaction.jpg', 'SRH, AAM, MAS, SN, MAH, NN, ATM, AC, UD, MM, MMI, DMMM, FSN, FF, EA, EKM', 'Syed Akhter Hossain, M Lutfar Rahman, Farruk Ahmed, \"Computational  Modeling of Bangla Retroflex and Dental Consonants\", WASET Journal of Signal Processing', '1. Syed Akhter Hossain, M Lutfar Rahman, Farruk Ahmed, \"Computational  Modeling of Bangla Retroflex and Dental Consonants\", WASET Journal of Signal Processing\r\n\r\n2. Syed Akhter Hossain, M Lutfar Rahman, and Farruk Ahmed, \"Acoustic Classification of Bangla Vowels\", International Journal Of Applied Mathematics and Computer Sciences, Volume 4, Number 2, 2007, Spain , ISSN 1305-5313\r\n\r\n3. Syed Akhter Hossain, M Lutfar Rahman, Farruk Ahmed, \"Automatic Segmentation of Bangla Speech: A New Approach\", Asian Journal of Information Technology, Volume 4, Number 12, 2005, Pakistan, pp. 1127-1130\r\n\r\n4. Syed Akhter Hossain, M Lutfar Rahman, Farruk Ahmed, \"Bangla Phoneme Analysis for Computational Approaches\", World Scientific and Engineering Academy and Society (WSEAS) TRANSACTIONS on SIGNAL PROCESSING, Greece, October 2005, pp. 346-354\r\n\r\n5. Syed Akhter Hossain, M Lutfar Rahman, Farruk Ahmed, \"Vowel Space Illustration of Bangla Phonemes\", World Scientific and Engineering Academy and Society (WSEAS) TRANSACTIONS on COMMUNICATIONS, Greece, Issue 12, Volume 4, December 2005, ISSN: 1109-2742 pp. 1435-1442\r\n\r\n6. Syed Akhter Hossain, M Lutfar Rahman, Farruk Ahmed, \"Vowel Space Identification of Bangla Speech\", Dhaka University Journal of Science, 51(1): 31-38 2003(January), 2003\r\n\r\n7. M A Sobhan, M A Aziz and Syed Akhter Hossain, \"Design of a Low cost stereo Amplifier with Five-Band Graphics Equalizer\", Bangladesh Journal of Scientific and Industrial Research, Vol.XXX, No. 1, 1995', 'cGRWKeSJy5s'),
(5, 'Augmented Reality (AR) & Virtual Reality (VR)', 'http://192.168.100.16:8080/supervisor/images/topic_images/Augmented_Reality_and_Virtual_Reality.jpg', 'MAS, AC, FSN, AAM', 'fdfdf', 'fdfdf', 'fdfd'),
(6, 'Artificial Intelligence (AI) & Business Intelligence (BI)', 'http://192.168.100.16:8080/supervisor/images/topic_images/AI_and_Business_Intelligence.jpg', 'SAH, MTH, RR, SBS, ANM, MJA, FA, ZNT, FSN', 'fdfd', 'fdfdf', 'fdfdf'),
(7, 'Natural Language Processing (NLP)', 'http://192.168.100.16:8080/supervisor/images/topic_images/Natural_Language_Processing.jpg', 'SRH, MTH, SR, SBS, UH, MR, SL, RR, SM, SDB, SAB, MMR-C, FSN, ACC, ANM', 'fdfd', 'fdfd', 'fdfdf'),
(8, 'Data Mining', 'http://192.168.100.16:8080/supervisor/images/topic_images/Data_Mining.jpg', 'SRH, MTH, SBS, NSA, ZZ, SRH, MJA, SN, ZNT, NJ, DMR, SI, MMM, SR, MR, SL, HH, RR, SM, MRA, ATM, FA, UD, AAM, ANM, SDB, MAH, SAB, FH, MMR-C, FSN, SMAH, MMM, ACC, NRC, NSA, EKM, MSS, AKMM', 'dfdfd', 'fdfd', 'fdfdf'),
(9, 'Big Data Analysis', 'http://192.168.100.16:8080/supervisor/images/topic_images/Big_Data_Analysis.jpg', 'SBS, SRH, DMR, SZ, MMR-C, FSN, MMM, NSA, FNN, MSS', 'fdfd', 'fdfd', 'fdfd'),
(10, 'Bioinformatics and Computational Biology', 'http://192.168.100.16:8080/supervisor/images/topic_images/Bioinformatics_and_Computational_Biology.jpg', 'NNM, RS', 'dfdf', 'fdfd', 'fdfdf'),
(11, 'Internet of Things (IoT) & Intelligent Systems', 'http://192.168.100.16:8080/supervisor/images/topic_images/Internet_of_Things_and_Intelligent_Systems.jpg', 'SAH, SRH, NNM, FNN, FF, MJA, SN, NR, IF, HH, MMR-C, FSN, ACC, EA', 'fdfd', 'fdfd', 'fdfd'),
(12, 'Embedded Systems & Robotics', 'http://192.168.100.16:8080/supervisor/images/topic_images/Embedded_Systems_and_Robotics.jpg', 'FF, MJA, MMI , FSN, NSA', 'fdf', 'fdfd', 'fdfd'),
(13, 'Social Network Analysis', 'http://192.168.100.16:8080/supervisor/images/topic_images/Social_Network_Analysis.jpg', 'AAM, SRH, SMTS, SN, MMR-C, FSN, NRC, RR, FF', 'dffdfd', 'fdfd', 'fdfd'),
(14, 'System Analysis and Modeling', 'http://192.168.100.16:8080/supervisor/images/topic_images/System_Analysis_and_Modeling.jpg', 'SAH, NSA, SRH', 'fdfd', 'fdf', 'fdfd'),
(15, 'Semantic Web and Cloud Computing', 'http://192.168.100.16:8080/supervisor/images/topic_images/Semantic_Web_and_Cloud_Computing.jpg', 'SRH, ZZ, SR, FNN, STA, HH, SZ, FSN', 'sdsds', 'dsds', 'dsds'),
(16, 'Wireless Networking & Sensor Networks', 'http://192.168.100.16:8080/supervisor/images/topic_images/Wireless_Networking_and_Sensor_Networks.jpg', 'NRC, FNN, GZI, ZH, HH, SMTS, FF', 'fdf', 'fdfd', 'fdfd'),
(17, 'Computer Networking & Information Security', 'http://192.168.100.16:8080/supervisor/images/topic_images/Computer_Networking_and_Information_Security.jpg', 'SAH, FNN, NRC, GZI, HH, SMTS, MRH, RAH, NR, DMMM, BA, ACC , FF, IK, ZZ', 'fdd', 'fdfd', 'fdfd'),
(18, 'Information Retrieval', 'http://192.168.100.16:8080/supervisor/images/topic_images/Information_Retrieval.jpg', 'SRH, Sl, SBS, UH, RR', 'fdd', 'fdfd', 'fdfd'),
(19, 'Pattern Recognition', 'http://192.168.100.16:8080/supervisor/images/topic_images/Pattern_Recognition.jpg', 'MTH, NNM, MZB, IF, AAM, ANM, UH, MAH, RR, DMMM, MMR-C', 'fdfd', 'fdfd', 'fdfd'),
(20, 'Power Systems & Renewable Energy', 'http://192.168.100.16:8080/supervisor/images/topic_images/Power_Systems_and_Renewable_Energy.jpg', 'SD, ACC, MHK', 'fdfd', 'fdfd', 'fdf'),
(21, 'Recommender Systems', 'http://192.168.100.16:8080/supervisor/images/topic_images/Recommender_Systems.jpg', 'SRH, AAM, NN, MTH, MJA, RR', 'fdfd', 'fdfd', 'fdfd'),
(22, 'Biomedical & Medical Imaging', 'http://192.168.100.16:8080/supervisor/images/topic_images/Biomedical_and_Medical_Imaging.jpg', 'SBS, FI, IF, RUH, NS, RAH', 'fdfd', 'fdfd', 'fdfd'),
(23, 'Econometrics', 'http://192.168.100.16:8080/supervisor/images/topic_images/Econometrics.jpg', 'SNP, FH', 'fdfdf', 'fdfd', 'fdfd'),
(24, 'Data Communication/Multimedia Communication/Telecommunication', 'http://192.168.100.16:8080/supervisor/images/topic_images/Data_Communication_Multimedia_Communication_Telecommunication.jpg', 'STA, MHK, NRC, FF, MSS', 'fdf', 'fdfd', 'fdfd'),
(25, 'Graph Theory', 'http://192.168.100.16:8080/supervisor/images/topic_images/Graph_Theory.jpg', 'NNM, FNN', 'fdfdf', 'gfgfgfg', 'fdfd');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_role` text NOT NULL,
  `verification_code` int(7) NOT NULL DEFAULT '0',
  `password_status` int(1) NOT NULL DEFAULT '0',
  `token` varchar(500) NOT NULL,
  `token_status` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_role`, `verification_code`, `password_status`, `token`, `token_status`, `created_at`) VALUES
(29, 'Sattar', 'msattar.cse@diu.edu.bd', '$2y$10$F5kDWKBWJUPiPJFO8NZi4uxlO3RrhKgHX0kUDFrmc0VmTreqGVHKW', 'Supervisor', 944018, 1, '$2y$10$i8Fc0AaMn9/IdTfTXqPAfOYNspMySzhAgCMZsKoIloNSfYLxbk3Ki', 1, '2019-02-21 16:22:33'),
(33, 'Md. Zakaria Hossain', 'zakaria15-5729@diu.edu.bd', '$2y$10$nFaVNWcApD8qfCvhl/kNa.p0ptgJzIEvbGeXY/Luvu/6kf9By1vUC', 'Student', 793855, 1, '$2y$10$KWr4X7xw7sZm1iKvxgEScOFPBebfoCvBqGxgvtwAh.xastp/nEJ7m', 1, '2019-02-21 16:30:35'),
(35, 'Mehedi', 'mehedi15-6103@diu.edu.bd', '$2y$10$DIta7jmBSWmIlTa413JteehmE7vuE9rQSpihTYk9rO2I9v3NCJvUm', 'Student', 717569, 1, '', 0, '2019-03-12 15:06:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `super`
--
ALTER TABLE `super`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supervisor_list`
--
ALTER TABLE `supervisor_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `title_defense`
--
ALTER TABLE `title_defense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topic_list`
--
ALTER TABLE `topic_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `super`
--
ALTER TABLE `super`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supervisor_list`
--
ALTER TABLE `supervisor_list`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `title_defense`
--
ALTER TABLE `title_defense`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `topic_list`
--
ALTER TABLE `topic_list`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

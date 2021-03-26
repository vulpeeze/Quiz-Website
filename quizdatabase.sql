-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2020 at 06:32 PM
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
-- Database: `quizdatabase`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getFailures` ()  NO SQL
BEGIN
	create temporary table idtbl
    (
    quizId INT,
    questionTotal INT
    );
    # Combine all the quizId and get the total questions for each one.
    INSERT INTO idtbl(quizId,questionTotal) SELECT quizId,COUNT(quizId) FROM quizquestions GROUP BY quizId;
    
    #Now to run through the studentAttempts table and compare it to the question total. If they achieved less than 40%, they failed.
    create temporary table quizScoretbl
    (
    quizId INT,
    questionTotal INT,
   	studentId INT,
    score INT
    );
    INSERT INTO quizScoretbl(quizId, questionTotal, studentId, score)
    SELECT idtbl.quizId, idtbl.questionTotal, studentattempts.studentId, studentattempts.score FROM idtbl INNER JOIN studentattempts ON idtbl.quizId=studentattempts.quizId;
    
    create temporary table quizScoreUpdatedtbl
    (
    quizId INT,
    questionTotal INT,
    studentId INT,
    score INT
   	);
    INSERT INTO quizScoreUpdatedtbl(quizId, questionTotal, studentId, score)
    SELECT * FROM quizScoretbl WHERE score/questionTotal < 0.4;
    
    SELECT users.usersName, quizScoreUpdatedtbl.score FROM users INNER JOIN quizScoreUpdatedtbl WHERE users.usersId = quizScoreUpdatedtbl.studentId;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `quizdeletionlog`
--

CREATE TABLE `quizdeletionlog` (
  `staffId` int(11) DEFAULT NULL,
  `quizId` int(11) DEFAULT NULL,
  `time` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizdeletionlog`
--

INSERT INTO `quizdeletionlog` (`staffId`, `quizId`, `time`) VALUES
(NULL, 70, '2020-12-11'),
(6, 71, '2020-12-11'),
(4, 69, '2020-12-11'),
(4, 67, '2020-12-11'),
(NULL, 57, '2020-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `quizmetadata`
--

CREATE TABLE `quizmetadata` (
  `quizId` int(11) NOT NULL,
  `quizName` varchar(255) NOT NULL,
  `quizAuthor` varchar(255) DEFAULT NULL,
  `quizAvailable` bit(1) DEFAULT NULL,
  `quizDuration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizmetadata`
--

INSERT INTO `quizmetadata` (`quizId`, `quizName`, `quizAuthor`, `quizAvailable`, `quizDuration`) VALUES
(34, 'SQL', 'Duncan Hull', b'1', 60),
(56, 'Select the letter', 'Bethany', b'1', 40),
(66, 'Test for updates', 'Duncan Hull', b'0', 76);

--
-- Triggers `quizmetadata`
--
DELIMITER $$
CREATE TRIGGER `updateQuizDeletionLog` BEFORE DELETE ON `quizmetadata` FOR EACH ROW BEGIN
    	DECLARE staffid int;
    	SELECT users.usersId INTO staffid FROM users INNER JOIN quizmetadata WHERE users.usersName = quizmetadata.quizAuthor AND quizmetadata.quizId=OLD.quizId;
    	INSERT INTO quizdeletionlog(staffId, quizId, time)
        VALUES (staffid, OLD.quizId, NOW());
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `quizquestions`
--

CREATE TABLE `quizquestions` (
  `quizId` int(11) NOT NULL,
  `questions` varchar(500) NOT NULL,
  `answer1` text NOT NULL,
  `answer2` text NOT NULL,
  `answer3` text NOT NULL,
  `answer4` text NOT NULL,
  `rightAnswer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizquestions`
--

INSERT INTO `quizquestions` (`quizId`, `questions`, `answer1`, `answer2`, `answer3`, `answer4`, `rightAnswer`) VALUES
(66, '1', '2', '3', '4', '5', 6),
(34, 'Do you like SQL?', 'NO', 'Er....', 'YES!', 'Maybe', 3),
(56, 'Select the letter A', 'A', 'B', 'C', 'D', 1),
(34, 'Which SQL statement is used to extract from a database?', 'SELECT', 'OPEN', 'EXTRACT', 'GET', 1),
(34, 'Which SQL statement is used to insert new data into a database?', 'INSERT NEW', 'INSERT INTO', 'ADD RECORD', 'ADD NEW', 2),
(34, 'With SQL, how do you select all the records from a table named \"Persons\" where the value of the column \"FirstName\" is \"Peter\"?', 'SELECT * FROM Persons WHERE FIRSTNAME <> \"Peter\"', 'SELECT [all] FROM Person WHERE FIRSTNAME = \"Peter\"', 'SELECT * FROM Persons WHERE FIRSTNAME = \"Peter\"', 'SELECT [all] FROM Person WHERE FirstName LIKE \"Peter\"', 3);

-- --------------------------------------------------------

--
-- Table structure for table `studentattempts`
--

CREATE TABLE `studentattempts` (
  `quizId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `dateOfAttempt` date NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studentattempts`
--

INSERT INTO `studentattempts` (`quizId`, `studentId`, `dateOfAttempt`, `score`) VALUES
(34, 1, '2017-06-15', 3),
(34, 2, '2020-06-27', 2),
(34, 3, '0000-00-00', 0),
(34, 4, '2020-12-10', 3),
(34, 6, '2020-12-10', 1),
(56, 4, '2020-12-10', 1),
(56, 6, '2020-12-10', 1),
(56, 7, '2020-12-11', 1),
(66, 4, '2020-12-10', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersId` int(11) NOT NULL,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  `userStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersUid`, `usersPwd`, `userStatus`) VALUES
(1, 'Tamoor Shahid', 'tamoor.shahid@student.manchester.ac.uk', 'Tomahawk', '$2y$10$7xZyCyUp4DtfuUP47VG0kePObxaVgLImfVxpcDjmWBCcGTVrMKJvW', 'student'),
(2, 'Jotaro Kujo', 'StarDolphin@jojo.com', 'StarPlatinum', '$2y$10$G5aPLIaikO.HKEV2E/Uu7.bO3dySJind8MPg4YlI6NeDvOsPJtJ46', 'staff'),
(3, 'Musashi', 'doublesword@fgo.co.jp', 'SaberTwo', '$2y$10$BhkCI3AerlCPf/TL6o9wu.6ls3TcyADnyaFeuQDfhdldv5lKSeL9a', 'student'),
(4, 'Duncan Hull', 'DuncanHull@manchester.ac.uk', 'KittenDestroyer', '$2y$10$Cr8vcYrDJ5y6uawplL8FJOjP7ad41VjkaOTS.Od7I.X8cbdKE/076', 'staff'),
(5, 'Jane', 'jane@jane.jane', 'jane28', '$2y$10$ISR8wG4ctVmyHQZor7FfgeKrVRY0Bo225BcSjYr81S8RNRIHu.zJy', 'staff'),
(6, 'Tamamo', 'tamamo@fgo.co.jp', 'fox', '$2y$10$/scpTQ/TUTrQAHLRDJtmZeRKVBAQ4zGJz7UlPSkjFJbeSJtTITMIm', 'student'),
(7, 'Nero', 'nero@fgo.jp', 'Rome', '$2y$10$Ap84ixNf2yOwuDHKpFFISOn.3R2HlGhDR.CFAdiJrb1VTqc10rWHy', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quizmetadata`
--
ALTER TABLE `quizmetadata`
  ADD PRIMARY KEY (`quizId`),
  ADD UNIQUE KEY `quizId` (`quizId`);

--
-- Indexes for table `quizquestions`
--
ALTER TABLE `quizquestions`
  ADD PRIMARY KEY (`questions`,`quizId`),
  ADD KEY `quizId` (`quizId`);

--
-- Indexes for table `studentattempts`
--
ALTER TABLE `studentattempts`
  ADD PRIMARY KEY (`quizId`,`studentId`),
  ADD KEY `studentId` (`studentId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quizmetadata`
--
ALTER TABLE `quizmetadata`
  MODIFY `quizId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quizquestions`
--
ALTER TABLE `quizquestions`
  ADD CONSTRAINT `quizquestions_ibfk_1` FOREIGN KEY (`quizId`) REFERENCES `quizmetadata` (`quizId`);

--
-- Constraints for table `studentattempts`
--
ALTER TABLE `studentattempts`
  ADD CONSTRAINT `studentattempts_ibfk_1` FOREIGN KEY (`quizId`) REFERENCES `quizmetadata` (`quizId`),
  ADD CONSTRAINT `studentattempts_ibfk_2` FOREIGN KEY (`studentId`) REFERENCES `users` (`usersId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

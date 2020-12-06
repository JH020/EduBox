-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2020 at 07:33 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edubox`
--

-- --------------------------------------------------------

--
-- Table structure for table `eduction`
--

CREATE TABLE `eduction` (
  `EductionID` int(11) NOT NULL,
  `EductionName` varchar(255) NOT NULL,
  `Year` int(11) NOT NULL,
  `SchoolID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eduction`
--

INSERT INTO `eduction` (`EductionID`, `EductionName`, `Year`, `SchoolID`) VALUES
(1, 'Informatica', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `HistoryID` int(11) NOT NULL,
  `VideoID` varchar(8) NOT NULL,
  `UserID` varchar(8) NOT NULL,
  `Offset` time NOT NULL,
  `Seen` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mylist`
--

CREATE TABLE `mylist` (
  `ListItem` int(11) NOT NULL,
  `UserID` varchar(8) NOT NULL,
  `VideoID` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `SchoolID` int(11) NOT NULL,
  `SchoolName` varchar(255) NOT NULL,
  `Extention` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`SchoolID`, `SchoolName`, `Extention`, `created`) VALUES
(1, 'NHL Stenden', 'student.nhlstenden.com', '2020-12-06 04:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `TagID` int(11) NOT NULL,
  `VideoID` varchar(8) NOT NULL,
  `TagData` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` varchar(8) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `StudentID` int(20) NOT NULL,
  `VerificationKey` varchar(255) DEFAULT NULL,
  `Role` varchar(255) NOT NULL,
  `SchoolID` int(11) NOT NULL,
  `Lang` varchar(8) NOT NULL DEFAULT 'dutch',
  `LastLogin` datetime DEFAULT NULL,
  `Created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Password`, `FirstName`, `LastName`, `Email`, `StudentID`, `VerificationKey`, `Role`, `SchoolID`, `Lang`, `LastLogin`, `Created`) VALUES
('abcdefgh', 'feike', 'test', 'Feike', 'Falkena', 'feike@feikefalkena.nl', 123445, NULL, 'docent', 1, 'dutch', NULL, '2020-12-06 05:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_eduction`
--

CREATE TABLE `user_eduction` (
  `UserEductionID` int(11) NOT NULL,
  `UserID` varchar(8) NOT NULL,
  `EductionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_eduction`
--

INSERT INTO `user_eduction` (`UserEductionID`, `UserID`, `EductionID`) VALUES
(1, 'abcdefgh', 1);

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `VideoID` varchar(8) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Attachment` longblob DEFAULT NULL,
  `AttachmentType` varchar(255) DEFAULT NULL,
  `VideoFile` longblob NOT NULL,
  `VideoType` varchar(255) NOT NULL,
  `VideoLength` varchar(20) NOT NULL,
  `Comment` tinyint(1) DEFAULT NULL,
  `Vote` tinyint(1) DEFAULT NULL,
  `Thumbnail` longblob NOT NULL,
  `ThumbnailType` varchar(20) NOT NULL,
  `UserID` varchar(8) NOT NULL,
  `EductionID` int(11) NOT NULL,
  `Created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `VoteID` int(11) NOT NULL,
  `UserID` varchar(8) NOT NULL,
  `VideoID` varchar(8) NOT NULL,
  `Value` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eduction`
--
ALTER TABLE `eduction`
  ADD PRIMARY KEY (`EductionID`),
  ADD KEY `SchoolID` (`SchoolID`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`HistoryID`),
  ADD KEY `VideoID_HISTORY` (`VideoID`),
  ADD KEY `UserID_HISTORY` (`UserID`);

--
-- Indexes for table `mylist`
--
ALTER TABLE `mylist`
  ADD PRIMARY KEY (`ListItem`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `VideoID` (`VideoID`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`SchoolID`),
  ADD UNIQUE KEY `Extention` (`Extention`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`TagID`),
  ADD KEY `VideoID` (`VideoID`),
  ADD KEY `TagData` (`TagData`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `StudentID` (`StudentID`),
  ADD UNIQUE KEY `VerificationKey` (`VerificationKey`),
  ADD KEY `SchoolID_USER` (`SchoolID`);

--
-- Indexes for table `user_eduction`
--
ALTER TABLE `user_eduction`
  ADD PRIMARY KEY (`UserEductionID`),
  ADD KEY `UserID_UC` (`UserID`),
  ADD KEY `Eduction_ID` (`EductionID`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`VideoID`),
  ADD UNIQUE KEY `VideoFile` (`VideoFile`) USING HASH,
  ADD KEY `UserID` (`UserID`),
  ADD KEY `EductionID_VIDEO` (`EductionID`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`VoteID`),
  ADD KEY `UserID_VOTE` (`UserID`),
  ADD KEY `VideoID_VOTE` (`VideoID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eduction`
--
ALTER TABLE `eduction`
  MODIFY `EductionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `HistoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mylist`
--
ALTER TABLE `mylist`
  MODIFY `ListItem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `SchoolID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `TagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user_eduction`
--
ALTER TABLE `user_eduction`
  MODIFY `UserEductionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
  MODIFY `VoteID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eduction`
--
ALTER TABLE `eduction`
  ADD CONSTRAINT `SchoolID_eductation` FOREIGN KEY (`SchoolID`) REFERENCES `school` (`SchoolID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `UserID_HISTORY` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `VideoID_HISTORY` FOREIGN KEY (`VideoID`) REFERENCES `video` (`VideoID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mylist`
--
ALTER TABLE `mylist`
  ADD CONSTRAINT `UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `VideoID` FOREIGN KEY (`VideoID`) REFERENCES `video` (`VideoID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tag`
--
ALTER TABLE `tag`
  ADD CONSTRAINT `VideoID_TAG` FOREIGN KEY (`VideoID`) REFERENCES `video` (`VideoID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `SchoolID_USER` FOREIGN KEY (`SchoolID`) REFERENCES `school` (`SchoolID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_eduction`
--
ALTER TABLE `user_eduction`
  ADD CONSTRAINT `Eduction_ID` FOREIGN KEY (`EductionID`) REFERENCES `eduction` (`EductionID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UserID_UC` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `EductionID_VIDEO` FOREIGN KEY (`EductionID`) REFERENCES `eduction` (`EductionID`),
  ADD CONSTRAINT `UserID_VIDEO` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `UserID_VOTE` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `VideoID_VOTE` FOREIGN KEY (`VideoID`) REFERENCES `video` (`VideoID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

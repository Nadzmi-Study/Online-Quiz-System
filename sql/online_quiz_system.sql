-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2016 at 10:30 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `array_object`
--
CREATE DATABASE IF NOT EXISTS `array_object` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `array_object`;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(3) NOT NULL,
  `userfirstname` varchar(250) NOT NULL,
  `userlastname` varchar(250) NOT NULL,
  `userage` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userfirstname`, `userlastname`, `userage`) VALUES
(11, '1', '1', 1),
(12, '2', '2', 2),
(13, '3', '3', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;--
-- Database: `online_quiz_system`
--
CREATE DATABASE IF NOT EXISTS `online_quiz_system` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `online_quiz_system`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Answer_GetAllTrueAnswerByQuizID` (IN `quizNo` INT)  NO SQL
BEGIN
	SELECT QS.QuesDesc AS "Desc", ANS.AnswerDesc AS "Answer"
    FROM question QS, quiz QZ, answer ANS
    WHERE QS.QuizNo = QZ.QuizNo
    AND ANS.QuestionNo = QS.QuestionNo
    AND ANS.TrueAnswer = 1
    AND QZ.QuizNo = quizNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Answer_GetAnswerByQuestionNo` (IN `questionNo` INT)  NO SQL
BEGIN
	SELECT AnswerNo, AnswerDesc, TrueAnswer
    FROM answer
    WHERE QuestionNo = questionNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Answer_GetAnswerByQuizNo` (IN `quesNo` INT)  NO SQL
BEGIN
	SELECT ANS.AnswerNo, ANS.AnswerDesc, ANS.TrueAnswer
    FROM answer ANS, question QS
    WHERE ANS.QuestionNo = QS.QuestionNo
    AND QS.QuizNo = quesNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Answer_Insert` (IN `questionNo` INT, IN `answerDesc` VARCHAR(1000), IN `trueAnswer` INT, OUT `answerNo` INT)  NO SQL
BEGIN
	INSERT INTO answer
    VALUES (null, questionNo, answerDesc, trueAnswer, CURRENT_DATE, null);
    
     SET answerNo = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LecturerQuiz_GetDetails` (`userNo` INT(11))  BEGIN

 SELECT UD.FullName AS "LECTURER NAME", QZ.Title AS "TITLE", LS.SubjectCode AS "SUBJECT", QZ.TimeConstraint AS "TIME CONSTRAINT", QZ.Active AS "STATUS", QZ.DateCreated AS "DATE CREATED", QZ.QuizNo AS "QUIZ NO"
 FROM userdetails UD, quiz QZ, lecturerquiz LQ, lookupsubject LS 
 WHERE LQ.UserNo = UD.UserDetailNo
 AND LQ.QuizNo = QZ.QuizNo 
 AND QZ.SubjectNo = LS.SubjectNo 
 AND LQ.UserNo = userNo;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LookupSubject_GetAll` ()  BEGIN       
      SELECT SubjectNo, SubjectCode, SubjectDesc
      FROM lookupsubject;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LookupSubject_Insert` (IN `subjectDesc` VARCHAR(100), IN `subjectCode` VARCHAR(10))  NO SQL
BEGIN
	INSERT INTO lookupsubject
    VALUES (null,subjectDesc,subjectCode,CURRENT_DATE );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LookupUserType_GetAll` ()  BEGIN
   SELECT userTypeNo, userTypeDesc 
   FROM lookupusertype;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Question_GetAll` ()  NO SQL
BEGIN
	SELECT *
    FROM question;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Question_GetByQuizNo` (IN `quizNo` INT)  NO SQL
BEGIN
	SELECT QuestionNo, QuesDesc
    FROM question QS, Quiz QZ
    WHERE QZ.QuizNo = QS.QuizNo
    AND QZ.QuizNo = quizNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Question_Insert` (IN `quizNo` INT, IN `questionDesc` VARCHAR(1000), OUT `questionNo` INT)  NO SQL
BEGIN
	INSERT INTO question
    VALUES (null, quizNo, questionDesc, CURRENT_DATE, null);
    
    SET questionNo = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Question_Update` (IN `questionNo` INT, IN `questionDesc` VARCHAR(255))  NO SQL
BEGIN
	UPDATE question
    SET QuesDesc = questionDesc, DateModified = CURRENT_DATE
    WHERE QuestionNo = questionNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_Delete` (IN `quizNo` INT)  NO SQL
BEGIN
	UPDATE quiz
    SET Active = 0, DateModified = CURRENT_DATE
    WHERE QuizNo = quizNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_GetAll` ()  NO SQL
BEGIN
	SELECT qz.Title, sbj.SubjectDesc, qz.TimeConstraint, qz.DateCreated, qz.QuizNo 
    FROM quiz qz, LookupSubject sbj
    WHERE qz.SubjectNo = sbj.SubjectNo
    AND qz.Active = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_GetAllQuizWithAnswer` ()  NO SQL
BEGIN
    SELECT qz.QuizNo AS "Quiz No", qz.Title AS "Title", qs.QuestionNo AS "Question No", qs.QuesDesc AS "Question", a.AnswerDesc AS "Answer", a.TrueAnswer AS "True Answer" 
    FROM quiz qz, question qs, answer a
    WHERE qs.QuizNo = qz.QuizNo AND a.QuestionNo = qs.QuestionNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_GetScore` (IN `userNo` INT, IN `quizNo` INT)  NO SQL
BEGIN
	SELECT SUM(SQA.answerSubmit) AS "Score"
    FROM studentquiz SQ, studentquizanswer SQA
    WHERE SQA.StudentQuizNo = SQ.StudentQuizNo
    AND SQ.UserNo = userNo
    AND SQ.QuizNo = quizNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_Insert` (IN `title` VARCHAR(255), IN `timeconstraint` DOUBLE, IN `subjectno` INT, OUT `quizNo` INT, IN `userNo` INT)  NO SQL
BEGIN
 INSERT INTO quiz
 VALUES (null, title, timeconstraint, subjectno, 1, CURRENT_DATE, null );
 
 SET quizNo = LAST_INSERT_ID();
 
 INSERT INTO lecturerquiz
 VALUES(null, userNo, quizNo, CURRENT_DATE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_Update` (IN `quizNo` INT, IN `title` VARCHAR(100), IN `timeConstraint` DOUBLE, IN `subjectNo` INT)  NO SQL
BEGIN
	UPDATE quiz
    SET Title = title, TimeConstraint = timeConstraint, SubjectNo = subjectNo, DateModified = CURRENT_DATE
    WHERE QuizNo = quizNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Student_SubmitAnswer` (IN `studentQuizNo` INT, IN `answer` INT, OUT `qansNo` INT)  NO SQL
BEGIN
	INSERT INTO studentquizanswer
    VALUES(null,studentQuizNo, answer, CURRENT_DATE);
    
    SET qansNo:= LAST_INSERT_ID();    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Student_SubmitQuiz` (IN `userNo` INT, IN `quizNo` INT, OUT `submitQuizNo` INT)  NO SQL
BEGIN
	INSERT INTO studentquiz
    VALUES(NULL, userNo, quizNo, CURRENT_DATE);
    
    SET submitQuizNo = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_DeleteAccount` (IN `id` INT)  NO SQL
BEGIN
 UPDATE user
 SET Active = 0, DateModified = CURRENT_DATE
 WHERE UserDetailNo = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_GetAll` ()  NO SQL
BEGIN
 SELECT usr.Username AS "Username",usr.Password AS "Password",ud.FullName AS "FullName", ud.IC AS "IC", ud.Email AS "Email", ud.ContactNo AS "Contact", ut.UserTypeDesc AS "UserType", ud.DateCreated AS "CreatedDate", ud.DateModified AS "ModifiedDate"
 FROM user usr, userdetails ud, lookupusertype ut
 WHERE ud.UserDetailNo = usr.UserDetailNo
 AND ud.UserTypeNo = ut.UserTypeNo
 AND usr.Active = 1
 ORDER BY ud.UserTypeNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_GetByID` (IN `id` INT)  NO SQL
BEGIN
 SELECT usr.UserNo As "UserNo",usr.Username AS "Username",usr.Password AS "Password",ud.FullName AS "FullName", ud.IC AS "IC", ud.Email AS "Email", ud.ContactNo AS "Contact", ut.UserTypeDesc AS "UserType", ud.DateCreated AS "CreatedDate", ud.DateModified AS "ModifiedDate"
 FROM user usr, userdetails ud, lookupusertype ut
 WHERE ud.UserDetailNo = usr.UserDetailNo
 AND ud.UserTypeNo = ut.UserTypeNo
 AND usr.Active = 1 
 AND ud.UserDetailNo = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_GetByUsernamePassword` (IN `in_username` VARCHAR(100), IN `in_password` VARCHAR(100))  NO SQL
BEGIN
	SELECT UserNo
    FROM user
    WHERE Username = in_username
    AND Password = in_password;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_Insert` (IN `fullname` VARCHAR(255), IN `ic` VARCHAR(14), IN `email` VARCHAR(255), IN `userType` INT, IN `contactNo` VARCHAR(14), IN `username` VARCHAR(255), IN `userpassword` VARCHAR(255), OUT `userNo` INT)  BEGIN       
      INSERT INTO userdetails 
      VALUES (null,fullname,ic,email,userType,contactNo,CURRENT_DATE,null);
      
      SELECT @No := LAST_INSERT_ID();
      
      INSERT INTO user 
      VALUES(null, username, userpassword, @No, active, CURRENT_DATE, null);
      
      SET userNo = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_UpdateAccount` (IN `id` INT, IN `username` VARCHAR(100), IN `password` VARCHAR(50))  NO SQL
BEGIN
	UPDATE user
    Set Username = username, Password = password, DateModified = CURRENT_DATE
    WHERE UserNo = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_UpdateDetails` (IN `id` INT, IN `email` VARCHAR(100), IN `contactNo` VARCHAR(14))  NO SQL
BEGIN
 UPDATE userdetails
 SET Email = email, ContactNo = contactno, DateModified = CURRENT_DATE
 WHERE UserDetailNo = id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `AnswerNo` int(11) NOT NULL,
  `QuestionNo` int(11) NOT NULL,
  `AnswerDesc` text NOT NULL,
  `TrueAnswer` tinyint(1) NOT NULL,
  `DateCreated` date NOT NULL,
  `DateModified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`AnswerNo`, `QuestionNo`, `AnswerDesc`, `TrueAnswer`, `DateCreated`, `DateModified`) VALUES
(69, 34, 'dummy answer 1a', 0, '2016-12-02', NULL),
(70, 34, 'dummy answer 1b', 1, '2016-12-02', NULL),
(71, 34, 'dummy answer 1c', 0, '2016-12-02', NULL),
(72, 34, 'dummy answer 1d', 0, '2016-12-02', NULL),
(73, 35, 'dummy question 2a', 0, '2016-12-02', NULL),
(74, 35, 'dummy question 2b', 0, '2016-12-02', NULL),
(75, 35, 'dummy question 2c', 1, '2016-12-02', NULL),
(76, 35, 'dummy question 2d', 0, '2016-12-02', NULL),
(77, 36, 'dummy question 3a', 1, '2016-12-02', NULL),
(78, 36, 'dummy question 3b', 0, '2016-12-02', NULL),
(79, 36, 'dummy question 3c', 0, '2016-12-02', NULL),
(80, 36, 'dummy question 3d', 0, '2016-12-02', NULL),
(81, 37, 'dummy question 4a', 0, '2016-12-02', NULL),
(82, 37, 'dummy question 4b', 0, '2016-12-02', NULL),
(83, 37, 'dummy question 4c', 1, '2016-12-02', NULL),
(84, 37, 'dummy question 4d', 0, '2016-12-02', NULL),
(85, 38, 'dummy question 5a', 0, '2016-12-02', NULL),
(86, 38, 'dummy question 5b', 1, '2016-12-02', NULL),
(87, 38, 'dummy question 5c', 0, '2016-12-02', NULL),
(88, 38, 'dummy question 5d', 0, '2016-12-02', NULL),
(89, 39, 'dummy question 6a', 0, '2016-12-02', NULL),
(90, 39, 'dummy question 6b', 0, '2016-12-02', NULL),
(91, 39, 'dummy question 6c', 1, '2016-12-02', NULL),
(92, 39, 'dummy question 6d', 0, '2016-12-02', NULL),
(93, 40, 'dummy question 7a', 0, '2016-12-02', NULL),
(94, 40, 'dummy question 7b', 0, '2016-12-02', NULL),
(95, 40, 'dummy question 7c', 0, '2016-12-02', NULL),
(96, 40, 'dummy question 7d', 1, '2016-12-02', NULL),
(97, 41, 'dummy question 8a', 0, '2016-12-02', NULL),
(98, 41, 'dummy question 8b', 0, '2016-12-02', NULL),
(99, 41, 'dummy question 8c', 0, '2016-12-02', NULL),
(100, 41, 'dummy question 8d', 1, '2016-12-02', NULL),
(101, 42, 'dummy question 9a', 0, '2016-12-02', NULL),
(102, 42, 'dummy question 9b', 1, '2016-12-02', NULL),
(103, 42, 'dummy question 9c', 0, '2016-12-02', NULL),
(104, 42, 'dummy question 9d', 0, '2016-12-02', NULL),
(105, 43, 'dummy question 10a', 1, '2016-12-02', NULL),
(106, 43, 'dummy question 10b', 0, '2016-12-02', NULL),
(107, 43, 'dummy question 10c', 0, '2016-12-02', NULL),
(108, 43, 'dummy question 10d', 0, '2016-12-02', NULL),
(109, 44, 'Q1A', 1, '2016-12-09', NULL),
(110, 44, 'Q1B', 0, '2016-12-09', NULL),
(111, 44, 'Q1C', 0, '2016-12-09', NULL),
(112, 44, 'Q1D', 0, '2016-12-09', NULL),
(113, 45, 'Q2A', 0, '2016-12-09', NULL),
(114, 45, 'Q2B', 1, '2016-12-09', NULL),
(115, 45, 'Q2C', 0, '2016-12-09', NULL),
(116, 45, 'Q2D', 0, '2016-12-09', NULL),
(117, 46, 'Q3A', 0, '2016-12-09', NULL),
(118, 46, 'Q3B', 0, '2016-12-09', NULL),
(119, 46, 'Q3C', 0, '2016-12-09', NULL),
(120, 46, 'Q3D', 1, '2016-12-09', NULL),
(121, 47, 'Q4A', 0, '2016-12-09', NULL),
(122, 47, 'Q4B', 1, '2016-12-09', NULL),
(123, 47, 'Q4C', 0, '2016-12-09', NULL),
(124, 47, 'Q4D', 0, '2016-12-09', NULL),
(125, 48, 'Q5A', 0, '2016-12-09', NULL),
(126, 48, 'Q5B', 0, '2016-12-09', NULL),
(127, 48, 'Q5C', 0, '2016-12-09', NULL),
(128, 48, 'Q5D', 1, '2016-12-09', NULL),
(129, 49, 'Q6A', 1, '2016-12-09', NULL),
(130, 49, 'Q6B', 0, '2016-12-09', NULL),
(131, 49, 'Q6C', 0, '2016-12-09', NULL),
(132, 49, 'Q6D', 0, '2016-12-09', NULL),
(133, 50, 'Q7A', 0, '2016-12-09', NULL),
(134, 50, 'Q7B', 1, '2016-12-09', NULL),
(135, 50, 'Q7C', 0, '2016-12-09', NULL),
(136, 50, 'Q7D', 0, '2016-12-09', NULL),
(137, 51, 'Q8A', 0, '2016-12-09', NULL),
(138, 51, 'Q8B', 0, '2016-12-09', NULL),
(139, 51, 'Q8C', 1, '2016-12-09', NULL),
(140, 51, 'Q8D', 0, '2016-12-09', NULL),
(141, 52, 'Q9A', 0, '2016-12-09', NULL),
(142, 52, 'Q9B', 1, '2016-12-09', NULL),
(143, 52, 'Q9C', 0, '2016-12-09', NULL),
(144, 52, 'Q9D', 0, '2016-12-09', NULL),
(145, 53, 'Q10A', 1, '2016-12-09', NULL),
(146, 53, 'Q10B', 0, '2016-12-09', NULL),
(147, 53, 'Q10C', 0, '2016-12-09', NULL),
(148, 53, 'Q10D', 0, '2016-12-09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lecturerquiz`
--

CREATE TABLE `lecturerquiz` (
  `LecturerQuizNo` int(11) NOT NULL,
  `QuizNo` int(11) NOT NULL,
  `UserNo` int(11) NOT NULL,
  `CreatedDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lecturerquiz`
--

INSERT INTO `lecturerquiz` (`LecturerQuizNo`, `QuizNo`, `UserNo`, `CreatedDate`) VALUES
(1, 5, 10, NULL),
(2, 6, 10, NULL),
(3, 10, 10, '2016-12-14'),
(38, 10, 51, '2016-12-14'),
(39, 10, 52, '2016-12-14'),
(40, 10, 53, '2016-12-14'),
(41, 10, 54, '2016-12-14'),
(42, 10, 55, '2016-12-14'),
(43, 10, 56, '2016-12-14'),
(44, 10, 57, '2016-12-14'),
(45, 10, 58, '2016-12-14');

-- --------------------------------------------------------

--
-- Table structure for table `lookupsubject`
--

CREATE TABLE `lookupsubject` (
  `SubjectNo` int(11) NOT NULL,
  `SubjectCode` varchar(7) NOT NULL,
  `SubjectDesc` varchar(255) NOT NULL,
  `DateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lookupsubject`
--

INSERT INTO `lookupsubject` (`SubjectNo`, `SubjectCode`, `SubjectDesc`, `DateCreated`) VALUES
(1, 'CSC569', 'Compiler', '2016-11-15'),
(2, 'CSC480', 'Parallel', '2016-11-15'),
(3, 'CSC438', 'Data Structure', '2016-11-15');

-- --------------------------------------------------------

--
-- Table structure for table `lookupusertype`
--

CREATE TABLE `lookupusertype` (
  `UserTypeNo` int(4) NOT NULL,
  `UserTypeDesc` varchar(255) NOT NULL,
  `DateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lookupusertype`
--

INSERT INTO `lookupusertype` (`UserTypeNo`, `UserTypeDesc`, `DateCreated`) VALUES
(1, 'Lecturer', '2016-11-14'),
(2, 'Student', '2016-11-14');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `QuestionNo` int(11) NOT NULL,
  `QuizNo` int(11) NOT NULL,
  `QuesDesc` varchar(255) NOT NULL,
  `DateCreated` date NOT NULL,
  `DateModified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`QuestionNo`, `QuizNo`, `QuesDesc`, `DateCreated`, `DateModified`) VALUES
(34, 5, 'dummy question 1', '2016-12-02', NULL),
(35, 5, 'dummy question 2', '2016-12-02', NULL),
(36, 5, 'dummy question 3', '2016-12-02', NULL),
(37, 5, 'dummy question 4', '2016-12-02', NULL),
(38, 5, 'dummy question 5', '2016-12-02', NULL),
(39, 5, 'dummy question 6', '2016-12-02', NULL),
(40, 5, 'dummy question 7', '2016-12-02', NULL),
(41, 5, 'dummy question 8', '2016-12-02', NULL),
(42, 5, 'dummy question 9', '2016-12-02', NULL),
(43, 5, 'dummy question 10', '2016-12-02', NULL),
(44, 6, 'Q1', '2016-12-09', NULL),
(45, 6, 'Q2', '2016-12-09', NULL),
(46, 6, 'Q3', '2016-12-09', NULL),
(47, 6, 'Q4', '2016-12-09', NULL),
(48, 6, 'Q5', '2016-12-09', NULL),
(49, 6, 'Q6', '2016-12-09', NULL),
(50, 6, 'Q7', '2016-12-09', NULL),
(51, 6, 'Q8', '2016-12-09', NULL),
(52, 6, 'Q9', '2016-12-09', NULL),
(53, 6, 'Q10', '2016-12-09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `QuizNo` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `TimeConstraint` double NOT NULL,
  `SubjectNo` int(4) NOT NULL,
  `Active` int(11) NOT NULL DEFAULT '1',
  `DateCreated` date NOT NULL,
  `DateModified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`QuizNo`, `Title`, `TimeConstraint`, `SubjectNo`, `Active`, `DateCreated`, `DateModified`) VALUES
(5, 'dummy quiz 1', 60, 1, 1, '2016-12-02', NULL),
(6, 'dummy quiz 2', 45, 1, 1, '2016-12-09', NULL),
(10, 'test quiz 4', 60, 1, 1, '2016-12-14', NULL),
(51, '', 0, 0, 1, '2016-12-14', NULL),
(52, '', 0, 0, 1, '2016-12-14', NULL),
(53, '', 0, 0, 1, '2016-12-14', NULL),
(54, '', 0, 0, 1, '2016-12-14', NULL),
(55, '', 0, 0, 1, '2016-12-14', NULL),
(56, 'test quiz 6', 120, 2, 1, '2016-12-14', NULL),
(57, 'test quiz 7', 60, 1, 1, '2016-12-14', NULL),
(58, 'test quiz 8', 60, 3, 1, '2016-12-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studentquiz`
--

CREATE TABLE `studentquiz` (
  `StudentQuizNo` int(11) NOT NULL,
  `UserNo` int(11) NOT NULL,
  `QuizNo` int(11) NOT NULL,
  `DateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentquiz`
--

INSERT INTO `studentquiz` (`StudentQuizNo`, `UserNo`, `QuizNo`, `DateCreated`) VALUES
(7, 11, 5, '2016-12-11'),
(8, 11, 5, '2016-12-14'),
(9, 11, 5, '2016-12-14');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserNo` int(4) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserDetailNo` int(4) NOT NULL,
  `Active` int(1) NOT NULL DEFAULT '1',
  `DateCreated` date NOT NULL,
  `DateModified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserNo`, `Username`, `Password`, `UserDetailNo`, `Active`, `DateCreated`, `DateModified`) VALUES
(10, 'lecturer', 'test', 10, 1, '2016-12-02', NULL),
(11, 'student', 'test', 11, 1, '2016-12-02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE `userdetails` (
  `UserDetailNo` int(4) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `IC` varchar(14) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `UserTypeNo` int(1) NOT NULL,
  `ContactNo` varchar(14) NOT NULL,
  `DateCreated` date NOT NULL,
  `DateModified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`UserDetailNo`, `FullName`, `IC`, `Email`, `UserTypeNo`, `ContactNo`, `DateCreated`, `DateModified`) VALUES
(10, 'test lecturer', '000000112222', 'testLecturer@email.com', 1, '0001112222', '2016-12-02', NULL),
(11, 'test student', '000000112222', 'testStudent@email.com', 2, '0001112222', '2016-12-02', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`AnswerNo`,`QuestionNo`);

--
-- Indexes for table `lecturerquiz`
--
ALTER TABLE `lecturerquiz`
  ADD PRIMARY KEY (`LecturerQuizNo`);

--
-- Indexes for table `lookupsubject`
--
ALTER TABLE `lookupsubject`
  ADD PRIMARY KEY (`SubjectNo`);

--
-- Indexes for table `lookupusertype`
--
ALTER TABLE `lookupusertype`
  ADD PRIMARY KEY (`UserTypeNo`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`QuestionNo`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`QuizNo`);

--
-- Indexes for table `studentquiz`
--
ALTER TABLE `studentquiz`
  ADD PRIMARY KEY (`StudentQuizNo`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserNo`);

--
-- Indexes for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`UserDetailNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `AnswerNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;
--
-- AUTO_INCREMENT for table `lecturerquiz`
--
ALTER TABLE `lecturerquiz`
  MODIFY `LecturerQuizNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `lookupsubject`
--
ALTER TABLE `lookupsubject`
  MODIFY `SubjectNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `lookupusertype`
--
ALTER TABLE `lookupusertype`
  MODIFY `UserTypeNo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `QuestionNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `QuizNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `studentquiz`
--
ALTER TABLE `studentquiz`
  MODIFY `StudentQuizNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserNo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `UserDetailNo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(11) NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `settings_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `template_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{"db":"online_quiz_system","table":"quiz"},{"db":"online_quiz_system","table":"lecturerquiz"},{"db":"online_quiz_system","table":"user"},{"db":"online_quiz_system","table":"userdetails"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT '0',
  `x` float UNSIGNED NOT NULL DEFAULT '0',
  `y` float UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin,
  `data_sql` longtext COLLATE utf8_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2016-11-18 02:47:35', '{"collation_connection":"utf8mb4_unicode_ci"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

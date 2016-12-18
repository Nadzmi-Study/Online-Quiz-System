-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2016 at 11:10 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_quiz_system`
--

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Answer_GetAnswerByQuestionNo` (`questNo` INT(11))  BEGIN
	SELECT AnswerNo, AnswerDesc, TrueAnswer
    FROM answer
    WHERE QuestionNo = questNo;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Answer_Update` (`ansNo` INT(11), `ansDesc` VARCHAR(100), `trueAns` INT(2))  BEGIN
    UPDATE answer
      SET AnswerDesc = ansDesc, TrueAnswer = trueAns
      WHERE AnswerNo = ansNo;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LecturerQuiz_GetDetails` (`userNo` INT(11))  BEGIN

  SELECT UD.FullName AS "LECTURER NAME", QZ.Title AS "TITLE", LS.SubjectCode AS "SUBJECT", QZ.TimeConstraint AS "TIME CONSTRAINT", QZ.Active AS "STATUS", QZ.DateCreated AS "DATE CREATED", QZ.QuizNo AS "QUIZ NO"
  FROM userdetails UD, quiz QZ, lecturerquiz LQ, lookupsubject LS
  WHERE LQ.UserNo = UD.UserDetailNo
    AND LQ.QuizNo = QZ.QuizNo
    AND QZ.SubjectNo = LS.SubjectNo
    AND LQ.UserNo = userNo
    AND QZ.Active = 1;

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Question_Update` (`questNo` INT(11), `questionDesc` VARCHAR(255))  BEGIN
	UPDATE question
    SET QuesDesc = questionDesc, DateModified = CURRENT_DATE
    WHERE QuestionNo = questNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_Delete` (`quizID` INT(11))  BEGIN
    UPDATE quiz
      SET Active = 0, DateModified = CURRENT_DATE
      WHERE QuizNo LIKE quizID;
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
 VALUES(null, quizNo, userNo, CURRENT_DATE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_Update` (`qNo` INT(11), `qTitle` VARCHAR(100), `qTime` DOUBLE, `qSubjectNo` INT(11))  BEGIN
	UPDATE quiz
    SET Title = qTitle, TimeConstraint = qTime, SubjectNo = qSubjectNo, DateModified = CURRENT_DATE
    WHERE QuizNo = qNo;
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
(69, 34, 'bla bla', 1, '2016-12-02', NULL),
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
(148, 53, 'Q10D', 0, '2016-12-09', NULL),
(271, 88, 'q1a', 1, '2016-12-14', NULL),
(272, 88, 'q1b', 0, '2016-12-14', NULL),
(273, 88, 'q1c', 0, '2016-12-14', NULL),
(274, 88, 'q1d', 0, '2016-12-14', NULL),
(275, 89, 'q2a', 0, '2016-12-14', NULL),
(276, 89, 'q2b', 0, '2016-12-14', NULL),
(277, 89, 'q2c', 1, '2016-12-14', NULL),
(278, 89, 'q2d', 0, '2016-12-14', NULL),
(279, 90, 'qa3', 0, '2016-12-14', NULL),
(280, 90, 'q3b', 0, '2016-12-14', NULL),
(281, 90, 'q3c', 0, '2016-12-14', NULL),
(282, 90, 'q3d', 1, '2016-12-14', NULL),
(283, 91, 'q4a', 0, '2016-12-14', NULL),
(284, 91, 'q4b', 0, '2016-12-14', NULL),
(285, 91, 'q4c', 0, '2016-12-14', NULL),
(286, 91, 'q4d', 1, '2016-12-14', NULL),
(287, 92, 'q5a', 0, '2016-12-14', NULL),
(288, 92, 'q5b', 0, '2016-12-14', NULL),
(289, 92, 'q5c', 1, '2016-12-14', NULL),
(290, 92, 'q5d', 0, '2016-12-14', NULL),
(291, 93, 'q6a', 0, '2016-12-14', NULL),
(292, 93, 'q6b', 1, '2016-12-14', NULL),
(293, 93, 'q6c', 0, '2016-12-14', NULL),
(294, 93, 'q6d', 0, '2016-12-14', NULL),
(295, 94, 'q7a', 1, '2016-12-14', NULL),
(296, 94, 'q7b', 0, '2016-12-14', NULL),
(297, 94, 'q7c', 0, '2016-12-14', NULL),
(298, 94, 'q7d', 0, '2016-12-14', NULL),
(299, 95, 'q8a', 0, '2016-12-14', NULL),
(300, 95, 'q8b', 0, '2016-12-14', NULL),
(301, 95, 'q8c', 1, '2016-12-14', NULL),
(302, 95, 'q8d', 0, '2016-12-14', NULL),
(303, 96, 'q9a', 0, '2016-12-14', NULL),
(304, 96, 'q9b', 0, '2016-12-14', NULL),
(305, 96, 'q9c', 1, '2016-12-14', NULL),
(306, 96, 'q9d', 0, '2016-12-14', NULL),
(307, 97, 'q10a', 0, '2016-12-14', NULL),
(308, 97, 'q10b', 1, '2016-12-14', NULL),
(309, 97, 'q10c', 0, '2016-12-14', NULL),
(310, 97, 'q10d', 0, '2016-12-14', NULL),
(391, 118, 'q1a', 1, '2016-12-18', NULL),
(392, 118, 'q1b', 0, '2016-12-18', NULL),
(393, 118, 'q1c', 0, '2016-12-18', NULL),
(394, 118, 'q1d', 0, '2016-12-18', NULL),
(395, 119, 'qa2', 0, '2016-12-18', NULL),
(396, 119, 'q2b', 0, '2016-12-18', NULL),
(397, 119, 'q2c', 1, '2016-12-18', NULL),
(398, 119, 'qd2', 0, '2016-12-18', NULL),
(399, 120, 'q3a', 0, '2016-12-18', NULL),
(400, 120, 'q3b', 1, '2016-12-18', NULL),
(401, 120, 'q3c', 0, '2016-12-18', NULL),
(402, 120, 'q3d', 0, '2016-12-18', NULL),
(403, 121, 'q4a', 1, '2016-12-18', NULL),
(404, 121, 'q4b', 0, '2016-12-18', NULL),
(405, 121, 'q4c', 0, '2016-12-18', NULL),
(406, 121, 'q4d', 0, '2016-12-18', NULL),
(407, 122, 'q5a', 0, '2016-12-18', NULL),
(408, 122, 'q5b', 0, '2016-12-18', NULL),
(409, 122, 'q5c', 0, '2016-12-18', NULL),
(410, 122, 'q5d', 1, '2016-12-18', NULL),
(411, 123, 'q6a', 0, '2016-12-18', NULL),
(412, 123, 'qb6', 0, '2016-12-18', NULL),
(413, 123, 'q6c', 1, '2016-12-18', NULL),
(414, 123, 'q6d', 0, '2016-12-18', NULL),
(415, 124, 'q7a', 0, '2016-12-18', NULL),
(416, 124, 'q7b', 0, '2016-12-18', NULL),
(417, 124, 'q7c', 0, '2016-12-18', NULL),
(418, 124, 'q7d', 1, '2016-12-18', NULL),
(419, 125, 'q8a', 0, '2016-12-18', NULL),
(420, 125, 'q8b', 0, '2016-12-18', NULL),
(421, 125, 'q8c', 1, '2016-12-18', NULL),
(422, 125, 'q8d', 0, '2016-12-18', NULL),
(423, 126, 'q9a', 0, '2016-12-18', NULL),
(424, 126, 'q9b', 1, '2016-12-18', NULL),
(425, 126, 'q9c', 0, '2016-12-18', NULL),
(426, 126, 'q9d', 0, '2016-12-18', NULL),
(427, 127, 'q10a', 1, '2016-12-18', NULL),
(428, 127, 'q10b', 0, '2016-12-18', NULL),
(429, 127, 'q10c', 0, '2016-12-18', NULL),
(430, 127, 'q10d', 0, '2016-12-18', NULL);

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
(49, 62, 10, '2016-12-14'),
(50, 63, 10, '2016-12-17'),
(51, 64, 10, '2016-12-17'),
(52, 65, 10, '2016-12-18'),
(53, 66, 10, '2016-12-18'),
(54, 67, 10, '2016-12-18'),
(55, 68, 10, '2016-12-18');

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
(34, 5, 'dummy quest', '2016-12-02', '2016-12-18'),
(35, 5, 'Test quest', '2016-12-02', '2016-12-18'),
(36, 5, 'Test quest', '2016-12-02', '2016-12-18'),
(37, 5, 'Test quest', '2016-12-02', '2016-12-18'),
(38, 5, 'Test quest', '2016-12-02', '2016-12-18'),
(39, 5, 'Test quest', '2016-12-02', '2016-12-18'),
(40, 5, 'Test quest', '2016-12-02', '2016-12-18'),
(41, 5, 'Test quest', '2016-12-02', '2016-12-18'),
(42, 5, 'Test quest', '2016-12-02', '2016-12-18'),
(43, 5, 'Test quest', '2016-12-02', '2016-12-18'),
(44, 6, 'Test quest', '2016-12-09', '2016-12-18'),
(45, 6, 'Test quest', '2016-12-09', '2016-12-18'),
(46, 6, 'Test quest', '2016-12-09', '2016-12-18'),
(47, 6, 'Test quest', '2016-12-09', '2016-12-18'),
(48, 6, 'Test quest', '2016-12-09', '2016-12-18'),
(49, 6, 'Test quest', '2016-12-09', '2016-12-18'),
(50, 6, 'Test quest', '2016-12-09', '2016-12-18'),
(51, 6, 'Test quest', '2016-12-09', '2016-12-18'),
(52, 6, 'Test quest', '2016-12-09', '2016-12-18'),
(53, 6, 'Test quest', '2016-12-09', '2016-12-18'),
(88, 62, 'Test quest', '2016-12-14', '2016-12-18'),
(89, 62, 'Test quest', '2016-12-14', '2016-12-18'),
(90, 62, 'Test quest', '2016-12-14', '2016-12-18'),
(91, 62, 'Test quest', '2016-12-14', '2016-12-18'),
(92, 62, 'Test quest', '2016-12-14', '2016-12-18'),
(93, 62, 'Test quest', '2016-12-14', '2016-12-18'),
(94, 62, 'Test quest', '2016-12-14', '2016-12-18'),
(95, 62, 'Test quest', '2016-12-14', '2016-12-18'),
(96, 62, 'Test quest', '2016-12-14', '2016-12-18'),
(97, 62, 'Test quest', '2016-12-14', '2016-12-18');

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
(5, 'qwer', 60, 3, 1, '2016-12-02', '2016-12-18'),
(6, 'test', 60, 2, 1, '2016-12-09', '2016-12-18'),
(62, 'testing', 60, 3, 1, '2016-12-14', '2016-12-18');

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
(9, 11, 5, '2016-12-14'),
(10, 11, 6, '2016-12-18'),
(11, 11, 6, '2016-12-18');

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
  MODIFY `AnswerNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=551;
--
-- AUTO_INCREMENT for table `lecturerquiz`
--
ALTER TABLE `lecturerquiz`
  MODIFY `LecturerQuizNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
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
  MODIFY `QuestionNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;
--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `QuizNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `studentquiz`
--
ALTER TABLE `studentquiz`
  MODIFY `StudentQuizNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserNo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `UserDetailNo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

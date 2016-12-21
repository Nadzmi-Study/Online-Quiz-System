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

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LecturerQuiz_GetDetails` (IN `userNo` INT(11))  BEGIN

 SELECT UD.FullName AS "LECTURER NAME", QZ.Title AS "TITLE", LS.SubjectCode AS "SUBJECT", QZ.TimeConstraint AS "TIME CONSTRAINT", QZ.Active AS "STATUS", QZ.DateCreated AS "DATE CREATED", QZ.QuizNo AS "QUIZ NO"
 FROM userdetails UD, quiz QZ, lecturerquiz LQ, lookupsubject LS 
 WHERE LQ.UserNo = UD.UserDetailNo
 AND LQ.QuizNo = QZ.QuizNo 
 AND QZ.SubjectNo = LS.SubjectNo
 AND QZ.Active = 1
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_Update` (IN `quizNo` INT, IN `title` VARCHAR(100), IN `timeConstraint` DOUBLE, IN `subjectNo` INT)  NO SQL
BEGIN
	UPDATE quiz
    SET Title = title, TimeConstraint = timeConstraint, SubjectNo = subjectNo, DateModified = CURRENT_DATE
    WHERE QuizNo = quizNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Student_QuizAnsweredList` (IN `userNo` INT)  NO SQL
BEGIN
 SELECT QZ.QuizNo AS "QuizNo", QZ.Title AS "Title", LS.SubjectDesc AS "SubjectDesc", SQ.DateCreated AS "DateAnswered"
 FROM studentquiz SQ, quiz QZ, lookupsubject LS
 WHERE SQ.QuizNo = QZ.QuizNo
 AND QZ.SubjectNo = LS.SubjectNo
 AND SQ.UserNo = userNo;
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
(311, 98, 'Laser-light projection system', 0, '2016-12-21', NULL),
(312, 98, 'Dot-matrix printer', 0, '2016-12-21', NULL),
(313, 98, 'Random-scan monitors', 1, '2016-12-21', NULL),
(314, 98, 'Pen-based plotter', 0, '2016-12-21', NULL),
(315, 99, '2', 0, '2016-12-21', NULL),
(316, 99, '3', 1, '2016-12-21', NULL),
(317, 99, '4', 0, '2016-12-21', NULL),
(318, 99, '5', 0, '2016-12-21', NULL),
(319, 100, 'Rotation', 1, '2016-12-21', NULL),
(320, 100, 'Translation', 0, '2016-12-21', NULL),
(321, 100, 'Shearing', 0, '2016-12-21', NULL),
(322, 100, 'Scaling', 0, '2016-12-21', NULL),
(323, 101, '25 bytes', 0, '2016-12-21', NULL),
(324, 101, '50 bytes', 0, '2016-12-21', NULL),
(325, 101, '100 bytes', 1, '2016-12-21', NULL),
(326, 101, '200 bytes', 0, '2016-12-21', NULL),
(327, 102, 'A polygon with all internal angles smaller than 180 degrees', 0, '2016-12-21', NULL),
(328, 102, 'A polygon that has more than three vertices and those vertices do not lie in the same place', 0, '2016-12-21', NULL),
(329, 102, 'A polygon that has duplicate vertices or less than three vertices', 0, '2016-12-21', NULL),
(330, 102, 'A polygon with every line segment between two vertices of the polygon does not go exterior to the polygon', 1, '2016-12-21', NULL),
(331, 103, 'Simple to implement. ', 0, '2016-12-21', NULL),
(332, 103, 'Available in hardware', 0, '2016-12-21', NULL),
(333, 103, 'Can be applied to all objects in the model.', 0, '2016-12-21', NULL),
(334, 104, ' Add variations of black to spectral color. ', 0, '2016-12-21', NULL),
(335, 104, 'Add variations of white to spectral color', 1, '2016-12-21', NULL),
(336, 104, 'Add variations of black and white to spectral color', 0, '2016-12-21', NULL),
(337, 104, 'Add another spectral color to the existing spectral color', 0, '2016-12-21', NULL),
(338, 105, ' Keyframe animation ', 1, '2016-12-21', NULL),
(339, 105, 'Double buffering ', 0, '2016-12-21', NULL),
(340, 105, 'Motion capture ', 0, '2016-12-21', NULL),
(341, 105, 'Procedural animation', 0, '2016-12-21', NULL),
(342, 106, 'First ', 0, '2016-12-21', NULL),
(343, 106, 'Second ', 1, '2016-12-21', NULL),
(344, 106, ' First and second ', 0, '2016-12-21', NULL),
(345, 106, ' None of the vertex', 0, '2016-12-21', NULL),
(346, 107, 'Pixel E ', 0, '2016-12-21', NULL),
(347, 107, 'Pixel SE ', 0, '2016-12-21', NULL),
(348, 107, 'Pixel P', 0, '2016-12-21', NULL),
(349, 107, 'None of the above', 1, '2016-12-21', NULL),
(350, 108, 'A1', 0, '2016-12-21', NULL),
(351, 108, 'B1', 1, '2016-12-21', NULL),
(352, 108, 'C1', 0, '2016-12-21', NULL),
(353, 108, 'D1', 0, '2016-12-21', NULL),
(354, 109, 'A2', 0, '2016-12-21', NULL),
(355, 109, 'B2', 0, '2016-12-21', NULL),
(356, 109, 'C2', 1, '2016-12-21', NULL),
(357, 109, 'D2', 0, '2016-12-21', NULL),
(358, 110, 'A3', 1, '2016-12-21', NULL),
(359, 110, 'B3', 0, '2016-12-21', NULL),
(360, 110, 'C3', 0, '2016-12-21', NULL),
(361, 110, 'D3', 0, '2016-12-21', NULL),
(362, 111, 'A4', 0, '2016-12-21', NULL),
(363, 111, 'B4', 0, '2016-12-21', NULL),
(364, 111, 'C4', 0, '2016-12-21', NULL),
(365, 111, 'D4', 1, '2016-12-21', NULL),
(366, 112, 'A5', 0, '2016-12-21', NULL),
(367, 112, 'B5', 1, '2016-12-21', NULL),
(368, 112, 'C5', 0, '2016-12-21', NULL),
(369, 112, 'D5', 0, '2016-12-21', NULL),
(370, 113, 'A6', 0, '2016-12-21', NULL),
(371, 113, 'B6', 0, '2016-12-21', NULL),
(372, 113, 'C6', 1, '2016-12-21', NULL),
(373, 113, 'D6', 0, '2016-12-21', NULL),
(374, 114, 'A7', 1, '2016-12-21', NULL),
(375, 114, 'B7', 0, '2016-12-21', NULL),
(376, 114, 'C7', 0, '2016-12-21', NULL),
(377, 114, 'D7', 0, '2016-12-21', NULL),
(378, 115, 'A8', 0, '2016-12-21', NULL),
(379, 115, 'B8', 0, '2016-12-21', NULL),
(380, 115, 'C8', 0, '2016-12-21', NULL),
(381, 115, 'D8', 1, '2016-12-21', NULL),
(382, 116, 'A9', 0, '2016-12-21', NULL),
(383, 116, 'B9', 0, '2016-12-21', NULL),
(384, 116, 'C9', 1, '2016-12-21', NULL),
(385, 116, 'D9', 0, '2016-12-21', NULL),
(386, 117, 'A10', 0, '2016-12-21', NULL),
(387, 117, 'B10', 1, '2016-12-21', NULL),
(388, 117, 'C10', 0, '2016-12-21', NULL),
(389, 117, 'D10', 0, '2016-12-21', NULL);

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
(1, 'CSC569', 'Principles of Compilers', '2016-11-15'),
(2, 'CSC580', 'Parallel Processing', '2016-11-15'),
(3, 'CSC438', 'Fundamental of Data Structure', '2016-11-15'),
(4, 'CSC658', 'Computer Graphics', '2016-12-21'),
(5, 'ELC550', 'English for Academic Writting', '2016-12-21'),
(6, 'CSC658', 'Computer Graphics', '2016-12-21');

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
(98, 63, 'Which of the following is NOT an example of vector graphic device?', '2016-12-21', NULL),
(99, 63, 'If a color image uses 16 different color values, what is the minimum bit depth required for each pixel?', '2016-12-21', NULL),
(100, 63, 'Which of the following is a rigid-body transformation that moves an object without deformation?', '2016-12-21', NULL),
(101, 63, 'What is the size of a frame buffer (in bytes) needed for a monitor that needs 2 bits per pixel and with a resolution of 10 x 20?', '2016-12-21', NULL),
(102, 63, 'Which of the following statement best describes degenerative polygon?', '2016-12-21', NULL),
(103, 63, 'Which of the following is NOT an advantage of Z-buffer rendering method?', '2016-12-21', NULL),
(104, 63, '. How are color tones produced when using the HSV model?', '2016-12-21', NULL),
(105, 63, ' If an animation is produced using a set or equations or rules, what type of animation is this called?', '2016-12-21', NULL),
(106, 63, '. If both vertices of a polygon are inside the clip window, which vertex is kept in the vertex list of the Sutherland-Hodgman polygon clipping algorithm?', '2016-12-21', NULL),
(107, 63, 'In a situation shown in Figure 2, which pixel will be plotted next? ', '2016-12-21', NULL),
(108, 64, 'Q1', '2016-12-21', NULL),
(109, 64, 'Q2', '2016-12-21', NULL),
(110, 64, 'Q3', '2016-12-21', NULL),
(111, 64, 'Q4', '2016-12-21', NULL),
(112, 64, 'Q5', '2016-12-21', NULL),
(113, 64, 'Q6', '2016-12-21', NULL),
(114, 64, 'Q7', '2016-12-21', NULL),
(115, 64, 'Q8', '2016-12-21', NULL),
(116, 64, 'Q9', '2016-12-21', NULL),
(117, 64, 'Q10', '2016-12-21', NULL);

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
(63, 'Sample Quiz 1 ', 0, 4, 0, '2016-12-21', '2016-12-21'),
(64, 'Sample Quiz 2', 0, 1, 1, '2016-12-21', NULL);

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
(14, 13, 64, '2016-12-21');

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
(13, 'alifzulkafli', 'alif', 13, 1, '2016-12-21', NULL),
(14, 'aina', 'aina', 14, 1, '2016-12-21', NULL);

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
(13, 'Muhammad Alif Bin Zulkafli', '940105105037', 'alifzulkafli94@gmail.com', 2, '0172470107', '2016-12-21', NULL),
(14, 'Aina Afifah Bt Norizan', '954020105044', 'aina@email.com', 1, '0198876754', '2016-12-21', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`AnswerNo`,`QuestionNo`);

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
  MODIFY `AnswerNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=390;
--
-- AUTO_INCREMENT for table `lookupsubject`
--
ALTER TABLE `lookupsubject`
  MODIFY `SubjectNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `lookupusertype`
--
ALTER TABLE `lookupusertype`
  MODIFY `UserTypeNo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `QuestionNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;
--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `QuizNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `studentquiz`
--
ALTER TABLE `studentquiz`
  MODIFY `StudentQuizNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserNo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `UserDetailNo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

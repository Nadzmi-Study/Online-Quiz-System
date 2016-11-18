--
-- Database: `online_quiz_system`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Answer_GetAnswerByQuestionNo` (IN `questionNo` INT)  NO SQL
BEGIN
	SELECT AnswerNo, AnswerDesc, TrueAnswer
    FROM answer
    WHERE QuestionNo = questionNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Answer_Insert` (IN `questionNo` INT, IN `answerDesc` TEXT, IN `trueAnswer` INT)  NO SQL
BEGIN
	INSERT INTO answer
    VALUES (null, questionNo, answerDesc, trueAnswer, CURRENT_DATE, null);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LookupSubject_GetAll` ()  BEGIN       
      SELECT * 
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
    FROM question
    WHERE QuizNo = quizNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Question_Insert` (IN `quizNo` TEXT, IN `questionDesc` INT, OUT `questionNo` INT)  NO SQL
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
	SELECT * 
    FROM quiz;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_GetAllQuizWithAnswer` ()  NO SQL
BEGIN
    SELECT qz.QuizNo AS "Quiz No", qz.Title AS "Title", qs.QuestionNo AS "Question No", qs.QuesDesc AS "Question", a.AnswerDesc AS "Answer", a.TrueAnswer AS "True Answer" 
    FROM quiz qz, question qs, answer a
    WHERE qs.QuizNo = qz.QuizNo AND a.QuestionNo = qs.QuestionNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_Insert` (IN `title` VARCHAR(255), IN `timeconstraint` DOUBLE, IN `subjectno` INT, OUT `quizNo` INT)  NO SQL
BEGIN
 INSERT INTO quiz
 VALUES (null, title, timeconstraint, subjectno, 1, CURRENT_DATE, null );
 
 SET quizNo = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Quiz_Update` (IN `quizNo` INT, IN `title` VARCHAR(100), IN `timeConstraint` DOUBLE, IN `subjectNo` INT)  NO SQL
BEGIN
	UPDATE quiz
    SET Title = title, TimeConstraint = timeConstraint, SubjectNo = subjectNo, DateModified = CURRENT_DATE
    WHERE QuizNo = quizNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_DeleteAccount` (IN `id` INT)  NO SQL
BEGIN
 UPDATE user
 SET Active = 0, DateModified = CURRENT_DATE
 WHERE UserDetailNo = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_GetAll` ()  NO SQL
BEGIN
 SELECT usr.Username AS "Name",usr.Password AS "Password",ud.FullName AS "FullName", ud.IC AS "IC", ud.Email AS "Email", ud.ContactNo AS "Contact", ut.UserTypeDesc AS "UserType", ud.DateCreated AS "CreatedDate", ud.DateModified AS "ModifiedDate"
 FROM user usr, userdetails ud, lookupusertype ut
 WHERE ud.UserDetailNo = usr.UserDetailNo
 AND ud.UserTypeNo = ut.UserTypeNo
 AND usr.Active = 1
 ORDER BY ud.UserTypeNo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_GetByID` (IN `id` INT)  NO SQL
BEGIN
 SELECT usr.Username AS "Name",usr.Password AS "Password",ud.FullName AS "FullName", ud.IC AS "IC", ud.Email AS "Email", ud.ContactNo AS "Contact", ut.UserTypeDesc AS "UserType", ud.DateCreated AS "CreatedDate", ud.DateModified AS "ModifiedDate"
 FROM user usr, userdetails ud, lookupusertype ut
 WHERE ud.UserDetailNo = usr.UserDetailNo
 AND ud.UserTypeNo = ut.UserTypeNo
 AND usr.Active = 1 
 AND ud.UserDetailNo = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_User_Insert` (IN `fullname` VARCHAR(255), IN `ic` VARCHAR(14), IN `email` VARCHAR(255), IN `userType` INT(1), IN `contactNo` VARCHAR(14), IN `username` VARCHAR(255), IN `userpassword` VARCHAR(255), OUT `userNo` INT)  BEGIN       
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
(1, 1, 'Alif', 1, '2016-11-16', NULL),
(2, 1, 'Lifa', 0, '2016-11-16', NULL),
(3, 1, 'Kulup', 0, '2016-11-16', NULL),
(4, 1, 'Meon', 0, '2016-11-16', NULL);

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
(1, 1, 'Nama saya ialah..', '2016-11-16', '2016-11-17');

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
(1, 'Ujian 1', 45, 2, 1, '2016-11-16', '2016-11-17');

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
(7, 'alif', 'pass', 7, 1, '2016-11-16', '2016-11-16'),
(8, 'test', 'pass', 8, 1, '2016-11-17', '2016-11-17'),
(9, 'DibaAisyah', 'Pass', 9, 1, '2016-11-17', '2016-11-17');

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
(7, 'Alif Zulkafli', '940105105037', 'alifzulkafli94@gmail.com', 2, '0112223333', '2016-11-16', '2016-11-16'),
(8, 'Tester Name', '000', 'test', 1, '091', '2016-11-17', NULL),
(9, 'Adibah Aisyah', '000000112222', 'Diba@email.com', 2, '1112223333', '2016-11-17', '2016-11-17');

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
  MODIFY `AnswerNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
  MODIFY `QuestionNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `QuizNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `studentquiz`
--
ALTER TABLE `studentquiz`
  MODIFY `StudentQuizNo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserNo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `UserDetailNo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

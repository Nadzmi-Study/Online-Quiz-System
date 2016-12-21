<?php
/**
 * Class QuizManager
 */
class QuizManager {
    private $QC; // quiz controller

    public function __construct(QuizController $QC=null) {
        $this->QC = $QC;
    }

    //
    public function registerQuiz(Quiz $newQuiz) {
        $tempSubjects = $this->QC->retrieveSubjectList();
        for($x=0 ; $x<sizeof($tempSubjects) ; $x++)
            if($tempSubjects[$x]["SubjectDesc"] == $newQuiz->getSubject()) {
                $newQuiz->setSubject($tempSubjects["SubjectNo"]);
                break;
            }

        $tempUser = unserialize($_SESSION["user"]);
        $insertResult = $this->QC->insertQuiz($newQuiz, $tempUser->getUserNo());

        return $insertResult;
    }

    public function updateQuiz(Quiz $updatedQuiz) {
        $tempSubjects = $this->QC->retrieveSubjectList();
        for($x=0 ; $x<sizeof($tempSubjects) ; $x++)
            if($tempSubjects[$x]["SubjectDesc"] == $updatedQuiz->getSubject()) {
                $updatedQuiz->setSubject((int) $tempSubjects[$x]["SubjectNo"]);
                break;
            }

        $tempQuestion = $updatedQuiz->getQuestion();
        for($a=0 ; $a<sizeof($tempQuestion) ; $a++) {
            $tempAns = $tempQuestion[$a]->getAnswer();

            for($x=0 ; $x<sizeof($tempAns) ; $x++)
                if($tempAns[$x]->getTrueAnswer() == null)
                    $tempAns[$x]->setTrueAnswer(0);
                else if($tempAns[$x]->getTrueAnswer())
                    $tempAns[$x]->setTrueAnswer(1);
                else
                    $tempAns[$x]->setTrueAnswer(0);
        }

        return $this->QC->updateQuiz($updatedQuiz);
    }

    public function getQuizList($userId=null) {
        $quizObjects = null;
        if(!isset($userId)) {
            $tempQuizList = $this->QC->retrieveQuiz();

            $quizObjects = array();
            for($x = 0 ; $x<sizeof($tempQuizList) ; $x++)
                array_push($quizObjects,
                    new Quiz(
                        $tempQuizList[$x]["QuizTitle"],
                        $tempQuizList[$x]["Subject"],
                        $tempQuizList[$x]["DateCreated"],
                        $tempQuizList[$x]["QuizNo"]));
        } else {
            $tempQuizList = $this->QC->retrieveQuiz($userId);

            $quizObjects = array();
            for($x = 0 ; $x<sizeof($tempQuizList) ; $x++)
                array_push($quizObjects,
                    new Quiz(
                        $tempQuizList[$x]["QuizTitle"],
                        $tempQuizList[$x]["Subject"],
                        $tempQuizList[$x]["DateCreated"],
                        $tempQuizList[$x]["QuizNo"]));
        }

        return $quizObjects;
    }

    public function getQuestionList($quizId) {
        $tempQuestionList = $this->QC->retrieveQuestion($quizId);

        $questionObject = array();
        for($x=0 ; $x<sizeof($tempQuestionList) ; $x++) {
            $tempAnswerList = $this->QC->retrieveAnswer($tempQuestionList[$x]["QuestionNo"]);

            $answerObject = array();
            for($a = 0 ; $a<sizeof($tempAnswerList) ; $a++)
                array_push($answerObject,
                    new Answer(
                        $tempAnswerList[$a]["AnswerNo"],
                        $tempAnswerList[$a]["AnswerDesc"],
                        $tempAnswerList[$a]["TrueAnswer"]));

            array_push($questionObject,
                new Question(
                    $tempQuestionList[$x]["QuestionDesc"],
                    $answerObject,
                    $tempQuestionList[$x]["QuestionNo"]));
        }

        return $questionObject;
    }

    public function getDeleteConfirmation($quizID) {
        $delete = $this->QC->deleteQuiz($quizID);

        if($delete)
            return true;
        else
            return false;
    }
    //

    public function createQuiz(Quiz $quiz, $userNo) {
        $newQuizData = array(
            "Title" => $quiz->getTitle(),
            "TimeConstraint" => $quiz->getTime(),
            "SubjectNo" => $quiz->getSubject(),
            "UserNo" => $userNo
        );

        $result = $this->QC->registerQuiz($newQuizData);
        if(isset($result))
            return $result;
        else
            return null;
    }

    public function createQuestion(Question $question,$quizID) {
        $newQuestionData = array(
            "QuestionDesc" => $question->getDescription(),
            "QuizID" => $quizID
        );

        $result =  $this->QC->registerQuestion($newQuestionData);
        if(isset($result))
            return $result;
        else
            return null;
    }

    public function createAnswer(Answer $answer, $questionID)
    {
        $newAnswerData = array(
            "AnswerDesc" => $answer->getDescription(),
            "TrueAnswer" => $answer->getTrueAnswer(),
            "QuestionID" => $questionID
        );

        $result = $this->QC->registerAnswer($newAnswerData);

        return $result;
    }

    public function getQuestionByQuizId($quizNo)
    {
        $tempQuestionList = $this->QC->getQuestionByQuizId($quizNo);
        $questionList = array();
        for($i=0; $i<sizeof($tempQuestionList); $i++){
            array_push($questionList, new Question($tempQuestionList[$i]["QuestionDesc"],"", $tempQuestionList[$i]["QuestionNo"]  ));
        }

        return $questionList;
    }

    public function getAnswerByQuestionId($questionNo)
    {
        $tempAnswerList = $this->QC->retrieveAnswer($questionNo);
        $answerList = array();
        for($j=0; $j<sizeof($tempAnswerList); $j++)
        {
            array_push($answerList, new Answer($tempAnswerList[$j]["AnswerNo"], $tempAnswerList[$j]["AnswerDesc"], $tempAnswerList[$j]["TrueAnswer"]));
        }

        return $answerList;
    }

    public function getAnswerByQuizId($quizID)
    {
        $tempAnswerList = $this->QC->getAnswerByQuizId($quizID);
        $answerList = array();
        for($j=0; $j<sizeof($tempAnswerList); $j++)
        {
            array_push($answerList, new Answer($tempAnswerList[$j]["AnswerNo"], $tempAnswerList[$j]["AnswerDesc"], $tempAnswerList[$j]["TrueAnswer"]));
        }

        return $answerList;
    }

    public function getSubjectList() {
        $tempSubjectList = $this->QC->retrieveSubjectList();

        $subjectList = array();
        for($x = 0 ; $x<sizeof($tempSubjectList) ; $x++) {
            array_push($subjectList, new Subject($tempSubjectList[$x]["SubjectCode"], $tempSubjectList[$x]["SubjectDesc"], $tempSubjectList[$x]["SubjectNo"]));
        }

        return $subjectList;
    }

    public function getResultAnswerById($quizId)
    {
        $tempResultList = $this->QC->getTrueAnswer($quizId);
        $resultList = array();
        for($i=0; $i<sizeof($tempResultList); $i++)
        {
            $resultList[$i] = array(
                "Desc" => $tempResultList[$i]["Desc"],
                "Answer" => $tempResultList[$i]["Answer"]
            );
        }
        return $resultList;
    }

    public function submitAnswer($studentQuizNo, $answer)
    {
        $tempAnswerStatus = $this->QC->submitAnswer($studentQuizNo, $answer);
        return $tempAnswerStatus;
    }

    public function submitQuiz($userId, $quizNo)
    {
        $tempQuizStatus = $this->QC->submitQuiz($userId,$quizNo);
        return $tempQuizStatus;
    }

    public function getQuizAnsweredList($userId)
    {
        $tempList = $this->QC->getQuizAnsweredList($userId);
        $quizList = array();
        for($i=0; $i<sizeof($tempList); $i++)
        {
            array_push($quizList, new Quiz($tempList[$i]["Title"], $tempList[$i]["SubjectDesc"], null, $tempList[$i]["DateAnswered"], $tempList[$i]["QuizNo"], "", 0.0));
        }
        return $quizList;
    }

    public function getScore($userId, $quizId)
    {
        $tempScore =  $this->QC->getScore($userId, $quizId);
        if($tempScore == null)
            return 0;
        return $tempScore;
    }

    public function generateRandomPosition()
    {
        //randomize question's position
        $no = range(0,9); // {0, 1, 2, 3, ...}
        shuffle($no); // {3, 2, 6, 4, ...}
        return $no;
    }
}
?>
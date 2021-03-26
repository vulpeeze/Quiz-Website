<?php

function emptyInputSignup($name, $uid, $email, $pwd, $pwdRepeat, $status){
    $result;
    if(empty($name) || empty($uid) || empty($email) || empty($pwd) || empty($pwdRepeat) || empty($status)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function InvalidUsername($uid){
    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $uid)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function InvalidEmail($email){
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function PasswordMatch($pwd,$pwdRepeat){
    $result;
    if ($pwd !== $pwdRepeat){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function uidExists($conn, $uid, $email){
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $uid, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }   else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $uid, $email, $pwd, $status){
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd, userStatus) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtFailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $uid, $hashedPwd, $status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../register.php?error=none");
    exit();
}

function emptyInputLogin($username, $pwd){
    $result;
    if(empty($username) || empty($pwd)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd){
    $uidExists = uidExists($conn, $username, $username);


    if ($uidExists == false) {
        header("location: ../login.php?error=noUserName");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPassword = password_verify($pwd, $pwdHashed);
    if ($checkPassword == false) {
        header("location: ../login.php?error=wrongPassword");
        exit();
    } else if ($checkPassword == true) {
        session_start();
        $_SESSION["usersId"] = $uidExists["usersId"];
        $_SESSION["usersUid"] = $uidExists["usersUid"];
        $_SESSION["usersName"] = $uidExists["usersName"];
        $_SESSION["usersEmail"] = $uidExists["usersEmail"];
        $_SESSION["userStatus"] = $uidExists["userStatus"];
        header("location: ../index.php");
        exit();
    }
}

function nextQuestion($conn, $answer){
    checkAnswer($answer);
    
    $_SESSION['questionNumber']++;
    if ($_SESSION['questionNumber'] >= $_SESSION['totalQuestions']) {
        updateAttemptTable($conn);
        unsetQuiz();
        header("location: ../quizAttempts.php");
        exit();
    }
    return;
}

function checkAnswer($answer){
    if ($answer == $_SESSION['rightAnswer'][$_SESSION['questionNumber']]) {
        $_SESSION['quizScore']++;
    }
}

function updateAttemptTable($conn){
    $sql = "SELECT quizId, studentId, score FROM studentattempts WHERE quizId=" . $_SESSION['quiz'] . " AND studentId=" . $_SESSION['usersId'] . ";";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "id: " . $row["quizId"] . " and student ID is " . $row['studentId'] . " and score is " . $row['score'] . "<br>";
        $sql = "UPDATE studentAttempts SET score=" . $_SESSION['quizScore'] . " WHERE quizId=" . $row["quizId"] . " AND studentId=" . $row['studentId'] . ";";
        if ($conn->query($sql) === TRUE) {
            echo "Score updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
    } else {
        $sql = "INSERT INTO studentattempts(quizId, studentId, dateOfAttempt, score) VALUES (" . $_SESSION['quiz'] . ", " . $_SESSION['usersId'] . ",'" . date("Y/m/d") . "'," . $_SESSION['quizScore'] . ");";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

function unsetQuiz(){
    session_start();
    unset($_SESSION['quiz']);
    unset($_SESSION['questions']);
    unset($_SESSION['questionNumber']);
    unset($_SESSION['quizScore']);
    unset($_SESSION['totalQuestions']);
    unset($_SESSION['answer1']);
    unset($_SESSION['answer2']);
    unset($_SESSION['answer3']);
    unset($_SESSION['answer4']);
    unset($_SESSION['rightAnswer']);
}

function emptyInputCreateQuiz($quizName, $quizDuration){
    if(empty($quizName) || empty($quizDuration)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function createQuiz($conn, $quizName, $quizDuration){
    $sql = "INSERT INTO quizmetadata (quizName, quizAuthor, quizAvailable, quizDuration) VALUES (?,?,1,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../editQuizzes.php?quiz=stmtFailed");
        exit();
    }

    session_start();

    mysqli_stmt_bind_param($stmt, "ssi", $quizName, $_SESSION['usersName'], $quizDuration);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../editQuizzes.php?quiz=made");
    exit();
}

function addQuestion($conn, $question, $ans1, $ans2, $ans3, $ans4, $ansr){
    $sql = "INSERT INTO quizquestions (quizId, questions, answer1, answer2, answer3, answer4, rightAnswer) VALUES (" . $_SESSION['quiz'] . ", '$question', '$ans1', '$ans2', '$ans3', '$ans4', $ansr);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . mysqli_error($conn);
    }
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: editQuiz.inc.php?quiz=stmtFailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return;
}

function emptyInputAddQuestion($question, $ans1, $ans2, $ans3, $ans4, $ansr){
    $result;
    if(empty($question) || empty($ans1) || empty($ans2) || empty($ans3) || empty($ans4) || empty($ansr)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

function invalidRightAnswer($ansr){
    if ($ansr > 0 && $ansr < 5) {
        return false;
    } else {
        return true;
    }
}

function invalidDeleteRightAnswer($conn, $ansr){
    $sql = "SELECT * FROM quizquestions WHERE quizId = " . $_SESSION['quiz'] . ";";
    $stmt = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($stmt);

    if ($ansr > $resultCheck || $ansr < 1) {
        return true;
    } else {
        return false;
    }
}

function deleteQuestion($conn, $questionNumber){
    $sql = "SELECT questions FROM quizquestions WHERE quizId = " . $_SESSION['quiz'] . ";";
    $result = $conn->query($sql);
    $arr = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $arr[] = $row["questions"];
        }
    } else {
        echo "0 results";
    }

    $sql = "DELETE FROM quizquestions WHERE questions='" . $arr[$questionNumber-1] . "';";

    if ($conn->query($sql) === TRUE) {
        echo "Question deleted successfully";
    } else {
        echo "Error deleting questions: " . $conn->error;
    }
    $conn->close();
}

function updateQuestion($conn, $upQuestion, $question, $ans1, $ans2, $ans3, $ans4, $ansr){
    $sql = "SELECT questions,answer1 FROM quizquestions WHERE quizId = " . $_SESSION['quiz'] . ";";
    $result = $conn->query($sql);
    $arr = array();
    $arrr = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $arr[] = $row["questions"];
           $arrr[] = $row['answer1'];
        }
    } else {
        echo "0 results";
    }
    
    if ($question){
        $sql = "UPDATE quizquestions SET questions='" . $question . "' WHERE quizId =" . $_SESSION['quiz'] . " AND questions='" . $arr[$upQuestion-1] . "';";
        if ($conn->query($sql) === TRUE) {
            echo "Question updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    if ($ans1){
        $sql = "UPDATE quizquestions SET answer1='" . $ans1 . "' WHERE quizId =" . $_SESSION['quiz'] . " AND questions='" . $arr[$upQuestion-1] . "';";
        if ($conn->query($sql) === TRUE) {
            echo "Answer1 updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    if ($ans2){
        $sql = "UPDATE quizquestions SET answer2='" . $ans2 . "' WHERE quizId =" . $_SESSION['quiz'] . " AND questions='" . $arr[$upQuestion-1] . "';";
        if ($conn->query($sql) === TRUE) {
            echo "Answer2 updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    if ($ans3){
        $sql = "UPDATE quizquestions SET answer3='" . $ans3 . "' WHERE quizId =" . $_SESSION['quiz'] . " AND questions='" . $arr[$upQuestion-1] . "';";
        if ($conn->query($sql) === TRUE) {
            echo "Answer3 updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    if ($ans4){
        $sql = "UPDATE quizquestions SET answer4='" . $ans4 . "' WHERE quizId =" . $_SESSION['quiz'] . " AND questions='" . $arr[$upQuestion-1] . "';";
        if ($conn->query($sql) === TRUE) {
            echo "Answer4 updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    if ($ansr){
        $sql = "UPDATE quizquestions SET rightAnswer='" . $ansr . "' WHERE quizId =" . $_SESSION['quiz'] . " AND questions='" . $arr[$upQuestion-1] . "';";
        if ($conn->query($sql) === TRUE) {
            echo "AnswerR updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

}

function invalidRightAnswerUpdate($ansr){
    if ($ansr == "") {
        return false;
    } elseif ($ansr > 0 && $ansr < 5) {
        return false;
    } else {
        return true;
    }
}

function updateQuiz($conn, $quizId, $quizName, $quizDuration, $quizAvailable){    
    if ($quizName){
        $sql = "UPDATE quizmetadata SET quizName='" . $quizName . "' WHERE quizId =" . $quizId . ";";
        if ($conn->query($sql) === TRUE) {
            echo "Quiz Name updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    if ($quizDuration){
        $sql = "UPDATE quizmetadata SET quizDuration=" . $quizDuration . " WHERE quizId =" . $quizId . ";";
        if ($conn->query($sql) === TRUE) {
            echo "Quiz Duration updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    if ($quizAvailable || $quizAvailable==0){
        $sql = "UPDATE quizmetadata SET quizAvailable=" . $quizAvailable . " WHERE quizId =" . $quizId . ";";
        if ($conn->query($sql) === TRUE) {
            echo "Quiz Duration updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    header("location: ../editQuizzes.php?quiz=made");
    exit();
}

function emptyInputUpdateQuiz($quizId){
    if(empty($quizId)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}
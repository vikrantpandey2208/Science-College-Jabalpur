<?php
require_once('ClassTeacherLogin.php');
require_once('ClassTeacher.php');
require_once('ClassDepartment.php');
require_once('ClassUniversal.php');

/*
 * Created on Sat Dec 18 2021 11:50:32 am
 *
 * File Name teacher_login.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

session_start();

$teacherLoginObj = new TeacherLogin();
$teacherObj = new Teacher();
$departmentObj = new Department();
$universal = new Universal();

function Validate($data)
{
    $teacherLoginObj = new TeacherLogin();
    $result = 0;

    if ($teacherLoginObj->ReadForLogin($data[0], $data[1], $result)) {
        $result = $result->fetch_assoc();

        $_SESSION['teacher_user_id'] = $result['staff_login_id'];
        $_SESSION['teacher_user_table_id'] = $result['staff_login_teacher_id'];
        $_SESSION['teacher_user_name'] = $result['staff_login_username'];
        $_SESSION['teacher_user_desc'] = $result['staff_login_desc'];

        return true;
    } else
        return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array(
        $_POST['teacher_user_name'],
        hash('sha256', $_POST['teacher_user_user_password'])

    );
    if ($_POST['teacher_login_submit'] && $universal->CheckFormSet($data)) {
        if (Validate($data)) {
            echo "Login Successful redirection in 3 seconds.";
            header("refresh:3, url=dashboard.php");
        } else {
            echo "Login Failed Bad Credentials redirection in 3 seconds.";
            header("refresh:3, url=teacher_login.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        height: 100vh;
        width: 100vw;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 12px;
        background-color: aliceblue;
    }

    form {
        width: 600px;
        height: 400px;
        background-color: thistle;
        /* position: absolute; */
    }

    .heading {

        display: flex;
        justify-content: center;
        align-items: center;
    }

    input {
        width: 330px;
    }

    label,
    input {
        margin: 16px;
        padding: 5px 20px;
    }

    .row {
        display: flex;
        justify-content: space-between;
    }

    .line_7 {
        height: 50px;
        padding: 10px;
        margin: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    button {
        height: 30px;
        width: 250px;
        border: none;
        background-color: rgb(71, 151, 255);
        border-radius: 12px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="hod_section">

            <form action="teacher_login.php" method="POST">
                <div class="heading">

                    <h3>
                        Teacher Login
                    </h3>
                </div>

                <div class="line_4">
                    <div class="row">
                        <label for="hod_entity_id">Teacher UserName : </label>
                        <input type="text" name="teacher_user_name" id="teacher_user_name">
                    </div>
                </div>
                <div class="line_5">
                    <div class="row">
                        <label for="hod_name">Teacher Password : </label>
                        <input type="text" name="teacher_user_user_password" id="teacher_user_user_password">
                    </div>
                </div>


                <div class="line_7">
                    <div class="row">

                        <div class="button">
                            <button id="btn" type="submit" name="teacher_login_submit" value="done">Submit Data
                                Here</button>
                            <!-- <input type="submit" name="hod_create_submit" value="Submit Data Here"> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
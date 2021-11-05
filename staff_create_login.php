<?php
require_once('ClassTeacherLogin.php');
require_once('ClassDepartment.php');
require_once('ClassTeacher.php');
require_once('ClassUniversal.php');

/*
 * Created on Fri Nov 05 2021 7:48:06 pm
 *
 * File Name staff_create_login.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */
$teacherLoginObj = new TeacherLogin();
$teacherObj = new Teacher();
$departmentObj = new Department();
$universal = new Universal();

$nextTeacherLoginId = $teacherLoginObj->GetNextInsertId();

$createResult = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array(
        $_POST['staff_login_teacher_id'],
        $_POST['staff_login_username'],

        hash('sha256', $_POST['staff_login_user_password']),
        $_POST['staff_login_desc']

    );
    if ($_POST['staff_login_submit'] && $universal->CheckFormSet($data)) {
        if ($insert_id = $teacherLoginObj->Create($data)) {
            $createResult = "Teacher Login created successful <br>
                                        Redirecting in 3sec <br>
                                        Login  Id : " . $insert_id;

            header("refresh:3, url=#");
        } else {
            $createResult = "Teacher Login creation unsuccessfull <br>
                                    May be Entry already exists.;";
            header("refresh:3, url=#");
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
    <title>Staff create Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        height: 120vh;
        width: 100vw;
        display: flex;
        justify-content: center;
        /* align-items: center; */
        background-color: aliceblue;
    }

    form {
        width: 800px;
        height: 100vh;
        background-color: thistle;
        /* position: absolute; */
    }

    form h3 {
        margin-top: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    label,
    textarea,
    input {
        margin: 16px;
        padding: 5px 20px;
    }

    input,
    textarea {
        width: 400px;
        /* margin: 15px; */
        /* position:relative ; */
        /* left: 40%; */
        justify-content: space-between;
    }

    .row {
        display: flex;
        justify-content: space-between;

    }

    .button {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .btn {
        height: 30px;
        width: 150px;
        background-color: rgb(71, 151, 255);
        border-radius: 12px;
        border: none;
    }

    .btn:hover {
        background-color: cornflowerblue;
    }
    </style>
</head>

<body>

    <section>

        <div class="container">
            <form action="staff_create_login.php" method="Post">

                <h3>
                    Staff Login Module
                </h3>
                <!-- <p>This page containes the staff login information</p> -->

                <div class="row">
                    <label for="">HoD ID : </label>
                    <label for="">
                        <?php echo $nextTeacherLoginId; ?>
                    </label>
                </div>

                <div class="row">
                    <label for="">Staff Login Teacher ID : </label>
                    <select name="staff_login_teacher_id" id="staff_login_teacher_id">
                        <?php
                        if ($result = $teacherObj->Read("*")) {
                            while ($row = $result->fetch_assoc()) {
                                $deptName = $departmentObj->Read("department_name", "department_id", $row['teacher_staff_department_id']);
                                $deptName = $deptName->fetch_assoc()['department_name'];
                                echo "<option value=\" {$row['teacher_staff_id']}\"> {$row['teacher_staff_name']} - {$deptName}</option>";
                            }
                        }

                        ?>
                    </select>
                </div>
                <div class="row">
                    <label for="">Staff Login Username : </label>
                    <input type="text" name="staff_login_username" id="staff_login_username">
                </div>
                <div class="row">
                    <label for="">Staff Login User Password : </label>
                    <input type="password" name="staff_login_user password" id="staff_login_user password">
                </div>
                <div class="row">
                    <label for="">Staff Login Description : </label>
                    <textarea name="staff_login_desc" id="staff_login_desc" cols="30" rows="10"></textarea>
                    <!-- <input type="password" name="staff_login_desc" id="staff_login_desc">  -->
                </div>
                <div class="button">
                    <button class="btn" id="staff_login_submit" name="staff_login_submit" type="submit"
                        value="done">Submit
                        Here</button>
                </div>
            </form>
            <span>
                <?php echo $createResult; ?>
            </span>


        </div>

    </section>

</body>

</html>
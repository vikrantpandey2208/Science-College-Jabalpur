<?php
require_once('ClassUniversal.php');
require_once('ClassClass.php');
require_once('ClassSubject.php');
/*
 * Created on Fri Nov 05 2021 8:42:59 pm
 *
 * File Name subject_create.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

$classObj = new Classes();
$subjectObj = new Subject();
$universal = new Universal();

$nextSubjectId = $subjectObj->GetNextInsertId();

$createResult = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array(
        $_POST['subject_class_id'],
        $_POST['subject_name'],

        $_POST['subject_paper'],
        $_POST['subject_desc']

    );
    if ($_POST['subject_create_submit'] && $universal->CheckFormSet($data)) {
        if ($insert_id = $subjectObj->Create($data)) {
            $createResult = "Subject created successful <br>
                                        Redirecting in 3sec <br>
                                        Subject  Id : " . $insert_id;

            header("refresh:3, url=#");
        } else {
            $createResult = "Subject creation unsuccessfull <br>
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
    <title>Create Subject</title>
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
        align-items: center;
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
            <form action="subject_create.php" method="POST">

                <h3>
                    Subject Description Module
                </h3>
                <!-- <p>This page containes the staff login information</p> -->

                <div class="row">
                    <label for="">Subject ID : </label>
                    <label for="">
                        <?php echo $nextSubjectId; ?>
                    </label>
                </div>
                <div class="row">
                    <label for="">Subject Class ID : </label>
                    <select name="subject_class_id" id="class_department_id">
                        <?php
                        if ($result = $classObj->Read("*")) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=\"{$row['class_id']}\">{$row['class_name']} - {$row['class_section']} - {$row['class_id']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="row">
                    <label for="">Subject Name : </label>
                    <input type="text" name="subject_name" id="subject_name">
                </div>
                <div class="row">
                    <label for="">Subject Paper : </label>
                    <input type="text" name="subject_paper" id="subject_paper">
                </div>

                <div class="row">
                    <label for="">Subject Description : </label>
                    <textarea name="subject_desc" id="subject_desc" cols="30" rows="2"></textarea>
                    <!-- <input type="password" name="staff_login_desc" id="staff_login_desc">  -->
                </div>
                <div class="button">
                    <button class="btn" id="subject_create_submit" name="subject_create_submit" type="submit"
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
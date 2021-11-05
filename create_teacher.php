<?php
require_once("ClassTeacher.php");
require_once("ClassDepartment.php");
require_once("ClassEntity.php");
require_once("ClassUniversal.php");
/*
 * Created on Fri Nov 05 2021 3:33:16 pm
 *
 * File Name create_teacher.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

$teacherObj = new Teacher();
$deptObj = new Department();
$entityObj = new Entity();
$universal = new Universal();

$nextTeacherId = $teacherObj->GetNextInsertId();
$createResult = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array(
        $_POST['teacher_department_id'],
        $_POST['teacher_entity_id'],

        $_POST['teacher_name'],
        $_POST['teacher_mobile'],

        $_POST['teacher_email'],
        $_POST['teacher_address_line1'],

        $_POST['teacher_address_line2'],
        $_POST['teacher_desc'],
    );

    if ($_POST['teacher_create_submit'] && $universal->CheckFormSet($data)) {
        if ($insert_id = $teacherObj->Create($data)) {
            $createResult = "teacher created successful <br>
                                        Redirecting in 3sec <br>
                                        Hod Id : " . $insert_id;

            header("refresh:3, url=create_teacher.php");
        } else {
            $createResult = "teacher creation unsuccessfull <br>
                                    May be teacher already exists.;";
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
    <title>Teacher Creation</title>
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
        width: 600px;
        height: 700px;
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

    .line_11 {
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

            <form action="create_teacher.php" method="POST">
                <div class="heading">
                    <h3>
                        Teacher Section
                    </h3>
                </div>
                <div class="line_1">
                    <div class="row">
                        <label for="teacher_id">Teacher ID : </label>
                        <label for="">
                            <?php echo $nextTeacherId; ?>
                        </label>
                    </div>
                </div>
                <div class="line3">
                    <div class="row">
                        <label for="teacher_department_id">Department Id : </label>
                        <select name="teacher_department_id" id="teacher_department_id">
                            <?php
                            if ($result = $deptObj->Read("*")) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value=\"{$row['department_id']}\">{$row['department_id']} - {$row['department_name']}</option>";
                                }
                            }

                            ?>
                        </select>
                    </div>
                </div>
                <div class="line_4">
                    <div class="row">
                        <label for="teacher_entity_id">teacher Entity ID : </label>
                        <select name="teacher_entity_id" id="teacher_entity_id">
                            <?php
                            if ($result = $entityObj->Read("entity_name", "HOD")) {
                                while ($row = $result->fetch_assoc()) {
                                    if ($row['entity_id'] == 100002)
                                        echo "<option value=\"{$row['entity_id']}\" selected>{$row['entity_id']} - {$row['entity_name']}</option>";

                                    else
                                        echo "<option value=\"{$row['entity_id']}\">{$row['entity_id']} - {$row['entity_name']}</option>";
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="line_5">
                    <div class="row">
                        <label for="hod_name">teacher Name : </label>
                        <input type="text" name="teacher_name" id="hod_name">
                    </div>
                </div>
                <div class="line_6">
                    <div class="row">
                        <label for="hod_mobile">teacher Mobile Number : </label>
                        <input type="tel" name="teacher_mobile" id="hod_mobile">
                    </div>
                </div>
                <div class="line_7">
                    <div class="row">
                        <label for="hod_email">teacher Email Id : </label>
                        <input type="email" name="teacher_email" id="hod_email">
                    </div>
                </div>
                <div class="line_8">
                    <div class="row">
                        <label for="hod_address_line1">Adress Line 1 : </label>
                        <input type="text" name="teacher_address_line1" id="hod_address_line_1">
                    </div>
                </div>
                <div class="line_9">
                    <div class="row">
                        <label for="hod_address_line2">Adress Line 2 : </label>
                        <input type="text" name="teacher_address_line2" id="hod_address_line_2">
                    </div>
                </div>
                <div class="line_10">
                    <div class="row">
                        <label for="hod_desc">teacher Desectption : </label>
                        <input type="text" name="teacher_desc" id="hod_desc">
                        <!-- <textarea name="hod_desc" id="hod_desc" cols="30" rows="10"></textarea> -->
                    </div>
                </div>
                <div class="line_11">
                    <div class="row">

                        <div class="button">

                            <button id="btn" type="submit" name="teacher_create_submit" value="done">Submit Data
                                Here</button>
                            <!-- <input type="submit" name="hod_create_submit" value="Submit Data Here"> -->

                        </div>
                    </div>
                </div>
            </form>
            <span>
                <?php echo $createResult; ?>
            </span>
        </div>
    </div>
</body>

</html>
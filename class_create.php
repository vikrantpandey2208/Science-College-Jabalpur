<?php
require_once('ClassDepartment.php');
require_once('ClassUniversal.php');
require_once('ClassClass.php');
require_once('ClassGroup.php');
/*
 * Created on Fri Nov 05 2021 8:10:54 pm
 *
 * File Name class.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

$classObj = new Classes();
$departmentObj = new Department();
$universal = new Universal();
$groupObj = new Group();

$nextClassId = $classObj->GetNextInsertId();

$createResult = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array(
        $_POST['class_department_id'],
        $_POST['class_group_id'],

        $_POST['class_name'],
        $_POST['class_section'],

        $_POST['class_year'],
        $_POST['class_desc']

    );
    if ($_POST['class_create_submit'] && $universal->CheckFormSet($data)) {
        if ($insert_id = $classObj->Create($data)) {
            $createResult = "Class created successful <br>
                                        Redirecting in 3sec <br>
                                        Class  Id : " . $insert_id;

            header("refresh:3, url=#");
        } else {
            $createResult = "Class creation unsuccessfull <br>
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
    <title>Create Class</title>
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
            <form action="class_create.php" method="POST">

                <h3>
                    Class Details Module
                </h3>

                <div class="row">
                    <label for="">Class ID : </label>
                    <label for="">
                        <?php echo $nextClassId; ?>
                    </label>
                </div>
                <div class="row">
                    <label for="">Class Department ID : </label>
                    <select name="class_department_id" id="class_department_id">
                        <?php
                        if ($result = $departmentObj->Read("*")) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=\"{$row['department_id']}\">{$row['department_id']} - {$row['department_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <label for="">Class Group ID : </label>
                    <select name="class_group_id" id="class_group_id">
                        <?php
                        if ($result = $groupObj->Read("*")) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=\"{$row['group_id']}\">{$row['group_id']} - {$row['group_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <label for="">Class Name : </label>
                    <input type="text" name="class_name" id="class_name">
                </div>
                <div class="row">
                    <label for="">Class Section : </label>
                    <input type="text" name="class_section" id="class_section">
                </div>
                <div class="row">
                    <label for="">Class Year : </label>
                    <select name="class_year" id="class_year">
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>

                    </select>
                </div>
                <div class="row">
                    <label for="">Class Description : </label>
                    <textarea name="class_desc" id="class_description" cols="30" rows="2"></textarea>
                    <!-- <input type="password" name="staff_login_desc" id="staff_login_desc">  -->
                </div>
                <div class="button">
                    <button class="btn" id="staff_login_submit" name="class_create_submit" type="submit"
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
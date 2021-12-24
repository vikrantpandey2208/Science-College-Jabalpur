<?php
require_once('ClassTeacher.php');
require_once('ClassHod.php');
require_once('ClassTable.php');
/*
 * Created on Fri Nov 05 2021 4:46:10 pm
 *
 * File Name print_teacher.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

$teacherObj = new Teacher();
$hodObj = new Hod();
$tableObj = new Table();
session_start();

$loggedHodDepartment = $hodObj->Read("hod_department_id", "hod_id", $_SESSION['admin_user_table_id'])->fetch_assoc()['hod_department_id'];

$result = $teacherObj->Read("all", "teacher_staff_department_id", $loggedHodDepartment);


//Takes mysqli result as parameter


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="idea2.css">
    <title>Print Teacher</title>
</head>

<body>
    <section class="table_section">

        <div class="container table_full_data">

            <div class="table_section_heading">
                <h1>Project Detail</h1>
                <p>This is the teacher list of logged In Hod's department</p>

            </div>

            <!-- <div class="table_structure"> -->
            <!-- Covers full area of a table area -->

            <?php
            $head = $result->fetch_assoc();
            $result->data_seek(0);
            $tableObj->Print($result, array_keys($head), array_keys($head));
            ?>
            <div class="display_text">
                <p>This TimeTable is made for Science College Purpous</p>
                <button>Print</button>
            </div>
            <!-- </div> -->
        </div>

    </section>
    <!-- <footer>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit itaque deserunt rerum quibusdam illo commodi
            quis! Officiis reprehenderit, veritatis nam quidem iusto voluptas.
        </p>
    </footer> -->
</body>

</html>
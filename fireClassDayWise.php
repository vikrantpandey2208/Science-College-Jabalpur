<?php
require_once('ClassLevel1.php');
require_once('ClassTable.php');
require_once('ClassPrintLevel1.php');
require_once('ClassClass.php');
require_once('ClassWeekDay.php');
/*
 * Created on Fri Dec 24 2021 10:12:44 pm
 *
 * File Name fireClassDayWise.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

$level1Obj = new Level1();
$tableObj = new Table();
$printObj = new ClassPrintLevel1();
$classObj = new Classes();
$dayObj = new WeekDay();

$table = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  $_POST['class_submit'] && isset($_POST['class_id']) && isset($_POST['day_id'])) {

    $classId = $_POST['class_id'];
    $dayId = $_POST['day_id'];
    $sql = "select * from level1 where level1_class_id = " . $classId
        . " and level1_day_ids like '%" . $dayId . "%'";
    echo $sql;
    $result = $level1Obj->ReadCustomSql($sql);
    $table[] = $printObj->ArrayOfRowData($classObj->DecodeClass($classId), $result, false);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="idea2.css">
    <title>Fire Class Day Wise</title>
</head>

<body>
    <form action="fireClassDayWise.php" method="POST">
        <div class="heading">
            <h3>
                Class Selection
            </h3>
        </div>

        <div class="line1">
            <div class="row">
                <label for="class_id">Class 1st Year : </label>
                <select name="class_id" id="class_id">
                    <?php
                    if ($result = $classObj->Read("all", "class_year", 1)) {
                        echo "<option disabled selected>Select Class </option>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"{$row['class_id']}\">{$row['class_name']} - {$row['class_section']}</option>";
                        }
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="line2">
            <div class="row">
                <label for="day_id">Day : </label>
                <select name="day_id" id="day_id">
                    <?php
                    if ($result = $dayObj->Read("*")) {
                        echo "<option disabled selected>Select Day </option>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"{$row['weekday_id']}\">{$row['weekday_name']}</option>";
                        }
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="line_11">
            <div class="row">

                <div class="button">

                    <button id="btn" type="submit" name="class_submit" value="done">Submit Data
                        Here</button>
                    <!-- <input type="submit" name="hod_create_submit" value="Submit Data Here"> -->

                </div>
            </div>
        </div>
    </form>
    <section class="table_section">

        <div class="container table_full_data">

            <div class="table_section_heading">
                <h1>Project Detail</h1>
                <p>BSC Math Group</p>

            </div>

            <?php
            $heading = array(
                'Sections',
                'I <br> 09:30 - 10:15',
                'II <br> 10:15 - 11:00',
                'III <br> 11:00 - 11:45',
                'IV <br> 11:45 - 12:30',
                'V <br> 12:30 - 01:15',
                'VI <br> 01:15 - 02:00',
                'VII <br> 02:00 - 02:45',
                'VIII <br> 02:45 - 03:30',
                'IX <br> 03:30 - 04:15',
                'X <br> 04:15 - 05:00'
            );

            $tableObj->Print($heading, $table);
            ?>
            <div class="display_text">
                <p>This TimeTable is made for Science College Purpose</p>
                <button>Print</button>
            </div>
        </div>

    </section>

</body>

</html>
<?php
require_once('ClassLevel1.php');
require_once('ClassTable.php');
require_once('ClassPrintLevel1.php');
require_once('ClassTimeSlot.php');
require_once('ClassClass.php');
/*
 * Created on Fri Dec 24 2021 1:03:57 pm
 *
 * File Name fireDayWise.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */
//maintain default table layout
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

$level1Obj = new Level1();
$tableObj = new Table();
$printObj = new ClassPrintLevel1();
$slotObj = new TimeSlot();
$classObj = new Classes();

$classes = $printObj->GetNumberAndClasses();
$table = array();
$dayId = 3;

foreach ($classes as $classId) {
    $sql = "select * from level1 where level1_class_id = " . $classId
        . " and level1_day_ids like '%" . $dayId . "%'";
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
    <title>Fire Day Wise</title>
</head>

<body>

    <section class="table_section">

        <div class="container table_full_data">

            <div class="table_section_heading">
                <h1>Project Detail</h1>
                <p>BSC Math Group</p>

            </div>

            <?php
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
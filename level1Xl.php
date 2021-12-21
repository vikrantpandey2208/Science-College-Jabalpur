<?php
require_once('ClassLevel1.php');
require_once('ClassTable.php');
require_once('ClassPrintLevel1.php');
/*
 * Created on Mon Dec 20 2021 3:30:40 pm
 *
 * File Name level1Xl.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */
$level1Obj = new Level1();
$tableObj = new Table();
$printObj = new ClassPrintLevel1();

$clases = "";

$classCount = $printObj->GetNumberAndClasses($clases);
var_dump($clases);
echo $classCount;

$result = "";

$tableRow = array();
$day = array(
    "1" => "Mon",
    "2" => "Tue",
    "3" => "Wed",
    "4" => "Thu",
    "5" => "Fri",
    "6" => "Sat",
);
$result = $level1Obj->Read("all", "level1_class_id", 100014);
$s = "";

$i = 0;
$previousTimeStart = 1;
$previousTimeEnd = 1;

while ($rawData = $result->fetch_assoc()) {
    echo "p= " . $previousTimeStart;
    var_dump($previousTimeStart);


    echo "i=" . $i;
    echo "<br>" . $rawData['level1_subject_id'];


    if ($rawData["level1_timeslot_start"] === $previousTimeStart) {
        $tableRow[$i] = "vikrnt";
        echo "ture";
    } else {
        $tableRow[$i] = $rawData["level1_subject_id"] . " " . $rawData["level1_room_id"]
                . " " . $rawData['level1_day_ids'];
        $i++;
    }
    $previousTimeStart = $rawData["level1_timeslot_start"];
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="idea2.css">
        <title>Print Table</title>
    </head>

    <body>
        <section class="table_section">

            <div class="container table_full_data">

                <div class="table_section_heading">
                    <h1>Project Detail</h1>
                    <p>BSC Math Group</p>

                </div>

                <?php
                $heading = array(
                    'sections',
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

                $head = $tableRow;
                var_dump($head);


                $result->data_seek(0);
                $tableObj->Print($result, $heading, array_keys($head));
                ?>
                <div class="display_text">
                    <p>This TimeTable is made for Science College Purpose</p>
                    <button>Print</button>
                </div>
            </div>

        </section>

    </body>

</html>
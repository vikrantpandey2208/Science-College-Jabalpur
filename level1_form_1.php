<?php
require_once('ClassLevelGroup.php');
require_once('ClassClass.php');
require_once('ClassRoom.php');
require_once('ClassTimeSlot.php');
require_once('ClassLevel1.php');
require_once('ClassUniversal.php');

/*
 * Created on Sat Dec 18 2021 12:15:04 pm
 *
 * File Name level1_form_1.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

$levelGroupObj = new LevelGroup();
$classObj = new Classes();
$roomObj = new Room();
$timeSlot = new TimeSlot();
$level1Obj = new Level1();
$universal = new Universal();

$createResult = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $daySelected = null;
    if (isset($_POST['day'])) {
        foreach ($_POST['day'] as $day) {
            $daySelected .= $day;
        }
    }

    $data = array(
        $_POST['level1_group_id'],
        $_POST['level1_class_id'],
        $_POST['level1_subject_id'],
        $_POST['level1_room_id'],
        $daySelected, // add day[] here
        $_POST['level1_timestart_id'],
        $_POST['level1_timeend_id'],
        $_POST['level1_desc']
    );

    foreach ($_POST['day'] as $day)
        echo "day " . $day;
    if ($_POST['level1_create_submit'] && $universal->CheckFormSet($data)) {
        if ($insert_id = $level1Obj->Create($data)) {
            $createResult = "Task successful <br>
                                        Redirecting in 3sec <br>";

            header("refresh:3, url=#");
        } else {
            $createResult = "Operation unsuccessfull <br>
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
    <link rel="stylesheet" href="level1_form.css">
    <title>Level 1 Form For Testing</title>
</head>

<body onload="LoadClass(); LoadDraft()">
    <section class="level_1_form">

        <div class="container">

            <form action="level1_form_1.php" method="POST" autocomplete="on" id="level1_form">

                <div class="heading">
                    <h3>Level 1 Time Table Input Form</h3>
                    <p>This is the makes entry on the level 1 form</p>
                </div>

                <div class="row">
                    <label for="">Group Id : </label>
                    <select name="level1_group_id" id="level1_group_id" onchange="LoadClass()">
                        <?php
                        if ($result = $levelGroupObj->Read("*")) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=\"{$row['group_id']}\">{$row['group_name']} - {$row['group_desc']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <label for="">Class Id : </label>
                    <select name="level1_class_id" id="level1_class_id" onchange="LoadSubject(this.value)">
                        <option selected>Select Class </option>
                    </select>

                </div>

                <div class="row">
                    <label for="">Subject ID : </label>
                    <select name="level1_subject_id" id="level1_subject_id">
                        <option selected>Select Subject </option>
                    </select>
                </div>

                <div class="row">
                    <label for="">Room ID: </label>
                    <select name="level1_room_id" id="level1_room_id">
                        <?php
                        if ($result = $roomObj->Read("free")) {
                            echo "<option  selected>Select Room Number </option>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=\"{$row['room_id']}\">{$row['room_name']} - {$row['room_number']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="row">
                    <label for="">Days ID : </label>
                    <div class="days_section" id="vDay">
                        <div class="checkbox">
                            <input type="checkbox" name="day[]" id="" value="1">
                            <div class="box">
                                <p data-text="monday">
                                    Monday
                                </p>
                            </div>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" name="day[]" id="" value="2">
                            <div class="box">
                                <p data-text="tuesday">
                                    Tuesday
                                </p>
                            </div>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" name="day[]" id="" value="3">
                            <div class="box">
                                <p data-text="wednesday">
                                    Wednesday
                                </p>
                            </div>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" name="day[]" id="" value="4">
                            <div class="box">
                                <p data-text="thursday">
                                    Thursday
                                </p>
                            </div>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" name="day[]" id="" value="5">
                            <div class="box">
                                <p data-text="fryday">
                                    Fryday
                                </p>
                            </div>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" name="day[]" id="" value="6">
                            <div class="box">
                                <p data-text="saturday">
                                    Saturday
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="">Time Slot Start : </label>
                    <select name="level1_timestart_id" id="level1_timestart_id">
                        <?php
                        $column = array("timeslot_id", "timeslot_name", "timeslot_start");

                        if ($result = $timeSlot->Read($column, "1", "1", true)) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=\"{$row['timeslot_id']}\">{$row['timeslot_start']} - {$row['timeslot_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <label for="">Time Slot End : </label>
                    <select name="level1_timeend_id" id="level1_timeend_id">
                        <?php
                        $column = array("timeslot_id", "timeslot_name", "timeslot_end");
                        if ($result = $timeSlot->Read($column, "1", "1", true)) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=\"{$row['timeslot_id']}\">{$row['timeslot_end']} - {$row['timeslot_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <label for="">Level 1 Description : </label>
                    <textarea name="level1_desc" id="level1_desc" cols="30" rows="2"
                        placeholder="Enter Some Discription On This Entry...">
                        </textarea>
                </div>
                <div class="button">
                    <button class="btn" id="level1_create_submit" name="level1_create_submit" value="done"
                        type="submit">Submit
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

<script>
function LoadClass() {
    var passedArray = <?php echo json_encode($classObj->Read("*")->fetch_all()); ?>;
    var x = document.getElementById("level1_group_id").value;
    document.getElementById("level1_class_id").innerHTML = "<option  selected>Select Class</option>";

    var i = 0;
    while (i < passedArray.length) {
        var q = passedArray[i][2] == x;
        if (q) {
            console.log(passedArray[i][2] + " " + q + "=" + x);
            document.getElementById("level1_class_id").innerHTML = document.getElementById("level1_class_id")
                .innerHTML +
                "<option value='" + passedArray[i][0] + "'>" + passedArray[i][3] +
                " - " + passedArray[i][4] + " - " + passedArray[i][5] + "</option>";
        }
        i++;
    }
}

function LoadSubject(classId) {
    $.ajax({
        type: "post",
        url: 'ClassFetchSubjectDynamic.php',
        data: {
            id: classId
        },
        success: function(response) {
            document.getElementById("level1_subject_id").innerHTML = response;
        }
    })
}

document.getElementById("level1_form").onsubmit = function SaveDraft() {
    var group = document.getElementById('level1_group_id').value;
    var classId = document.getElementById('level1_class_id').value;
    var room = document.getElementById('level1_room_id').value;
    var desc = document.getElementById('level1_desc').value;
    var startTime = document.getElementById('level1_timestart_id').value;
    var endTime = document.getElementById('level1_timeend_id').value;

    localStorage.setItem("level1_group", group);
    localStorage.setItem("level1_classId", classId);
    localStorage.setItem("level1_room", room);
    localStorage.setItem("level1_desc", desc);
    localStorage.setItem("level1_startTime", startTime);
    localStorage.setItem("level1_endTime", endTime);
}

function LoadDraft() {
    var groupLast = localStorage.getItem("level1_group");
    var classId = localStorage.getItem("level1_classId")
    var room = localStorage.getItem("level1_room")
    var desc = localStorage.getItem("level1_desc")
    var startTime = localStorage.getItem("level1_startTime")
    var endTime = localStorage.getItem("level1_endTime")

    document.getElementById('level1_group_id').value = groupLast;
    LoadClass();

    document.getElementById('level1_class_id').value = classId;
    LoadSubject(classId);
    document.getElementById('level1_room_id').value = room;
    document.getElementById('level1_desc').value = desc;
    document.getElementById('level1_timestart_id').value = startTime;
    document.getElementById('level1_timeend_id').value = endTime;

}
</script>
<script src="js/jquery-3.2.1.min.js"></script>
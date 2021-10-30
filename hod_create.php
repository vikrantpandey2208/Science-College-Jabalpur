<?php
require_once("HodClass.php");
require_once("DepartmentClass.php");
require_once("EntityClass.php");
require_once("UniversalClass.php");

$hodObj = new Hod();
$deptObj = new Department();
$entityObj = new Entity();
$universal = new Universal();

$nextHodId = $hodObj->GetNextInsertId();
$createResult = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array(
        $_POST['hod_department_id'],
        $_POST['hod_entity_id'],

        $_POST['hod_name'],
        $_POST['hod_mobile'],

        $_POST['hod_email'],
        $_POST['hod_address_line1'],

        $_POST['hod_address_line2'],
        $_POST['hod_desc'],
    );

    if ($_POST['hod_create_submit'] && $universal->CheckFormSet($data)) {
        if ($insert_id = $hodObj->Create($data)) {
            $createResult = "Hod created successful <br>
                                        Redirecting in 3sec <br>
                                        Hod Id : " . $insert_id;

            header("refresh:3, url=hod_create.php");
        } else {
            $createResult = "Hod creation unsuccessfull <br>
                                    May be Hod already exists.;";
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
    <title>HOD Creation</title>
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

            <form action="hod_create.php" method="POST">
                <div class="heading">
                    <h3>
                        Hod Section
                    </h3>
                </div>
                <div class="line_1">
                    <div class="row">
                        <label for="hod_id">HoD ID : </label>
                        <label for="">
                            <?php echo $nextHodId; ?>
                        </label>
                    </div>
                </div>
                <div class="line3">
                    <div class="row">
                        <label for="hod_department_id">Department Id : </label>
                        <select name="hod_department_id" id="hod_department_id">
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
                        <label for="hod_entity_id">Hod Entity ID : </label>
                        <select name="hod_entity_id" id="hod_entity_id">
                            <?php
                            if ($result = $entityObj->Read("entity_name", "HOD")) {
                                while ($row = $result->fetch_assoc()) {
                                    if ($row['entity_id'] == 100003)
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
                        <label for="hod_name">HoD Name : </label>
                        <input type="text" name="hod_name" id="hod_name">
                    </div>
                </div>
                <div class="line_6">
                    <div class="row">
                        <label for="hod_mobile">HoD Mobile Number : </label>
                        <input type="tel" name="hod_mobile" id="hod_mobile">
                    </div>
                </div>
                <div class="line_7">
                    <div class="row">
                        <label for="hod_email">HoD Email Id : </label>
                        <input type="email" name="hod_email" id="hod_email">
                    </div>
                </div>
                <div class="line_8">
                    <div class="row">
                        <label for="hod_address_line1">Adress Line 1 : </label>
                        <input type="text" name="hod_address_line1" id="hod_address_line_1">
                    </div>
                </div>
                <div class="line_9">
                    <div class="row">
                        <label for="hod_address_line2">Adress Line 2 : </label>
                        <input type="text" name="hod_address_line2" id="hod_address_line_2">
                    </div>
                </div>
                <div class="line_10">
                    <div class="row">
                        <label for="hod_desc">HoD Desectption : </label>
                        <input type="text" name="hod_desc" id="hod_desc">
                        <!-- <textarea name="hod_desc" id="hod_desc" cols="30" rows="10"></textarea> -->
                    </div>
                </div>
                <div class="line_11">
                    <div class="row">

                        <div class="button">

                            <button id="btn" type="submit" name="hod_create_submit" value="done">Submit Data
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
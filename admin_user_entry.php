<?php
require_once('ClassAdminLogin.php');
require_once('ClassHod.php');
require_once('ClassDepartment.php');
require_once('ClassUniversal.php');

/*
 * Created on Wed Nov 03 2021 4:14:24 pm
 *
 * File Name admin_user_entry.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

$adminLoginObj = new AdminLogin();
$hodObj = new Hod();
$departmentObj = new Department();
$universal = new Universal();

$nextAdminLoginId = $adminLoginObj->GetNextInsertId();

$createResult = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array(
        $_POST['admin_user_table_id'],
        $_POST['admin_user_username'],

        hash('sha256', $_POST['admin_user_user_password']),
        $_POST['admin_user_desc']

    );
    if ($_POST['admin_user_create_submit'] && $universal->CheckFormSet($data)) {
        if ($insert_id = $adminLoginObj->Create($data)) {
            $createResult = "Admin Login created successful <br>
                                        Redirecting in 3sec <br>
                                        Login  Id : " . $insert_id;

            header("refresh:3, url=admin_user_entry.php");
        } else {
            $createResult = "Admin Login creation unsuccessfull <br>
                                    May be Entry already exists.;";
            header("refresh:3, url=admin_user_entry.php");
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
    <title>Admin User Entry</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
            background-color: aliceblue;
        }

        form {
            width: 600px;
            height: 400px;
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

        .line_7 {
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

            <form action="admin_user_entry.php" method="POST">
                <div class="heading">

                    <h3>
                        Admin User Entry Section
                    </h3>
                </div>
                <div class="line_1">
                    <div class="row">
                        <label for="hod_id">HoD ID : </label>
                        <label for="">
                            <?php echo $nextAdminLoginId; ?>
                        </label>
                    </div>
                </div>
                <!-- <div class="line_2">
                    <div class="row">
                        <label for="admin_user_entity_id">Admin User Entity Id : </label>
                        <input type="text" name="admin_user_entity_id" id="admin_user_entity_id">
                    </div>
                </div> -->
                <div class="line_3">
                    <div class="row">
                        <label for="admin_user_table_id">Admin User Table Id : </label>
                        <select name="admin_user_table_id" id="admin_user_table_id">
                            <?php
                            if ($result = $hodObj->Read("*")) {
                                while ($row = $result->fetch_assoc()) {
                                    $deptName = $departmentObj->Read("department_name", "department_id", $row['hod_department_id']);
                                    $deptName = $deptName->fetch_assoc()['department_name'];
                                    echo "<option value=\" {$row['hod_id']}\"> {$row['hod_name']} - {$deptName}</option>";
                                }
                            }

                            ?>
                        </select>
                    </div>
                </div>
                <?php

                ?>
                <div class="line_4">
                    <div class="row">
                        <label for="hod_entity_id">Admin UserName : </label>
                        <input type="text" name="admin_user_username" id="admin_user_username">
                    </div>
                </div>
                <div class="line_5">
                    <div class="row">
                        <label for="hod_name">Admin Password : </label>
                        <input type="text" name="admin_user_user_password" id="admin_user_user_password">
                    </div>
                </div>

                <div class="line_6">
                    <div class="row">
                        <label for="hod_desc">Admin Desectption : </label>
                        <input type="text" name="admin_user_desc" id="admin_user_desc">
                        <!-- <textarea name="hod_desc" id="hod_desc" cols="30" rows="10"></textarea> -->
                    </div>
                </div>
                <div class="line_7">
                    <div class="row">

                        <div class="button">
                            <button id="btn" type="submit" name="admin_user_create_submit" value="done">Submit Data
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
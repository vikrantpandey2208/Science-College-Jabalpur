<?php
require_once('ClassAdminLogin.php');
require_once('ClassUniversal.php');

/*
 * Created on Mon Dec 20 2021 2:58:01 pm
 *
 * File Name principalLogin.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

session_start();

$superLoginObj = new AdminLogin();
$universal = new Universal();

function Validate($data)
{
    $superLoginObj = new AdminLogin();
    $result = 0;
    if ($superLoginObj->ReadForLogin($data[0], $data[1], $result, true)) {
        $result = $result->fetch_assoc();

        $_SESSION['super_id'] = $result['super_id'];
        $_SESSION['super_username'] = $result['super_username'];
        $_SESSION['super_desc'] = $result['super_desc'];

        return true;
    } else
        return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array(
        $_POST['admin_user_username'],
        hash('sha256', $_POST['admin_user_user_password'])

    );
    if ($_POST['admin_user_create_submit'] && $universal->CheckFormSet($data)) {
        if (Validate($data)) {
            echo "Super Login Successful redirection in 3 seconds.";
            header("refresh:3, url=dashboard.php");
        } else {
            echo "Super Login Failed Bad Credentials redirection in 3 seconds.";
            header("refresh:3, url=principalLogin.php");
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
    <title>Hod Login</title>
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

            <form action="principalLogin.php" method="POST">
                <div class="heading">

                    <h3>
                        Super Login
                    </h3>
                </div>

                <div class="line_4">
                    <div class="row">
                        <label for="hod_entity_id">Super UserName : </label>
                        <input type="text" name="admin_user_username" id="admin_user_username">
                    </div>
                </div>
                <div class="line_5">
                    <div class="row">
                        <label for="hod_name">Super Password : </label>
                        <input type="text" name="admin_user_user_password" id="admin_user_user_password">
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
        </div>
    </div>
</body>

</html>
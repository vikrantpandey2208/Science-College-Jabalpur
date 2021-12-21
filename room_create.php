<?php
require_once('ClassRoom.php');

$dept = new Room();
$nextRoomId = $dept->GetNextInsertId();
$createResult = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['room_create_submit'])) {

        if (isset($_POST['room_name']) && isset($_POST['room_desc'])) {
            if ($insert_id = $dept->Create($_POST['room_number'], $_POST['room_name'], $_POST['room_desc'])) {
                $createResult = "Room created successful <br>
                                        Redirecting in 3sec <br>
                                        Room Id : " . $insert_id;
                header("refresh:2, url=room_create.php");
            } else {
                $createResult = "Room creation unsuccessfull <br>
                                    May be Room already exists.;";
                header("refresh:2, url=room_create.php");
            }
            unset($_POST['room_name']);
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
    <title>Room Create</title>
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
        background-color: aliceblue;
    }

    form {
        width: 550px;
        height: 400px;
        background-color: thistle;
        /* position: absolute; */
    }

    form h3 {
        margin: 1rem 0;
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
        width: 300px;
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

    <div class="container">
        <form action="room_create.php" class="form_input" method="POST">
            <h3>Room Creation</h3>
            <div class="row">
                <label for="">Room ID : </label>
                <label for="">
                    <?php echo $nextRoomId; ?>
                </label>
            </div>
            <div class="row">
                <label for="">Room Number : </label>
                <input type="text" name="room_number" id="room_number">
            </div>
            <div class="row">
                <label for="">Room Name : </label>
                <input type="text" name="room_name" id="room_name">
            </div>
            <div class="row">
                <label for="">Room Description : </label>
                <textarea name="room_desc" id="" cols="30" rows="2"></textarea>
                <!-- <input type="text" name="room_desc" id="room_desc"> -->
            </div>
            <div class="button">
                <button class="btn" id="room_create_submit" name="room_create_submit" type="submit">Submit Here</button>
            </div>
        </form>
        <span>
            <?php echo $createResult; ?>
        </span>
    </div>

</body>

</html>
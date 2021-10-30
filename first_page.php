<?php
include 'DepartmentClass.php';
$dept = new Department();
$nextDepartmentId = $dept->GetNextInsertId();
$createResult = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['department_create_submit'])) {

        if (isset($_POST['department_name']) && isset($_POST['department_desc'])) {
            if ($insert_id = $dept->Create($_POST['department_name'], $_POST['department_desc'])) {
                $createResult = "Department created successful <br>
                                        Redirecting in 3sec <br>
                                        Department Id : " . $insert_id;
                header("refresh:3, url=first_page.php");
            } else {
                $createResult = "Department creation unsuccessfull <br>
                                    May be Department already exists.;";
            }
            unset($_POST['department_name']);
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
    <title>FIRST PAGE</title>
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
    }

    form {
        width: 550px;
        height: 300px;
        background-color: thistle;
        /* position: absolute; */
    }

    label,
    input {
        margin: 16px;
        padding: 5px 20px;
    }

    input {
        /* margin: 15px; */
        /* position:relative ; */
        /* left: 40%; */
        justify-content: space-between;
    }

    .row,
    .row1,
    .row2,
    .row3 {
        display: flex;
        justify-content: space-between;

    }

    .row5 {
        display: flex;
        justify-content: center;
    }

    .btn {
        height: 30px;
        width: 150px;
        background-color: rgb(71, 151, 255);
        border-radius: 12px;
    }
    </style>
</head>

<body>
    <div class="container">

        <form id=department_create action="first_page.php" method="post">

            <div class="row1">
                <label for="department_id">Department ID :</label>
                <label for="">
                    <?php echo $nextDepartmentId; ?>
                </label>
            </div>
            <div class="row2">
                <label for="department_name">Department Name :</label>
                <input type="text" name="department_name" id="department_name">
            </div>
            <div class="row3">
                <label for="department_desc">Department Desecreption :</label>
                <input type="text" name="department_desc" id="department_desc">
            </div>

            <div class="row5">
                <!-- <label for="submit">Click Here For Submit Data -> </label> -->
                <input class="btn" type="submit" value="Create" name="department_create_submit"
                    id="department_create_submit">
            </div>

        </form>
        <span>
            <?php echo $createResult; ?>
        </span>
    </div>
</body>

</html>
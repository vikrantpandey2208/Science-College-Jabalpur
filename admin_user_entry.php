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

            <form action="">
                <div class="heading">

                    <h3>
                        Admin User Entry Section
                    </h3>
                </div>
                <div class="line_1">
                    <div class="row">
                        <label for="hod_id">Admin User Id : </label>
                        <input type="number" name="admin_user_id" id="admin_user_id">
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
                        <label for="hod_department_id">Admin User Table Id : </label>
                        <input type="text" name="admin_user_table_id" id="admin_user_table_id">
                    </div>
                </div>
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
                            <button id="btn" type="submit" name="hod_create_submit">Submit Data Here</button>
                            <!-- <input type="submit" name="hod_create_submit" value="Submit Data Here"> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
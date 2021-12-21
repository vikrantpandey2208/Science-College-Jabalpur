<?php
require_once("ClassSubject.php");

/*
 * Created on Sat Dec 18 2021 7:28:33 pm
 *
 * File Name ClassFetchSubjectDynamic.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */
$subjectObj = new Subject();


if (isset($_POST['id'])) {

    $column = array(
        "subject_id", "subject_name", "subject_paper"
    );

    $find = $subjectObj->Read($column, "subject_class_id", $_POST['id'], true);
    //  echo $query;
    echo "<option selected>Select Subject </option>";
    if (!$find) {
        echo "<option value= > No Subject Exist</option>";
    }

    while ($row = mysqli_fetch_assoc($find)) {
        echo "<option value= {$row['subject_id']}>" . $row['subject_name'] . "-" . $row['subject_paper'] . "</option>";
    }
    exit;
}
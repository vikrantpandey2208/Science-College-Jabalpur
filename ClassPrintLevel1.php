<?php

require_once('ClassLevel1.php');
require_once('ClassSubject.php');
require_once('ClassRoom.php');
require_once('ClassTimeSlot.php');
require_once('ClassWeekday.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassPrintLevel1
 *
 * @author user
 */
class ClassPrintLevel1 {

    public function GetNumberAndClasses() {
        $level1Obj = new Level1();
        $classInfo = array();

        $result = $level1Obj->ReadCustomSql("select Distinct level1_class_id from level1");
        while ($row = $result->fetch_assoc()) {
            $classInfo[] = $row['level1_class_id'];
        }
        return $classInfo;
    }

    // optional params includeDayCode = false will remove day code
    public function ArrayOfRowData($className, $result, $includeDayCode = true) {
        $subjectObj = new Subject();
        $roomObj = new Room();
        $dayObj = new WeekDay();
        $tableRow = array();

        $tableRow[0] = $className;
        $multiPeriodIndex = -1;
        $multiCond = false;

        $i = 1;
        $previousTimeStart = 1;
        $slotSequence = 0;
        $counter = 0;

        while ($rawData = $result->fetch_assoc()) {

            $counter++;
            $i++;
            $slotSequence++;

            // maintaining blank period
            if ($rawData["level1_timeslot_start"] > $slotSequence) {
                $tableRow[$i] = "--";
                $counter--;
                $result->data_seek($counter);
                continue;
            }

            // maintain multiple subject on different days
            if ($rawData["level1_timeslot_start"] == $previousTimeStart) {
                $i--;
            }

            //include or exclude day code
            if ($includeDayCode) {
                // maintaining undefine offset error
                if (isset($tableRow[$i])) {
                    $tableRow[$i] .= $subjectObj->DecodeSubject($rawData["level1_subject_id"]) . "<br> " . $roomObj->DecodeRoom($rawData["level1_room_id"])
                            . " <b>" . $dayObj->DecodeWeekday($rawData['level1_day_ids']) . "</b><br>";
                } else {
                    $tableRow[$i] = $subjectObj->DecodeSubject($rawData["level1_subject_id"]) . "<br> " . $roomObj->DecodeRoom($rawData["level1_room_id"])
                            . " <b>" . $dayObj->DecodeWeekday($rawData['level1_day_ids']) . "</b><br>";
                }
            } else {
                // maintaining undefine offset error
                if (isset($tableRow[$i])) {
                    $tableRow[$i] .= $subjectObj->DecodeSubject($rawData["level1_subject_id"]) . "<br> " . $roomObj->DecodeRoom($rawData["level1_room_id"])
                            . "<br>";
                } else {
                    $tableRow[$i] = $subjectObj->DecodeSubject($rawData["level1_subject_id"]) . "<br> " . $roomObj->DecodeRoom($rawData["level1_room_id"])
                            . "<br>";
                }
            }

            // maintain double same period
            if ($rawData["level1_timeslot_end"] - $rawData["level1_timeslot_start"] > 0) {
                $multiPeriodIndex = $i;
                $multiCond = true;
                echo "eyasf";
            }

            if ($multiCond && $multiPeriodIndex == $i - 1) {
                $multiCond = false;
                $tableRow[$i] = $tableRow[$i - 1];
                $counter--;
                $result->data_seek($counter);
                $i++;
            }

            $previousTimeStart = $rawData["level1_timeslot_start"];
        }
        return $tableRow;
    }

    public function RowDataSlotWise($className, $result, $includeDayCode = true) {
        $subjectObj = new Subject();
        $roomObj = new Room();
        $dayObj = new WeekDay();
        $tableRow = array();

        $tableRow[0] = $className;

        $multiPeriodIndex = -1;
        $multiCond = false;

        $i = 1;
        $previousTimeStart = 1;
        $slotSequence = 0;
        $counter = 0;

        while ($rawData = $result->fetch_assoc()) {

            $counter++;
            $i++;
            $slotSequence++;

            // maintain multiple subject on different days
            if ($rawData["level1_timeslot_start"] == $previousTimeStart) {
                $i--;
            }

           //include or exclude day code
            if ($includeDayCode) {
                // maintaining undefine offset error
                if (isset($tableRow[$i])) {
                    $tableRow[$i] .= $subjectObj->DecodeSubject($rawData["level1_subject_id"]) . "<br> " . $roomObj->DecodeRoom($rawData["level1_room_id"])
                            . " <b>" . $dayObj->DecodeWeekday($rawData['level1_day_ids']) . "</b><br>";
                } else {
                    $tableRow[$i] = $subjectObj->DecodeSubject($rawData["level1_subject_id"]) . "<br> " . $roomObj->DecodeRoom($rawData["level1_room_id"])
                            . " <b>" . $dayObj->DecodeWeekday($rawData['level1_day_ids']) . "</b><br>";
                }
            } else {
                // maintaining undefine offset error
                if (isset($tableRow[$i])) {
                    $tableRow[$i] .= $subjectObj->DecodeSubject($rawData["level1_subject_id"]) . "<br> " . $roomObj->DecodeRoom($rawData["level1_room_id"])
                            . "<br>";
                } else {
                    $tableRow[$i] = $subjectObj->DecodeSubject($rawData["level1_subject_id"]) . "<br> " . $roomObj->DecodeRoom($rawData["level1_room_id"])
                            . "<br>";
                }
            }
            // maintain double same period
            if ($rawData["level1_timeslot_end"] - $rawData["level1_timeslot_start"] > 0) {
                $multiPeriodIndex = $i;
                $multiCond = true;
            }

            if ($multiCond && $multiPeriodIndex == $i - 1) {
                $multiCond = false;
                $tableRow[$i] = $tableRow[$i - 1];
                $counter--;
                $result->data_seek($counter);
                $i++;
            }

            $previousTimeStart = $rawData["level1_timeslot_start"];
        }
        return $tableRow;
    }

}

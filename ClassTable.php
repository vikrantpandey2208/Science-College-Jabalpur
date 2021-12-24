<?php

/*
 * Created on Fri Nov 05 2021 9:04:11 pm
 *
 * File Name ClassTable.php
 * ============================================================
 * Program for .....
 * ============================================================
 *
 * Copyright (c) 2021 @Vikrant Pandey
 */

/*
  1. Print table()


 */

class Table {

    function PrintResultSet(&$result, $head, $script) {
        echo '<table class="table_content">
            <thead class="table_heading">
            <tr class="heading_row"> ';

        foreach ($head as $heading) {
            echo "<th>{$heading}</th>";
        }

        echo '</tr>
            </thead>
            <tbody class="table_body">';

        while ($row = $result->fetch_assoc()) {
            foreach ($script as $index) {
                echo "<th>{$row[$index]}</th>";
            }
            echo '</tr>';
        }
        echo "</tbody></table>";
    }

    function Print($head, $table) {
        echo '<table class="table_content">
            <thead class="table_heading">
            <tr class="heading_row"> ';

        foreach ($head as $heading) {
            echo "<th>{$heading}</th>";
        }

        echo '</tr>
            </thead>
            <tbody class="table_body">';

        foreach ($table as $tableRow) {
            foreach ($tableRow as $item) {
                echo "<td>{$item}</td>";
            }
            echo '</tr>';
        }
        

        echo "</tbody></table>";
    }

}

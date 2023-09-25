<?php

if (!function_exists('fill_tasks')) {

    function fill_tasks($tasks)
    {
        $output = '';

            try{
                foreach (json_decode($tasks) as $task ) {
                    $output .= "<option value='{$task}'>{$task}</option>";
                }
            } catch (Exception $e){

            }
        return $output;

    }



}


?>

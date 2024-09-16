<?php
    namespace App\Helper;

    class Helper
    {
        function updateProgressStatus($check_progress_status, $progress_status) {
            if ($check_progress_status->progress_status <= $progress_status) {
                $check_progress_status->progress_status = 1;
                $check_progress_status->save();
            }
        }
    }
?>

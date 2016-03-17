
<script src="../js/jquery.js"></script>
<script src="../js/jquery.countdown.js"></script>
<script src="../js/jquery.countdown.min.js"></script>


<?php
$endTime ="2016-03-21 21:39:00";
$counter = 0;
        echo "<h6 class=\"pull-right\" style=\"color:#880000\">Time left ~ {$counter}";
        echo                "<div class=\"pull-right\" id=\"" . "{$counter}" . "\"></div>";
        echo            "</h6>";



?>


    <script>
        var <?php echo "t{$counter}"; ?> = <?php echo json_encode($$endTime); ?>;

        var <?php echo "d{$counter}"; ?> =
        Date.createFromMysql(<?php echo "t{$counter}"; ?>);

        <?php $div_counter = "clock{$counter}"; ?>


        $(<?php echo "'#" . "{$counter}" . "'"; ?>).countdown(<?php echo "d{$counter}"; ?>, function (event) {
            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
            $(this).html(event.strftime(totalHours + ' hr %M min %S sec'));
        });
    </script>

<?php


?>
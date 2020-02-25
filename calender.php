<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            table, td, tr{
                border-collapse: collapse;
                margin-left: 25%;
                margin-right:25%;
                height: 100%;
                /*border: 1px #000000 solid;*/
            }
            td{
                border: 1px #000000 solid;
                border-left: none;
                border-right: none;
            }
           .heading td
           {
               background-color: #4286f4;
               padding:10px;
               width: 70px;
               height: 70px;
               color: #ffffff;
               text-align: center;
               border:none;
           }
           .calData td
           {
               background-color: #b0cdfc;
               padding:10px;
               height: 100px;
               text-align: center;
           }
        </style>
    </head>
    <body>

<?php
    

            $daysOfWeek = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
            
            echo '<table>';
            
            echo '<tr class = "heading">';
            foreach ($daysOfWeek as $day) {
                echo "<td>$day</td>";
            }
            echo '</tr>';
            
            
            if(isset($_POST['monthCalender'])){
              
                if(isset($_POST['month'])){
                    $month = $_POST['month'];
                }
                if(isset($_POST['year'])){
                    $year = $_POST['year'];
                }
                
            }
            else {
                 $year[0] = 2017;
                 $month[0] = 9;
            }

            $julianDay = gregoriantojd($month[0],1,$year[0]);
            $firstDayMonth=jddayofweek($julianDay,0);
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN,$month[0], $year[0]);
        
            $daysLeftinMonth = 1;
            
            for($rowCount = 1;$rowCount <=6 ; $rowCount++){
                
                echo '<tr class="calData">';
                
                for($columnCount = 0;$columnCount <=6;$columnCount++){
                    
                    if($rowCount == 1){
                        if($columnCount >= $firstDayMonth){
                            echo "<td>$daysLeftinMonth</td>";
                            $daysLeftinMonth++;
                        }
                        else{
                            echo "<td> </td>";
                        }
                    }
                    
                    else if($daysLeftinMonth <= $daysInMonth){
                        echo "<td>$daysLeftinMonth</td>";
                        $daysLeftinMonth++;
                    }
                    else{
                        break;
                    }
                   
                }
                
                echo '</tr>';
            }
            
            echo '</table>'
?>
</body>
</html>

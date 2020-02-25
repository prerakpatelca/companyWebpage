<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
        body  {
            background-image: url("cal_1.jpg");
            
        }
        .container{
            margin-top: 250px;
            margin-left: 500px;
            overflow: hidden;
            width: 300px;
        }
        select{
            width : 150px;
            margin-left: 15px;
        }
        label{
            color: #223fe5;
        }
</style>
    </head>
    <body>
        
        
            <?php
            $allmonth = array("January","February","March","April","May","June","July","August","September","October","Novermber","December");           
           ?>
           
            <div class="container" align="right">
            <form action="calender.php" method="post">
            
            <label class="monthLabel">Select Month</label>
            <select name="month[]">
                
            <?php
            $monthcount = 1;

            foreach ($allmonth as $month) {
                echo "<option value='$monthcount'>$month</option>";
                echo $monthcount;
                $monthcount++;
            }
            ?>
                    
            </select>
            <br><label class="yearLabel">Select Year</label>
            <select name = "year[]">
               
            <?php
            for($count = 1950;$count<=2050;$count++){
                echo "<option value = '$count'>$count</option>";
            }
            ?>
                   
            </select>
            <br />
            <br />
            <input type="submit" name="monthCalender" value="View Calander" class="submitKey">
            
            </form>
            </div>

    </body>
</html>

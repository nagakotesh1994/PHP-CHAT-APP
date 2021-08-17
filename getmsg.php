<?php
    error_reporting(0);
    include 'dbconfig.php';
    $tablename = $_GET['tablename']; 
    $typeing= $_GET['typeing'] ;

    $query = "SELECT * FROM ".$tablename."T ORDER BY reg_date ASC";

    $result = $conn->query($query);

    if(mysqli_num_rows($result)>0)
    {    
        echo "<br>";
        $date_check=0;
        while($row = mysqli_fetch_array($result))
        {
            $date_time = explode(' ',$row['reg_date']);
            $date = $date_time[0];
            $time = $date_time[1];
            $time = explode(':',$time);
            $time = $time[0].":".$time[1];
            
            if($date_check!=$date)
            {
                if(date('Y-m-d')==$date)
                    echo "<p class='date'>Today</p>";
                else if( date('Y-m-d',strtotime("-1 days")) == $date)
                    echo "<p class='date'>Yesterday</p>";
                else
                    echo "<p class='date'>".$date."</p>";
                $date_check=$date;
            }

            if($row['sender_msg']!='')
                echo "<p align='right'><span  class='s'>{$row['sender_msg']}</span><br><span class='time_r'>{$time}</span></p>";
                
            if($row['reciver_msg']!='')
                echo "<p align='left' ><span class='r'>{$row['reciver_msg']}</span><br><span class='time_l'>{$time}</span></p>";
        }

        if($typeing == 1)
            $query = "UPDATE ".$tablename."T SET `typeing`=1 WHERE `id`=1";
          else
            $query = "UPDATE ".$tablename."T SET `typeing`=0 WHERE `id`=1";
        $conn->query($query);
        
        echo "||";
        $opp_table_name = strrev($tablename)."T";
        $query = "SELECT typeing FROM {$opp_table_name} WHERE id=1";
        $result=$conn->query($query);
        
        
        while($row = mysqli_fetch_array($result))
        {
            if($row['typeing']==1)
                echo "typeing...";
            else
                echo "&nbsp;";
        }

        
        
        
        
            


    }
?>
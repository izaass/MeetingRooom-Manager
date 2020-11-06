<?php   
    include 'config.php'; 
    if(isset($_POST["room_id"]))  
    {  
    $query  = "SELECT * FROM phong_hop WHERE id = '".$_POST["room_id"]."'";  
    $result = mysqli_query($connect, $query);  
    $row    = mysqli_fetch_array($result);  
            echo json_encode($row);  
    }  
 ?>
<?php   
    include 'config.php'; 
    if(isset($_POST["ev_id"]))  
    {  
    $query  = "SELECT * FROM su_kien WHERE id = '".$_POST["ev_id"]."'";  
    $result = mysqli_query($connect, $query);  
    $row    = mysqli_fetch_array($result);  
            echo json_encode($row);  
    }  
 ?>
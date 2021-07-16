<?php

    session_start();
    //including the header (includes/header.php)
    include_once("includes/header.php");
    loginRequired('hospital');
    $id = $_SESSION["id"];
    $query = new query();

    //If Hospital deleted any request
    if(isset($_GET["delete"])){
        $delId = $_GET["delete"];
        $query->deleteData("requestedBloods", array("receiverId"=>$delId, "hospitalId"=>$id));
    }
    $result = $query->getData("requestedBloods","*", array("hospitalId"=>$id));
    $hospital = $query->getData("hospitals","name", array("id"=>$id));
    
    $name = $hospital[0]["name"];
    
?>   

    <h1 class="text-center">Welcome<?php echo " ".$name . "!" ?></h1><br>
    <div class="container ">

        <table class="table table-hover">

            <tr><th>Name</th><th>BloodGroup</th><th>Units</th><th>Del</th></tr>

            <?php
                if($result){
                    //displaying all the results
                    foreach($result as $row){
                    
                        echo "<tr><td>" . $row["receiverName"] . "</td><td>" . $row["bloodGroup"] . "</td><td>". $row["units"] . "</td><td><a class = 'btn btn-danger glyphicon glyphicon-trash' href = 'requestedBlood.php?delete=" . $row["receiverId"] ."'></a></td></tr>";
                    }

                }
                else{
                    echo "<div class = 'alert alert-success'>No Data To Show</div>";
                }
                
                
            ?>
            
            
        </table><br>
        
    
    </div>

<?php 

    //including footer (includes/footer.php)
    include_once("includes/footer.php");

?>
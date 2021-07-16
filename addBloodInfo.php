<?php

    session_start();
    //including the header (includes/header.php)
    include_once("includes/header.php");

    //checking for Hospital users
    loginRequired('hospital');
    
    $id = $_SESSION["id"];
    $query = new query();
    $result = $query->getData("hospitals","*", array("id"=>$id));
    $name = $result[0]["name"];

    //When user clicks the updateBloodInfo button
    if(isset($_POST["submit"])){

        $AP = $_POST["AP"];
        $AN = $_POST["AN"];

        $BP = $_POST["BP"];
        $BN = $_POST["BN"];

        $ABP = $_POST["ABP"];
        $ABN = $_POST["ABN"];

        $OP = $_POST["OP"];
        $ONeg = $_POST["ONeg"];

        if($query->getData("hospitalBloodData", "*", array("id"=>$id))){
            $query->updateData("hospitalBloodData", array("id"=>$id, "AP"=>$AP, "AN"=>$AN,"BP"=>$BP, "BN"=>$BN, "ABP"=>$ABP, "ABN"=>$ABN, "OP"=>$OP, "ONeg"=>$ONeg), array("id"=>$id));
        }
        else{
            $query->addData("hospitalBloodData",array("id"=>$id, "AP"=>$AP, "AN"=>$AN,"BP"=>$BP, "BN"=>$BN, "ABP"=>$ABP, "ABN"=>$ABN, "OP"=>$OP, "ONeg"=>$ONeg), array("id"=>$id));
        }

    }
    $bloodInfo = $query->getData("hospitalBloodData","*", array("id"=>$id));

?>   

    <h1 class="text-center">Welcome<?php echo " ".$name . "!" ?></h1><br>
    <div class="container ">

        <table class="table table-hover">

            <tr><th>Name</th><th>A+</th><th>A-</th><th>B+</th><th>B-</th><th>AB+</th><th>AB-</th><th>O+</th><th>O-</th></tr>

            <?php
                if($bloodInfo){
                    $bloodInfo = $bloodInfo[0];
                    echo "<tr><td>" . $name . "</td><td>" . $bloodInfo["AP"] ." units". "</td><td>" . $bloodInfo["AN"] ." units". "</td><td>" . $bloodInfo["BP"] ." units". "</td><td>" . $bloodInfo["BN"] ." units". "</td><td>" . $bloodInfo["ABP"] ." units". "</td><td>" . $bloodInfo["ABN"] ." units". "</td><td>" . $bloodInfo["OP"] ." units". "</td><td>" . $bloodInfo["ONeg"] ." units". "</td><tr>";
                }
                else{
                    echo "<div class = 'alert alert-success'>No Data To Show</div>";
                }
              
            ?>
            
        </table><br>
        
        <form action = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>' method="post" class=" form-inline">
            
            <p class="text-center" id="heading">Enter Blood-Samples Units</p><br>
            
            <div class="row">
                
                <div class="col-sm-3 col-xs-3 col-lg-3 col-md-3">
                    <label>A+</label>
                    <input type="number" class="form-control " placeholder="A+ units" name="AP" min="0" value= <?php if($bloodInfo){ echo $bloodInfo["AP"];} else echo 0; ?> required>
                </div>

                <div class="col-sm-3 col-xs-3 col-lg-3 col-md-3">
                    <label>A-</label>
                    <input type="number" class="form-control" placeholder="A- units" name="AN" min="0" value= <?php if($bloodInfo){ echo $bloodInfo["AN"];} else echo 0;  ?> required>
                </div>

                <div class="col-sm-3 col-xs-3 col-lg-3 col-md-3">
                    <label>B+</label>
                    <input type="number" class="form-control " placeholder="B+ units" name="BP" min="0" value= <?php if($bloodInfo){ echo $bloodInfo["BP"];} else echo 0;  ?> required>
                </div>

                <div class="col-sm-3 col-xs-3 col-lg-3 col-md-3">
                    <label>B-</label>
                    <input type="number" class="form-control" placeholder="B- units" name="BN" min="0" value= <?php if($bloodInfo){ echo $bloodInfo["BN"];} else echo 0;  ?> required>
                </div>
            </div><br>

            <div class="row">

                <div class="col-sm-3 col-xs-3 col-lg-3 col-md-3">
                    <label>AB+</label>
                    <input type="number" class="form-control " placeholder="AB+ units" name="ABP" min="0" value= <?php if($bloodInfo){ echo $bloodInfo["ABP"];} else echo 0; ?> required>
                </div>

                <div class="col-sm-3 col-xs-3 col-lg-3 col-md-3">
                    <label>AB-</label>
                    <input type="number" class="form-control" placeholder="AB- units" name="ABN" min="0" value= <?php if($bloodInfo){ echo $bloodInfo["ABN"];} else echo 0; ?> required>
                </div>

                <div class="col-sm-3 col-xs-3 col-lg-3 col-md-3">
                    <label>O+</label>
                    <input type="number" class="form-control " placeholder="O+ units" name="OP" min="0" value= <?php if($bloodInfo){ echo $bloodInfo["OP"];} else echo 0; ?> required>
                </div>

                <div class="col-sm-3 col-xs-3 col-lg-3 col-md-3">
                    <label>O-</label>
                    <input type="number" class="form-control" placeholder="O- units" name="ONeg" min="0" value= <?php if($bloodInfo){ echo $bloodInfo["ONeg"];} else echo 0; ?> required>
                </div>
            </div><br><br>

            <input type="submit" value="Update Blood Info" class="center-block btn btn-success" name="submit"><br> 
            <a href="requestedBlood.php" type="submit" style="width: fit-content;" class="center-block btn btn-danger" id="requested">Requested Blood Samples</a> 
        </form>
    
    </div>

<?php 

    //including footer (includes/footer.php)
    include_once("includes/footer.php");

?>
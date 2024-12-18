<?php
require_once 'conf.php';
function GetTableData2($query,$connect){
try {
    $result=mysqli_query($connect,$query);

    if(mysqli_num_rows($result)>0){
        $col=mysqli_fetch_fields($result);

        while($row=mysqli_fetch_assoc($result)){
            echo "<div>";
            foreach($row as $value){
                echo  $value."<br>";
                if($row!='empty'){
                    echo "<div style='background-color:#FFBABA;'>";
                    echo "</div>";
                }
            }
            echo "</div>";
        }
    }
    else{
        echo "no result";
    }
} catch (Exception $e) {
    die($e->getMessage());
}
}


function GetTableData($query,$connection){
    $result = mysqli_query($connection,$query);
    $data = array();
    if (mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    return $data;
}

function RequiredField($value,$msg="the field can't be empty")
{
    if (empty($_POST[$value])) {
        echo $msg;
        return false;
    } else {
        return true;
    }

}

function ParkingUpdate($slot,$vno,$park,$connection){
    $vno = $park=='alloc'?$vno:"EMPTY";
    $query = "update parkinglog set vehicle_no='$vno' where id = $slot";
    $result = mysqli_query($connection,$query);
    if (!$result){
        die("Error".mysqli_error($connection));
    }
    else{
        echo "<label class='success'>Parking updated</label>";
    }
}
function ValidateSlot($slot,$connection){
    $slot = $_POST[$slot];
    $query = "select vehicle_no from parkinglog where  id = $slot and vehicle_no != 'EMPTY'";
    $result = mysqli_query($connection,$query);
    $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0){
        echo "Slot is not available, already allocated to ".$data[0]['vehicle_no'];
        return false;
    }else{
        return true;
    }

}

?>

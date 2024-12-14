<html lang="HTML">
<head>

    <title>Parking Management App</title>
    <style>
        <
        style type

        =
        "text/css"
        >
        .main {
            margin: 40px;
            padding: 20px;
            background-color: #CDF5FD;
            display: flex;
            flex-direction: column;
        }

        .head {
            margin: 10px;
            display: flex;
            flex-direction: row;
        }

        .content {
            padding: 10px;
            background-color: #ffff;
            display: flex;
            flex-direction: row;
        }

        .left {
            border: 2px solid #00A9FF;
            float: left;
            width: 65%;
            background-color: #A0E9FF;
            margin-right: 10px;
        }

        .right {
            border: 2px solid #D0A2F7;
            float: right;
            width: 35%;
            background-color: #E5D4FF;
        }

        h2 {
            text-align: center;
            padding: 5px;
        }

        .space {
            margin: 10px;
            padding: 10px;
        }

        .parking-container {
            display: flex;
            flex-wrap: wrap;
        }

        .parking-container > div {
            background-color: #f1f1f1;
            margin: 10px;
            padding: 5px;
            text-align: center;
            line-height: 25px;
            font-size: 20px;
            border: 2px firebrick solid;
            border-radius: 5px;
            width: 80px;
        }

        .error {
            padding: 5px;
            color: #D8000C;
            background-color: #FFBABA;
            line-height: 25px;
        }

        .success {
            color: #4F8A10;
            background-color: #DFF2BF;
            padding: 5px;
            margin: 10px;
        }
    </style>
</head>
<body>
<?php
require_once 'conf/conf.php';
require_once 'func/func.php';
$e1=false; $e2=false; $e3=false; $e4=false;
?>
<div class="main">
    <div class="head">
        <div class="left">
            <h2>
                Parking View
            </h2>
        </div>
        <div class="right">
            <h2>
                Control panel
            </h2>
        </div>
    </div>
    <div class="content">
        <div class="left">
            <div class="parking-container">
                <?php
                $query = "select * from parkinglog";
                $slots = GetTableData($query, $connection);
                foreach ($slots as $slot) {
                    $id = $slot['parking_slot'];
                    $vno = $slot['vehicle_no'];
                    if ($vno == 'EMPTY') {
                        echo "<div>";
                    } else {
                        echo "<div style='background-color: coral'>";
                    }
                    echo "$id<br>$vno</div>";
                }
                ?>

            </div>
        </div>
        <div class="right">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table>
                    <tr>
                        <td align="right">Option:</td>
                        <td>
                            <label>
                                <input type="radio" name="park" value="alloc">Allocate
                                <input type="radio" name="park" value="free">Free

                            </label>
                        </td>
                        <td>

                                <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    echo "<label class='error'>";
                                    $e4 = RequiredField("park", "Please select the option");
                                    echo "</label>";
                                }
                                ?>


                        </td>
                    </tr>
                    <tr>
                        <td>Slot No:</td>
                        <td align="right">
                            <label>
                                <input type="number" name="slot">
                            </label>
                        </td>
                        <td>
                            <label class="error">
                                <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST' && $e4) {
                                    echo "<label class='error'>";
                                    $e1 = RequiredField("slot", "Please provide the slot number");
                                    echo "</label>";
                                    if ($_POST['park'] == 'alloc') {
                                        if ($e1) {
                                            echo "<label class='error'>";
                                            $e3 = ValidateSlot("slot", $connection);
                                            echo "</label>";
                                        }
                                    }
                                }
                                ?>
                            </label>

                        </td>
                    </tr>
                    <tr>
                        <td>Vehicle No:</td>
                        <td align="right">
                            <label>
                                <input type="text" name="vno">
                            </label>
                        </td>
                        <td>
                            <label class="error">
                                <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST' && $e4) {
                                    if ($_POST['park'] == 'alloc') {
                                        echo "<label class='error'>";
                                        $e2 = RequiredField("vno", "Please provide the vehicle number");
                                        echo "</label>";
                                    }
                                }
                                ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                        </td>
                        <td>
                            <label>
                                <input type="submit" name="alloc_btn" value="Allocate or Free">
                            </label>
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if($e4){
                                    if ($e1 && $e3) {
                                        $slot = $_POST['slot'];
                                        $vno = $_POST['vno'];
                                        $park = $_POST['park'];
                                        ParkingUpdate($slot, $vno, $park, $connection);
                                    }
                                }

                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

</body>

</html>


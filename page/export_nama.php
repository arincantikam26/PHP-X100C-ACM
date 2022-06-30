<?php 
    include '../connect/connect_db.php';
    include '../library_soap/lib_soap_x100c.php';
    
    
?>

<center>
<h1>INPUT USER BARU KE DEVICE</h1>
<br>
<h3>
<a href="../action/input_nama.php">Form Input User</a>  |   
<a href="../action/hapus_user.php">Hapus User</a>  |  
<a href="../index.php">Back to Home</a>
</h3>
<br>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Form Input User</title>
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="../asset_style/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../asset_style/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="../asset_style/style.css" />

    <script type="text/javascript" src="../asset_style/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../asset_style/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

<div class="page-header">
    <h1>Form Input User to Device</h1>
</div>
<?php
    
    $data = mysqli_query($db, "SELECT * FROM data_user");
    while ($rows = mysqli_fetch_array($data)) {
        $Id_val[] = $rows['user_id'];
        $Name_val[] = $rows['nama'];
    }
    echo '<pre>';  print_r($Id_val); echo '</pre>';
    echo '<pre>';  print_r($Name_val); echo '</pre>';

?>
<!-- Simple Login - START -->
<!-- you need to include the shieldui css and js assets in order for the charts to work -->
<link rel="stylesheet" type="text/css" href="https://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="https://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>

<div class="container" id="container1">
    <div class="col-md-6 col-md-offset-3" id="colorDiv">
        <div class="col-md-6 col-md-offset-3" id="innerDiv">
            <div class="page-header">
                <h3>Form User</h3>
            </div>
            <form method="POST" action="export_nama.php">
                <div class="form-group">
                    <button type="submit" id="submitBtn" name="submit_user" value="submit_user" >Upload</button>
                </div>           
            </form>
            <br />
            <div class="footer"><br>
                <p>&copy; ACM 2022</p>
            </div>            
        </div>
    </div>    
</div>

<script type="text/javascript">
    $(function () {
        $('#submitBtn').shieldButton();

        $('#dropdown').shieldDropDown({
            cls: "large"
        });
    });
</script>

</div>

</body>
</html>

    <?php 
      $IP = "192.168.1.201"; //ip&key sesuaikan dengan mesin
      $Key = "0";
   
      $connect = fsockopen($IP, "80", $errno, $errstr, 1);
   
    $id = "";
    $name = "";
    $buffer[]= "";
        if (isset($_POST['submit_user'])) {

            for($i=0; $i<count($Id_val); $i++) {
               
                if ($connect) {
                    $user_id[] = $Id_val[$i];
                    $nama[] = $Name_val[$i];
                    echo count($Id_val);

                    //choice soap request from library
                    $Soap_val[$i] = "<SetUserInfo>
                                    <ArgComKey Xsi:type=\"xsd:integer\">".$Key."</ArgComKey>
                                    <Arg>
                                        <PIN>".$Id_val[$i]."</PIN>
                                        <Name>".$Name_val[$i]."</Name>
                                    </Arg>
                                </SetUserInfo>";
                    $newLine = "\r\n";
                    fputs($connect, "POST /iWsService HTTP/1.0".$newLine);
                    fputs($connect, "Content-Type: text/xml".$newLine);
                    fputs($connect, "Content-Length: ".strlen($Soap_val[$i]).$newLine.$newLine);
                    fputs($connect, $Soap_val[$i].$newLine);

                    while($Response[$i]=fgets($connect, 1024)){
                        $buffer[$i]=$buffer[$i].$Response[$i]; 
                    }
                    // Parsing data buffer dan convert to array
                    $buffer[$i]=Parse_Data($buffer[$i],"<Information>","</Information>");
                    echo "<B>Result:</B><BR>";
                    echo '<pre>';  print_r($buffer); echo '</pre>';

                  
                }
            }      
        }
        

    ?>


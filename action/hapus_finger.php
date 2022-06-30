<?php 
    include '../connect/connect_device.php';
    include '../library_soap/lib_soap_x100c.php';
?>
<center>
<h1>HAPUS FingerID DARI DEVICE</h1>
<br>
<h3>
<a href="upload_sidik_jari.php">Form Input FingerID</a>  |   
<a href="hapus_finger.php">Hapus FingerID</a>  |  
<a href="../index.php">Back to Home</a>
</h3>
<br>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Form Hapus User</title>
   
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
    <h1>Form Hapus User dari Device</h1>
</div>

<!-- Simple Login - START -->
<!-- you need to include the shieldui css and js assets in order for the charts to work -->
<link rel="stylesheet" type="text/css" href="https://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="https://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>

<div class="container" id="container1">
    <div class="col-md-6 col-md-offset-3" id="colorDiv">
        <div class="col-md-6 col-md-offset-3" id="innerDiv">
            <div class="page-header">
                <h3>Form FingerID By User</h3>
            </div>
            <form method="POST" action="hapus_finger.php">
                <div class="form-group">
                    <label for="user_id">User ID</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" placeholder="input user_id here ..." required>
                </div>
                <div class="form-group">
                <button type="submit" id="submitBtn" name="submit_finger" value="submit_finger" onclick="return confirm('Yakin Hapus?')">Delete</button>
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
    $id = "";

        if($connect) {
            if (isset($_POST['submit_finger'])) {
                $id = $_POST['user_id'];
                
            }

            //choice soap request from library
            $Soap_val = "<DeleteTemplate>
                            <ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey>
                            <Arg>
                                <PIN xsi:type=\"xsd:integer\">".$id."</PIN>
                            </Arg>
                        </DeleteTemplate>";
            $newLine = "\r\n";
            fputs($connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($connect, "Content-Type: text/xml".$newLine);
            fputs($connect, "Content-Length: ".strlen($Soap_val).$newLine.$newLine);
            fputs($connect, $Soap_val.$newLine);
            
            $buffer = "";
            while($Response=fgets($connect, 1024)){
                $buffer=$buffer.$Response;
            }
        }
         // Parsing data buffer dan convert to array
        $buffer=Parse_Data($buffer,"<DeleteTemplateResponse>","</DeleteTemplateResponse>");
        $buffer=Parse_Data($buffer,"<Information>","</Information>");
        echo "<B>Result:</B><BR>".$buffer;

    ?>
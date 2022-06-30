<?php 
    include '../connect/connect_device.php';
    include '../library_soap/lib_soap_x100c.php';
?>
<center>
<h1>INPUT USER BARU KE DEVICE</h1>
<br>
<h3>
<a href="../form_page/form_input_nama.php">Form Input Db</a> | 
<a href="../page/user_list.php">List User</a>  |   
<a href="hapus_user.php">Hapus User</a>  |  
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
            <form method="POST" action="input_nama.php">
                <div class="form-group">
                    <label for="user_id">User ID</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" placeholder="input user_id here ..." required>
                </div>
                <div class="form-group">
                    <label for="user_name">Nama User</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="input user name here ..." required>
                </div>
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
    $id = "";
    $name = "";
        if($connect) {
            if (isset($_POST['submit_user'])) {
                $id = $_POST['user_id'];
                $name = $_POST['user_name'];
                
            }

            //choice soap request from library
            $Soap_val = "<SetUserInfo>
                            <ArgComKey Xsi:type=\"xsd:integer\">".$Key."</ArgComKey>
                            <Arg>
                                <PIN>".$id."</PIN>
                                <Name>".$name."</Name>
                            </Arg>
                        </SetUserInfo>";
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
         $buffer=Parse_Data($buffer,"<Information>","</Information>");
         echo "<B>Result:</B><BR>";
         echo $buffer;
    ?>


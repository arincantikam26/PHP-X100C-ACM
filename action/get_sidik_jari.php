<?php 
    include '../connect/connect_device.php';
    include '../library_soap/lib_soap_x100c.php';
?>
<center>
<h1>INPUT USER BARU KE DEVICE</h1>
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
    <title>Form Get Sidik Jari</title>
   
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
    <h1>Form Get Sidik Jari</h1>
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
            <form method="POST" action="get_sidik_jari.php">
                <div class="form-group">
                    <label for="user_id">User ID</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" placeholder="input user_id here ..." required>
                </div>
                <div class="form-group">
                    <label for="finger_id">Finger ID</label>
                    <input type="text" class="form-control" id="finger_id" name="finger_id" placeholder="input FingerID User ..." required>
                </div>
                <div class="form-group">
                <button type="submit" id="submitBtn" name="submit_finger" value="submit_finger" >Upload</button>
                </div>           
            </form>
            <br />
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
    $fn = "";
        if($connect) {
            if (isset($_POST['submit_finger'])) {
                $id = $_POST['user_id'];
                $fn = $_POST['finger_id'];
                
            }

            //choice soap request from library
            $Soap_val = "<GetUserTemplate>
                            <ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey>
                            <Arg>
                                <PIN xsi:type=\"xsd:integer\">".$id."</PIN>
                                <FingerID xsi:type=\"xsd:integer\">".$fn."</FingerID>
                            </Arg>
                        </GetUserTemplate>";
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
    ?>
    <br>
    <div class="container" id="container1">
<table class="table table-striped">
<?php $no=1;?>
  <thead>
    <tr>
        <th scope="col">No</th>
        <th scope="col">User ID</th>
        <th scope="col">Finger ID</th>
        <th scope="col">Size</th>
        <th scope="col">Valid</th>
        <th scope="col">Template</th>
    </tr>
  </thead>
  <tbody>
    <?php 
       	$buffer=Parse_Data($buffer,"<GetUserTemplateResponse>","</GetUserTemplateResponse>");
        $buffer=explode("\r\n",$buffer);

           for($a=1;$a<count($buffer)-1;$a++){
               $data=Parse_Data($buffer[$a],"<Row>","</Row>");
               $PIN=Parse_Data($data,"<PIN>","</PIN>");
               $FingerID=Parse_Data($data,"<FingerID>","</FingerID>");
               $Size=Parse_Data($data,"<Size>","</Size>");
               $Valid=Parse_Data($data,"<Valid>","</Valid>");
               $Template=Parse_Data($data,"<Template>","</Template>");
    ?>
    <tr>
        <th scope="col"><?=$a?></th>
        <th scope="col"><?=$PIN?></th>
        <th scope="col"><?=$FingerID?></th>
        <th scope="col"><?=$Size?></th>
        <th scope="col"><?=$Valid?></th>
        <th scope="col"><?=$Template?></th>
    </tr>
    <?php
        } 
    ?>
  </tbody>
</table>
    <div class="footer"><br>
        <p>&copy; ACM 2022</p>
    </div>            
    
</div>

        
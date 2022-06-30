<?php
    include '../connect/connect_db.php';
    include '../page/user_list.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Form User Data</title>
    <meta http-equiv="refresh" content="20">
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
    <h1>Form Input Data User to DB</h1>
</div>

<!-- Simple Login - START -->
<!-- you need to include the shieldui css and js assets in order for the charts to work -->
<link rel="stylesheet" type="text/css" href="https://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="https://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>

<div class="container" id="container1">
    <div class="col-md-6 col-md-offset-3" id="colorDiv">
        <div class="col-md-6 col-md-offset-3" id="innerDiv">
            <div class="page-header">
                <h3>Import Data User From Device Export to Database</h3>
            </div>
            <form method="POST" action="form_input_nama.php">
                <div class="form-group">
                <button type="submit" id="submitBtn" name="submit_user" value="submit_user" onclick="return confirm('Yakin Import?')">Upload</button>
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
    if(isset($_POST['submit_user'])) {
        for ($i = 1; $i < count($buffer)-1; $i++) {
            $data=Parse_Data($buffer[$i],"<Row>","</Row>");
            $PIN=Parse_Data($data,"<PIN>","</PIN>");
            $Name=Parse_Data($data,"<Name>","</Name>");
            $Password=Parse_Data($data,"<Password>","</Password>");
            $Group=Parse_Data($data,"<Group>","</Group>");
            $Privilege=Parse_Data($data,"<Privilege>","</Privilege>");
            $Card=Parse_Data($data,"<Card>","</Card>");
            $PIN2=Parse_Data($data,"<PIN2>","</PIN2>");
            $TZ1=Parse_Data($data,"<TZ1>","</TZ1>");
            $TZ2=Parse_Data($data,"<TZ2>","</TZ2>");
            $TZ3=Parse_Data($data,"<TZ3>","</TZ3>");

        $sql = mysqli_query($db,"INSERT INTO data_user (user_id, nama, password, id_two)
            VALUES('$PIN','$Name', '$Password', '$PIN2')
        ");
        }
        if($sql) {
            echo "<script>alert('Data Berhasil Tersimpan')</script>";
        } else {
            echo "<script>alert('Data Gagal Tersimpan')</script>";
        }
    }
    
?>
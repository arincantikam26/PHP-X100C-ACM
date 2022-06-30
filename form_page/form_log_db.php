<?php
    include '../connect/connect_db.php';
    include '../action/get_log_data.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Form Log Absen</title>
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
    <h1>Form Input Log Data Absen to DB</h1>
</div>

<!-- Simple Login - START -->
<!-- you need to include the shieldui css and js assets in order for the charts to work -->
<link rel="stylesheet" type="text/css" href="https://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="https://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>

<div class="container" id="container1">
    <div class="col-md-6 col-md-offset-3" id="colorDiv">
        <div class="col-md-6 col-md-offset-3" id="innerDiv">
            <div class="page-header">
                <h3>LOG-Absen-Terakhir</h3>
            </div>
            <form method="POST" action="form_log_db.php">
                <div class="form-group">
                    <label for="user_id">User ID</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" readonly value=<?php echo $PIN ?>>
                </div>
                <div class="form-group">
                    <label for="verified">Verified</label>
                    <input type="text" class="form-control" id="verified" name="verified" readonly value=<?php echo $Verified ?>>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" class="form-control" id="status" name="status" readonly value=<?php echo $Status ?>>
                </div>
                <div class="form-group">
                <button type="submit" id="submitBtn" name="submit_log" value="submit">Upload</button>
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
    if(isset($_POST['submit_log'])) {
        $Id = $_POST['user_id'];
        $Verified = $_POST['verified'];
        $Status = $_POST['status'];

        $sql = mysqli_query($db,"INSERT INTO log_data (user_id, verified, status)
            VALUES('$Id','$Verified', '$Status')
        ");

        if($sql) {
            echo "<script>alert('Data Berhasil Tersimpan')</script>";
        } else {
            echo "<script>alert('Data Gagal Tersimpan')</script>";
        }
    }
?>
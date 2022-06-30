<?php
    include '../action/get_log_data.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Table Log Absen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="../asset_style/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../asset_style/font-awesome/css/font-awesome.min.css" />

    <script type="text/javascript" src="../asset_style/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../asset_style/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

<div class="page-header">
    <h1>Table Log Data Absensi</h1>
</div>

<!-- Simple Login - START -->
<!-- you need to include the shieldui css and js assets in order for the charts to work -->
<link rel="stylesheet" type="text/css" href="https://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="https://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>

<div class="container" id="container1">
<table class="table table-striped">
<?php $no=1;?>
  <thead>
    <tr>
        <th scope="col">No</th>
        <th scope="col">User ID</th>
        <th scope="col">Tanggal & Jam</th>
        <th scope="col">Verifikasi</th>
        <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
    <?php 
        for ($i = 1; $i < count($buffer)-1; $i++) {
            $data=Parse_Data($buffer[$i],"<Row>","</Row>");
            $PIN=Parse_Data($data,"<PIN>","</PIN>");
            $DateTime=Parse_Data($data,"<DateTime>","</DateTime>");
            $Verified=Parse_Data($data,"<Verified>","</Verified>");
            $Status=Parse_Data($data,"<Status>","</Status>");
    ?>
    <tr>
        <th scope="col"><?=$i?></th>
        <th scope="col"><?=$PIN?></th>
        <th scope="col"><?=$DateTime?></th>
        <th scope="col"><?=$Verified?></th>
        <th scope="col"><?=$Status?></th>
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

<style>
    #container1 {
        background-color: #B0C4DE;
    }

    #colorDiv {
        background-color: #666666;
        height: 500px;
        margin-top: 50px;
        margin-bottom: 50px;
        border-radius: 15px;
    }

    .footer {
        text-align: center;
    }

    .footer a {
        color: #d9d9d9;
    }
</style>

<script type="text/javascript">
    $(function () {
        $('#submitBtn').shieldButton();

        $('#dropdown').shieldDropDown({
            cls: "large"
        });
    });
</script>
<!-- Simple Login - END -->

</div>

</body>
</html>
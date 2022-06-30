<?php 
    include '../connect/connect_device.php';
    include '../library_soap/lib_soap_x100c.php';
?>
<center>
<h1>RESTART DEVICE</h1>
<br>
<h3> 
<a href="../index.php">Back to Home</a>
</h3>
<br>
<form method="POST" action="restart.php">
    IP Address: <input type="text" name="ip" id="ip" value="<?=$IP?>" size=15 readonly><br><br>
    Comm Key: <input type="text" name="key" id="key" size="5" value="<?=$Key?>" readonly><br><br>
    <input type="submit" value="restart" name="restart">
</form>
<br>
    <?php
        if(isset($_POST["restart"])) {
            if($connect) {
                $Soap_val = Soap_request("device", 1);
                $newLine = "\r\n";
                fputs($connect, "POST /iWsService HTTP/1.0".$newLine);
                fputs($connect, "Content-Type: text/xml".$newLine);
                fputs($connect, "Content-Length: ".strlen($Soap_val).$newLine.$newLine);
                fputs($connect, $Soap_val.$newLine);
                
                $buffer = "";
                while($Response=fgets($connect, 1024)){
                    $buffer=$buffer.$Response;
                }
            } else {
                echo "Connection Failed!";
            }
            echo $buffer;
            $buffer=Parse_Data($buffer,"<Information>","</Information>");
            echo $buffer;
        } else {
            echo "Press Button to Restart!";
        }
    ?>


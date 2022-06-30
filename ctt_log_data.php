<?php
include ("connect_x100c.php");
?>

<table cellspacing="2" cellpadding="2" border="1">
    <tr align="center">
	    <td><B>UserID</B></td>
        <td width="200"><B>Tanggal & Jam</B></td>
	    <td><B>Verifikasi</B></td>
	    <td><B>Status</B></td>
	</tr>

    <?php
        if($connect) {
            $soap_val = Soap_request("log_absen", 1);
            $newLine = "\r\n";
            fputs($connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($connect, "Content-Type: text/xml".$newLine);
            fputs($connect, "Content-Length: ".strlen($soap_val).$newLine.$newLine);
            fputs($connect, $soap_val.$newLine);
            
            $buffer = "";
            while($Response=fgets($connect, 1024)){
                $buffer=$buffer.$Response;
            }
        }
    ?>
        <?php
        echo "buffer1: ".$buffer; ?>
        <br><br>
        <?php
        $buffer=Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
        $buffer=explode("\r\n",$buffer);
        echo '<pre>';  print_r($buffer); echo '</pre>';
        
        
        for($a=1;$a<count($buffer)-1;$a++) {
        
		$data=Parse_Data($buffer[$a],"<Row>","</Row>");
		$PIN=Parse_Data($data,"<PIN>","</PIN>");
        $DateTime=Parse_Data($data,"<DateTime>","</DateTime>");
		$Verified=Parse_Data($data,"<Verified>","</Verified>");
		$Status=Parse_Data($data,"<Status>","</Status>");

        ?>
       <tr align="center">
		    <td><?=$PIN?></td>
            <td><?=$DateTime?></td>
		    <td><?=$Verified?></td>
		    <td><?=$Status?></td>
	    </tr>
    <?php } ?>
</table>
<br><br>
<form method="POST" action="">
    <table>
        <tr>
            <td>User id</td>
            <td><input type="text" name="pin" readonly value=<?php echo $PIN ?>></td>
        </tr>
        <tr>
            <td>Date Time</td>
            <td><input type="text" name="datetime" readonly value=<?php echo $DateTime?>></td>
        </tr>
        <tr>
            <td>Verified</td>
            <td><input type="text" name="verified" readonly value=<?php echo $Verified?>></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><input type="text" name="status" readonly value=<?php echo $Status?>></td>
        </tr>
    </table>
</form>
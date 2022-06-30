<?php 
    include '../connect/connect_device.php';
    include '../library_soap/lib_soap_x100c.php';
?>
<center>
    <?php 
        if($connect) {
            //choice soap request from library
            $Soap_val =  "<GetAllUserInfo>
                            <ArgComKey Xsi:type=\"xsd:integer\">".$Key."</ArgComKey>
                        </GetAllUserInfo>";
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
         
        $buffer=Parse_Data($buffer,"<GetAllUserInfoResponse>","</GetAllUserInfoResponse>");
        $buffer=explode("\r\n",$buffer);
        

        for ($i = 1; $i < count($buffer)-1; $i++) {
            $data=Parse_Data($buffer[$i],"<Row>","</Row>");
            $PIN=Parse_Data($data,"<PIN>","</PIN>");
            $Name=Parse_Data($data,"<Name>","</Name>");
            $Password=Parse_Data($data,"<Password>","</Password>");
            $Group=Parse_Data($data,"<Group>","</Gro>");
            $Privilege=Parse_Data($data,"<Privilege>","</Privilege>");
            $Card=Parse_Data($data,"<Card>","</Card>");
            $PIN2=Parse_Data($data,"<PIN2>","</PIN2>");
            $TZ1=Parse_Data($data,"<TZ1>","</TZ1>");
            $TZ2=Parse_Data($data,"<TZ2>","</TZ2>");
            $TZ3=Parse_Data($data,"<TZ3>","</TZ3>");
        }
       
        
       
    ?>


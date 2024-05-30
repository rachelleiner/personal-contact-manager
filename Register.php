
<?php

	$inData = getRequestInfo();
 	
    $R_ID = $inData["R_ID"];
	$R_FirstName = $inData["R_FirstName"];
	$R_LastName = $inData["R_LastName"];
  $R_username = $inData["R_username"];
  $R_password = $inData["R_password"];
  $ID = 0;
  
  $conn = new mysqli("localhost", "Access-20", "WeLoveCOP4331-20", "contactmanager"); 
  
	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}

	else
    {
     $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Login, Password) VALUES (?,?,?,?)");
            
     if (!$stmt) {
        returnWithError("Prepare failed: " . $conn->error);
        }
     else{       
       $stmt->bind_param("ssss", $R_FirstName, $R_LastName, $R_username, $R_password);
     
    
		else
		{
			returnWithError("No Records Found, Try Again!");
		}
			$stmt->execute();
      
   $result = $stmt->get_result();

		  if( $row = $result->fetch_assoc()  )
    {
			returnWithInfo( $row['FirstName'], $row['LastName'], $row['ID'] );
			
		}
			$stmt->close();
			$conn->close();

    }

    function getRequestInfo()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    function sendResultInfoAsJson($obj)
    {
        header('Content-type: application/json');
        echo $obj;
    }

    function returnWithError($err)
    {
        $retValue = '{"ID":0, "FirstName":"", "LastName":"", "error":"' . $err . '"}';
        sendResultInfoAsJson($retValue);
    }
    function returnWithInfo( $FirstName, $LastName, $ID )
	{
		$retValue = '{"ID":' . $ID . ',"FirstName":"' . $R_FirstName . '","LastName":"' . $R_LastName . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}

	
?>

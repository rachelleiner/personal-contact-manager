

<?php

	$inData = getRequestInfo();
 	
    	$R_ID = $inData["R_ID"];
	$R_FirstName = $inData["R_FirstName"];
	$R_LastName = $inData["R_LastName"];
  	$R_username = $inData["R_username"];
  	$R_password = $inData["R_password"];
  
  $conn = new mysqli("localhost", "Access-20", "WeLoveCOP4331-20", "contactmanager"); 
  
	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}

	else
    {
        $stmt = $conn->prepare("INSERT INTO Users (R_FirstName,R_LastName,R_username,R_password) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss", $R_FirstName, $R_LastName, $R_username, $R_password);
        
        $stmt->execute();
        
        $stmt->close();
        $conn->close();

        http_response_code(200);
        returnWithError("");

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
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	
?>

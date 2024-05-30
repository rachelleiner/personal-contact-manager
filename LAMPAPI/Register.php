<?php

	$inData = getRequestInfo();
 	
 	$ID = $inData["R_ID"];
  $firstName = $inData["R_FirstName"];
  $lastName = $inData["R_LastName"];
  $username = $inData["R_username"];
  $password =  $inData["R_password"];
  
  returnWithError(""); 
  $conn = new mysqli("localhost", "Access-20", "WeLoveCOP4331-20", "contactmanager"); 
  
	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
else{
  $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Login, Password) VALUES(?,?,?,?)");
  
  $stmt->bind_param("ssss", $firstName, $lastName, $username, $password);

  $stmt->execute();
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
		$retValue = '{"error": oh no"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	
?>

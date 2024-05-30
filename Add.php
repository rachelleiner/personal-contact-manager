<?php
	$inData = getRequestInfo();
	
	$A_FirstName = $inData["A_FirstName"];
	$A_LastName = $inData["A_LastName"];
  	$A_PhoneNumber = $inData["A_PhoneNumber"];
  	$A_Email = $inData["Email"];
  	$ID = $inData["ID"];
 
	$conn = new mysqli("localhost", "Access-20", "WeLoveCOP4331-20", "contactmanager"); 

	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 

	else
	{
		if($A_FirstName == "")
		{
			returnWithError("Please provide a name");
		}

		else if($A_Phone == "")
		{
			returnWithError("Please provide a phone number");
		}

		$stmt = $conn->prepare("INSERT into Contacts (FirstName,LastName,Email,Phone,ID) VALUES(?,?,?,?,?)");
		$stmt->bind_param("ssssi",$A_FirstName,$A_LastName,$A_Email,$A_Phone,$ID);
		$stmt->execute();


		$stmt->close();
		$conn->close();
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $FirstName, $LastName, $ID )
	{
		$retValue = '{"ID":' . $ID . ',"FirstName":"' . $FirstName . '","LastName":"' . $LastName . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
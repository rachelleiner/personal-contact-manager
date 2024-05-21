<?php
	$inData = getRequestInfo();
	
	$FirstName = $inData["FirstName"];
	$LastName = $inData["LastName"];
	$Email = $inData["Email"];
	$Phone = $inData["Phone"];
	$ID = $inData["ID"];

	$conn = new mysqli("contactmanager.xyz", "Access-20", "WeLoveCOP4331-20", "contactmanager"); 

	if($FirstName == "" && $LastName == "")
	{
		returnWithError("Please provide a name");
	}

	else if($Email == "")
	{
		returnWithError("Please provide an email");
	}

	else if($Phone == "")
	{
		returnWithError("Please provide a phone number");
	}

	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 

	else
	{
		$stmt = $conn->prepare("INSERT into Contacts (FirstName,LastName,Email,Phone,ID) VALUES(?,?,?,?,?)");
		$stmt->bind_param("ssssi", $FirstName, $LastName,$Email,$Phone,$ID);
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
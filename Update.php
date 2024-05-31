<?php
	$inData = getRequestInfo();

	$FirstName = $inData["UFirstName"];
	$LastName = $inData["ULastName"];
	$Email = $inData["UEmail"];
	$Phone = $inData["UPhone"];
	$updateID = $inData["UID"];

	$conn = new mysqli("localhost", "Access-20", "WeLoveCOP4331-20", "contactmanager");
	
	if($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 

	else
	{
		$stmt = $conn->prepare("UPDATE Contacts SET UFirstName=?, ULastName=?, UEmail=?, UPhone=?  WHERE ID = ?");
		
		$stmt->bind_param("ssssi", $FirstName, $LastName, $Email, $Phone, $updateID);
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
		$retValue = '{"ID":0,"FirstName":"","LastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>

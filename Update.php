<?php
	$inData = getRequestInfo();

	$FirstName = $inData["FirstName"];
	$LastName = $inData["LastName"];
	$Email = $inData["Email"];
	$Phone = $inData["Phone"];
	$ID = $inData["ID"];

	$conn = new mysqli("contactmanager.xyz", "Access-20", "WeLoveCOP4331-20", "contactmanager");
	if($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("SELECT FirstName, LastName, Email, Phone FROM Contacts WHERE ID = ?");
		$stmt->bind_param("i", $ID);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$stmt->close();

		$fieldsToUpdate = [];
		if($FirstName !== $row['FirstName']) {
			$fieldsToUpdate[] = 'FirstName = ?';
		}
		if($LastName !== $row['LastName']) {
			$fieldsToUpdate[] = 'LastName = ?';
		}
		if($Email !== $row['Email']) {
			$fieldsToUpdate[] = 'Email = ?';
		}
		if($Phone !== $row['Phone']) {
			$fieldsToUpdate[] = 'Phone = ?';
		}

		if(empty($fieldsToUpdate)) {
			returnWithInfo("No changes made to the contact.");
		}

		
		$sql = "UPDATE Contacts SET " . implode(', ', $fieldsToUpdate) . " WHERE ID = ?";
		$stmt = $conn->prepare($sql);
		$types = str_repeat('s', count($fieldsToUpdate)) . 'i';
		$stmt->bind_param($types, ...$inData);


		if($stmt->execute())
		{
			returnWithInfo("Contact updated successfully!");
		}
		else
		{
			returnWithError("No contact found with the given ID");
		}

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

	function returnWithInfo( $info )
	{
		$retValue = '{"error":"' . $info . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>
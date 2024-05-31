
<?php

$inData = getRequestInfo();
	
$FirstName = $inData["DFirstName"];
$LastName = $inData["DLastName"];
$Email = $inData["DEmail"];
$Phone = $inData["DPhone"];
$deleteID = $inData["DID"];

	$conn = new mysqli("localhost", "Access-20", "WeLoveCOP4331-20", "contactmanager"); 
	
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 

	else
	{
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE ID=?");
		$stmt->bind_param("i", $deleteID);
		$stmt->execute();
		
        if ($stmt->affected_rows > 0)
	    {
		returnWithError("Contact deleted successfully!");
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
	
?>

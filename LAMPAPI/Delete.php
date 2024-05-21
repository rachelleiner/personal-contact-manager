
<?php

$inData = getRequestInfo();
	
$FirstName = $inData["FirstName"];
$LastName = $inData["LastName"];
$Email = $inData["Email"];
$Phone = $inData["Phone"];
$ID = $inData["ID"];

	$conn = new mysqli("contactmanager.xyz", "Access-20", "WeLoveCOP4331-20", "contactmanager"); 
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 

	else
	{
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE ID=?");
		$stmt->bind_param("i", $inData["ID"]);
		$stmt->execute();
		
        if ($stmt->affected_rows > 0)
	    {
		returnWithSuccess("Contact deleted successfully!");
	    }
	    else
	    {
		returnWithError("No contact found with the given ID");
	    }

		$stmt->close();
		$conn->close();
		
		returnWithError($inData["ID"]);
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

    function returnWithInfo( $FirstName, $LastName, $ID )
	{
		$retValue = '{"ID":' . $ID . ',"FirstName":"' . $FirstName . '","LastName":"' . $LastName . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>

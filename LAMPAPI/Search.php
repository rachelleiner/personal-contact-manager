<?php
	$inData = getRequestInfo();

	$searchCount = 0;





	$conn = new mysqli("contactmanager.xyz", "Access-20", "WeLoveCOP4331-20", "contactmanager");
	if($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("SELECT * FROM Users WHERE Login = ?");
		$stmt->bind_param("s", $inData["Login"]);
		$stmt->execute();

		$result = $stmt->get_result();

		while($row = $result->fetch_assoc())
		{
			$searchCount++;
		}

		if( $searchCount == 0 )
		{
			returnWithError( "" );
		}
		else
		{
			returnWithError( "Username taken" );
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
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>

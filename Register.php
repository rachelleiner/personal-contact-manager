
<?php

	$inData = getRequestInfo();
	
	$FirstName = $inData["FirstName"];
	$LastName = $inData["LastName"];
    $Login = $inData["Login"];
    $Password = $inData["Password"];

	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331"); 	
	if( $conn->connect_error ) # If there's a connect error
	{
		returnWithError( $conn->connect_error );
	}
	else # Login procedure
	{
		$stmt = $conn->prepare("SELECT ID FROM Users WHERE Login=?");
		$stmt->bind_param("s", $inData["Login"]); 
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc()  ) # If this info is already present
		{
			returnWithError("This User already exists");
		}
		else # Info does not exist yet
		{
			$stmt = $conn->prepare("INSERT into Users (FirstName,LastName,Login,Password) VALUES(?,?,?,?)");
		    $stmt->bind_param("ssss", $firstName,$lastName,$login,$password);
		    $test = $stmt->execute();

            $stmt->close();
            $stmt->close();
		    
            if(test)
                returnWithError("working");
            else
            returnWithError("not working yet");
		}

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

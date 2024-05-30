
<?php

	$inData = getRequestInfo();
	
	$ID = 0;
	$FirstName = $inData["FirstName"];
	$LastName = $inData["LastName"];
    $Login = $inData["Login"];
    $Password = $inData["Password"];

	$conn = new mysqli("http://www.contactmanager.xyz", "Access-20", "WeLoveCOP4331-20", "contactmanager"); 	

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}

	else
    {
            $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Login, Password) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $FirstName, $LastName, $Login, $Password);

			$working = $stmt->execute();
			$stmt->close();
			$conn->close();

			if($working)
				returnWithError("working!");
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
        $retValue = '{ID":0, "FirstName":"", "LastName":"", "error":"' . $err . '"}';
        sendResultInfoAsJson($retValue);
    }

	
?>

/* Place your JavaScript in this file */
const urlBase = 'http://www.contactmanager.xyz/LAMPAPI';
const extension = 'php';

let userId = 0;
let firstName = "";
let lastName = "";

var currentIndex = 0;

function doLogin()
{
	userId = 0;
	firstName = "";
	lastName = "";
	
	let login = document.getElementById("loginName").value;
	let password = document.getElementById("loginPassword").value;
//	var hash = md5( password );
	
	document.getElementById("loginResult").innerHTML = "";

	let tmp = {login:login,password:password};
//	var tmp = {login:login,password:hash};
	let jsonPayload = JSON.stringify( tmp );
	
	let url = urlBase + '/Login.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				let jsonObject = JSON.parse( xhr.responseText );
				userId = jsonObject.ID;
        console.log(userId);
        console.log(login);
        console.log(jsonObject);
        
				if( userId < 1 )
				{		
					document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
					return;
				}
		
				firstName = jsonObject.FirstName;
				lastName = jsonObject.LastName;

				saveCookie();
	
	      window.location.href = "color.html";
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("loginResult").innerHTML = err.message;
	}

}

function doRegister()
{
    let RFirstName = document.getElementById("rFirstName").value;
    let RLastName = document.getElementById("rLastName").value;
    let RUsername = document.getElementById("rUsername").value;
    let RPassword = document.getElementById("rPassword").value;
    
    if (RFirstName == "" || RLastName == "" || RUsername == "" || RPassword == "")
		{
			document.getElementById("registerResult").innerHTML = "Please fill in all of the fields.";
			return;
		}

	let jsonPayload = JSON.stringify({RFirstName:RFirstName,RLastName:RLastName,RUsername:RUsername,RPassword:RPassword}); 
  	let url = urlBase + '/Register.' + extension;


    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
 	
	xhr.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			//JSON.parse( xhr.responseText );
      		document.getElementById("regResult").innerHTML = "User Added!";
			window.location.href="index.html";
		} 
  };
 
   xhr.send(jsonPayload);
   console.log("6");
}

function doAdd(){
	
    let AFirstName = document.getElementById("AFirstName").value;
    let ALastName = document.getElementById("ALastName").value;
    let AEmail = document.getElementById("AEmail").value;
    let APhone = document.getElementById("APhone").value;
    let userId = readCookie();
    
	if (AFirstName == "" || APhone == "") // User will not always know last name nor email
		{
			document.getElementById("contactAddResult").innerHTML = "Please fill out these required fields.";
			return;
		}

	document.getElementById("contactAddResult").innerHTML = "";

	let tmp = ({AEmail:AEmail,APhone:APhone,AFirstName:AFirstName,ALastName:ALastName,userId:userId});
	let jsonPayload = JSON.stringify( tmp );
	url = urlBase + '/Add.' + extension;
 
 
  let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	xhr.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)  
        {
            document.getElementById("contactAddResult").innerHTML = "Contact has been successfully added";
        }
    };
try{  
   xhr.send(jsonPayload);
 }
 catch(err)
	{
		document.getElementById("contactAddResult").innerHTML = err.message;
}
}



function saveCookie()
{
	let minutes = 20;
	let date = new Date();
	date.setTime(date.getTime()+(minutes*60*1000));	
	document.cookie = "FirstName=" + firstName + ",LastName=" + lastName + ",ID=" + userId + ";expires=" + date.toGMTString();
}

function readCookie()
{
	userId = -1;
	let data = document.cookie;
	let splits = data.split(",");
	for(var i = 0; i < splits.length; i++) 
	{
		let thisOne = splits[i].trim();
		let tokens = thisOne.split("=");
		if( tokens[0] == "FirstName" )
		{
			firstName = tokens[1];
		}
		else if( tokens[0] == "LastName" )
		{
			lastName = tokens[1];
		}
		else if( tokens[0] == "ID" )
		{
			userId = parseInt( tokens[1].trim() );
		}
	}
	
	if( userId < 0 )
	{
		window.location.href = "index.html";
	}
	else
	{
//		document.getElementById("userName").innerHTML = "Logged in as " + firstName + " " + lastName;
  //console.log("User ID:", userId);
        return userId;
	}
}

function doLogout()
{
	userId = 0;
	firstName = "";
	lastName = "";
	document.cookie = "firstName= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	window.location.href = "index.html";
}

function addPerson()
{
	let newColor = document.getElementById("colorText").value;
	document.getElementById("colorAddResult").innerHTML = "";

	let tmp = {color:newColor,userId:userId};
	let jsonPayload = JSON.stringify( tmp );

	let url = urlBase + '/AddColor.' + extension;
	
	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("colorAddResult").innerHTML = "Color has been added";
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("colorAddResult").innerHTML = err.message;
	}
	
}

function searchContacts()
{
	let userId = readCookie();
  	let search = document.getElementById("searchBar").value;
	document.getElementById("SearchResult").innerHTML = "";

	let tmp = ({search: search, userId: userId});
	let jsonPayload = JSON.stringify(tmp);

	let url = urlBase + '/SearchContacts.' + extension;

	let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
    try {
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                try {
                    let jsonObject = JSON.parse(xhr.responseText);
                    //document.getElementById("SearchResult").innerHTML = "Contact(s) has been retrieved";
                    
                    let resultsTable = "";
                    if (jsonObject.results !== undefined) {
                        for (let i = 0; i < jsonObject.results.length; i++) {
                            resultsTable += "<tr id='row-" + jsonObject.results[i].ID + "'>";
                            resultsTable += "<td>" + jsonObject.results[i].FirstName + "</td>";
                            resultsTable += "<td>" + jsonObject.results[i].LastName + "</td>";
                            resultsTable += "<td>" + jsonObject.results[i].Phone + "</td>";
                            resultsTable += "<td>" + jsonObject.results[i].Email + "</td>";
 
                            resultsTable += '<td>';
                            resultsTable += '<button onclick="doDelete(' + jsonObject.results[i].ID + ')">Delete</button>';
							resultsTable += '<button onclick="doUpdate(' + jsonObject.results[i].ID + ')">Update</button>';

                            resultsTable += '</td>';
                            
                            resultsTable += "</tr>";
                        }
                    } else {
                        document.getElementById("SearchResult").innerHTML = "No Contacts Found.";
                    }
                    
                    document.getElementById("tableBody").innerHTML = resultsTable;
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                    console.log("Response Text:", xhr.responseText);
                    document.getElementById("SearchResult").innerHTML = "An error occurred while retrieving contacts.";
                }
            }
        };
        xhr.send(jsonPayload);
    } catch (err) {
        document.getElementById("SearchResult").innerHTML = err.message;
    }
}
function doDelete(contactID) 
{
	console.log(contactID);
  let jsonPayload = JSON.stringify({contactID: contactID}); 
 
 
	let url = urlBase + '/Delete.' + extension;
	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
 
	xhr.onreadystatechange = function()
	{
	  if (this.readyState === XMLHttpRequest.DONE) {
           if (this.status === 200) {
               // Request was successful, handle response if needed
               console.log("Contact deleted successfully");
                let row = document.getElementById('row-' + contactId);
                if (row) {
                    row.parentNode.removeChild(row);
                }
           } else {
               // Request failed, handle error if needed
               console.error("Error deleting contact:", xhr.responseText);      
           }
        }
	};
	xhr.send(jsonPayload);
}

function doUpdate(contactID){

}


function openForm() {
        document.getElementById("popupForm").style.display = "block";
}
function closeForm() {
        document.getElementById("popupForm").style.display = "none";
}
function AddOpenForm() {
        document.getElementById("popupForm").style.display = "block";
}


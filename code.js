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

  var jsonPayload = '{"RUsername" : "' + RUsername + '", "RPassword" : "' + RPassword + '", "RFirstName" : "' + RFirstName + '", "RLastName" : "' + RLastName + '"}';
    let url = urlBase + '/Register.' + extension;


    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
 
	
	
	xhr.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			let jsonObject = JSON.parse( xhr.responseText );
			var test = jsonObject.error;
			console.log(test);
      document.getElementById("registerResult").innerHTML = "Contact Added!";
		} 
  };
 
 try{  
   xhr.send(jsonPayload);
   console.log("6");
 }
 catch(err)
	{
		document.getElementById("registerResult").innerHTML = err.message;
}
}

function doAdd(){
	
    let AFirstName = document.getElementById("AFirstName").value;
    let ALastName = document.getElementById("ALastName").value;
    let AEmail = document.getElementById("AEmail").value;
    let APhone = document.getElementById("APhone").value;
    let AID = 2;
    
	if (AFirstName == "" || APhone == "") // User will not always know last name nor email
		{
			document.getElementById("contactAddResult").innerHTML = "Please fill out these required fields.";
			return;
		}

	document.getElementById("contactAddResult").innerHTML = "";

	let tmp = {Email:AEmail,Phone:APhone,FirstName:AFirstName,LastName:ALastName,UserID:AID};
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
    xhr.send(jsonPayload);
}

function doDelete(index, deleteID) //edit later
{
	document.getElementById("contactEditResult[" + newIndex + "]").innerHTML = "";
	currentIndex = index;
	document.getElementById("contactEditResult[" + index + "]").innerHTML = "";
	var jsonPayload = '{"id" : ' + deleteID + '}';
	var url = urlBase + '/LAMPAPI/Delete.' + extension;
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	xhr.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			document.getElementById("contactEditResult[" + index + "]").innerHTML = "Contact has been deleted";
		}
	};
	xhr.send(jsonPayload);
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

function searchColor()
{
	let srch = document.getElementById("searchText").value;
	document.getElementById("colorSearchResult").innerHTML = "";
	
	let colorList = "";

	let tmp = {search:srch,userId:userId};
	let jsonPayload = JSON.stringify( tmp );

	let url = urlBase + '/SearchColors.' + extension;
	
	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("colorSearchResult").innerHTML = "Color(s) has been retrieved";
				let jsonObject = JSON.parse( xhr.responseText );
				
				for( let i=0; i<jsonObject.results.length; i++ )
				{
					colorList += jsonObject.results[i];
					if( i < jsonObject.results.length - 1 )
					{
						colorList += "<br />\r\n";
					}
				}
				
				document.getElementsByTagName("p")[0].innerHTML = colorList;
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("colorSearchResult").innerHTML = err.message;
	}
	
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
function filterTable() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchBar");
        filter = input.value.toLowerCase();
        table = document.getElementById("resultsTable");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            tr[i].style.display = "none";
            td = tr[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    }
                }
            }
        }
    }

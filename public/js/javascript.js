/*

This files does...

*/


// Function to communicate html with php via AJAX to retrieve info 
function ajax() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("ajax-test").innerHTML = this.responseText;
		}
	};
	
	xmlhttp.open("GET", "/weightedlive/ajax", true);
	xmlhttp.send();
}

// Call function projectsInfo() every 5 seconds to update projects status regularly
setInterval(ajax, 5000);
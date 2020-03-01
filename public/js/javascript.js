/*

This files does...

*/


// Function to communicate html with php via AJAX to retrieve info 
function ajax() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var resp = this.responseText;
			var jsonResp = JSON.parse(resp);
			console.log(jsonResp);

			document.getElementById("selected_id").innerHTML = jsonResp.id;
			
			if (jsonResp.type == 'tweet') {

				document.getElementById("img").innerHTML = '<img src="' + jsonResp.imgs[0] + '" width="100%">';

			} else if (jsonResp.type == 'web_upload') {

				document.getElementById("img").innerHTML = '<img src="uploadedImages/' + jsonResp.imgs[0] + '" width="100%">';

			}
		}
	};
	
	xmlhttp.open("GET", "/weightedlive/ajax", true);
	xmlhttp.send();
}

// Call function projectsInfo() every 5 seconds to update projects status regularly
setInterval(ajax, 5000);
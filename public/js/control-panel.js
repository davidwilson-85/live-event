/*

This files does...

*/

function showTab_editEvent() {
	document.getElementById('tab-editEvent').style.display='block';
	document.getElementById('tab-seeEventStats').style.display='none';
	document.getElementById('tab-moderateContent').style.display='none';
}

function showTab_seeEventStats() {
	document.getElementById('tab-editEvent').style.display='none';
	document.getElementById('tab-seeEventStats').style.display='block';
	document.getElementById('tab-moderateContent').style.display='none';
}

function showTab_moderateContent() {
	document.getElementById('tab-editEvent').style.display='none';
	document.getElementById('tab-seeEventStats').style.display='none';
	document.getElementById('tab-moderateContent').style.display='block';
}

window.onload = function() {

	document.getElementById("tab_selector_editEvent").onclick = showTab_editEvent;
	document.getElementById("tab_selector_seeEventStats").onclick = showTab_seeEventStats;
	document.getElementById("tab_selector_moderateContent").onclick = showTab_moderateContent;

}
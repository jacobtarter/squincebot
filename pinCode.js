var httpRequest;
httpRequest = new XMLHttpRequest();

function setPinMode() {
      var url = "pinoptions.php";
      var pinNum = encodeURIComponent(document.getElementById("pinNum").value);
      var pinMode = encodeURIComponent(document.getElementById("pinMode").value);
      httpRequest.open('POST', url);
      httpRequest.onreadystatechange = alertContents;
      httpRequest.send();
};
function alertContents() {
	if (httpRequest.readyState === XMLHttpRequest.DONE) {
		if(httpRequest.status === 200) {
		document.getElementById('pinModeForm').submit();
		} else {
		  alert('There was a problem');
		}
	}
	};

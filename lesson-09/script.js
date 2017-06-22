var yearformat;
var heightformat;

function spustit() {
	document.getElementById("main_button").setAttribute("disabled", "disabled");
	yearformat = document.getElementById("birth_year").getAttribute("data-format");
	heightformat = document.getElementById("height").getAttribute("data-format");
	document.getElementById("main_button").onclick = hlaska;
	document.getElementById("birth_year").oninput = kontrola;
	document.getElementById("height").oninput = kontrola;
}

function hlaska(){
	if ((document.getElementById("birth_year").value.match(yearformat)) && (document.getElementById("height").value.match(heightformat))){
	var jmeno = document.getElementById("name").value;
	var datum = document.getElementById("birth_year").value;
	var vyska = document.getElementById("height").value;
	alert("Zadali jste tyto údaje:" + "\nJméno: " + jmeno + "\nNarozen: " + datum + "\nVýška: " + vyska + " m");
	// alert(yearformat + "\n" + heightformat);
	}
	else{
		alert("CHYBA: Pole obsahují neplatnou hodnotu");
	}
}

function kontrola(){
	yearformat = document.getElementById("birth_year").getAttribute("data-format");
	heightformat = document.getElementById("height").getAttribute("data-format");

	if ((document.getElementById("birth_year").value.match(yearformat)) && (document.getElementById("height").value.match(heightformat))){
		document.getElementById("main_button").removeAttribute("disabled");
	}
	else {
		document.getElementById("main_button").setAttribute("disabled", "disabled");
	}
}	
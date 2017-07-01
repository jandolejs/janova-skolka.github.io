var yearformat;
var heightformat;

function spustit(){
	gid("main_button").setAttribute("disabled", "disabled");
	yearformat = gid("birth_year").getAttribute("data-format");
	heightformat = gid("height").getAttribute("data-format");
	gid("main_button").onclick = hlaska;
	gid("birth_year").oninput = kontrola;
	gid("height").oninput = kontrola;
}

function hlaska(){
	if ((gid("birth_year").value.match(yearformat)) && (gid("height").value.match(heightformat))){
	var jmeno = gid("name").value;
	var datum = gid("birth_year").value;
	var vyska = gid("height").value;
	alert("Zadali jste tyto údaje:" + "\nJméno: " + jmeno + "\nNarozen: " + datum + "\nVýška: " + vyska + " m");
	}
	else{
		alert("CHYBA: Pole obsahují neplatnou hodnotu");
	}
}

function kontrola(){
	yearformat = gid("birth_year").getAttribute("data-format");
	heightformat = gid("height").getAttribute("data-format");
	if ((gid("birth_year").value.match(yearformat)) && (gid("height").value.match(heightformat))){
		gid("main_button").removeAttribute("disabled");
	}
	else {
		gid("main_button").setAttribute("disabled", "disabled");
	}
}

function gid(id){
	return document.getElementById(id);
}
function spustit(){
	var button = document.getElementById("main_button");

	button.onclick = hlaska;
	document.getElementById("birth_year").oninput = kontrola;
	document.getElementById("height").oninput = kontrola;
	document.getElementById("name").oninput = kontrola;
	kontrola();
}

function hlaska(){
	var jmeno = document.getElementById("name").value;
	var datum = document.getElementById("birth_year").value;
	var vyska = document.getElementById("height").value;

	if(porovnat("name") && porovnat("birth_year") && porovnat("height")){
		alert("Zadali jste tyto údaje:" + "\nJméno: " + jmeno + "\nNarozen: " + datum + "\nVýška: " + vyska + " m");
	}
	else{
		alert("CHYBA: Pole obsahují neplatnou hodnotu");
	}
}

function kontrola(){
	var button = document.getElementById("main_button");

	if(porovnat("name") && porovnat("birth_year") && porovnat("height")){
		button.removeAttribute("disabled");
	}
	else{
		button.setAttribute("disabled", "disabled");
	}
}

function porovnat(jmenopole){
	var input = document.getElementById(jmenopole);
	var value = input.value;

	var requiredFormat = input.getAttribute("data-format");
	if(requiredFormat) {
		requiredFormat = ("^" + requiredFormat + "$");
	}

	var isEmpty = value.match(/^\s*$/);
	var isRequired = input.getAttribute("data-required") == "yes";
	var isValidFormat = requiredFormat ? value.match(requiredFormat) : true; // If format not defined => always valid

	if(isEmpty){
		if(isRequired){
			return false;
		}
		else{
			return true;
		}
	}
	if(isValidFormat){
		return true;
	}
	else{
		return false;
	}
}

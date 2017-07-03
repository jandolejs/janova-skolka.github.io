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
	var polename = document.getElementById(jmenopole);
	var polereq = polename.getAttribute("data-required");
	var poleformat = ((polename.getAttribute("data-format")));
	if(poleformat){
		var poleformat = ("^" + poleformat + "$");
	}

	if(polename.value.match(/^\s+$/)){
		if(polereq){
			if(polereq.match("yes")){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			return true;
		}
	}
	else if(polename.value > ""){
		if(polereq){
			if(polereq.match("yes")){
				if(poleformat){
					if(polename.value.match(poleformat)){
						return true;
					}
					else{
						return false;
					}
				}
				else{
					if(poleformat){
						if(polename.value.match(poleformat)){
							return true;
						}
						else{
							return false;
						}
					}
					else{
						return true;
					}
				}
			}
			else{
				if(poleformat){
					if(polename.value.match(poleformat)){
						return true;
					}
					else{
						return false;
					}
				}
			}
		}
		else{
			if(poleformat){
				if(polename.value.match(poleformat)){
					return true;
				}
				else{
					return false;
				}
			}
		}
	}
	else if(polename.value == ""){
		if(polereq){
			if(polereq.match("yes")){
				return false;
			}
			else{
				return true;
			}	
		}
		else{
			return true;
		}
	}
}

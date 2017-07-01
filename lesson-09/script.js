var yearformat;
var heightformat;
var pole1;
var pole2;
var pole3;

function spustit(){
	gid("main_button").setAttribute("disabled", "disabled");
	yearformat = gid("birth_year").getAttribute("data-format");
	heightformat = gid("height").getAttribute("data-format");
	gid("main_button").onclick = hlaska;
	gid("birth_year").oninput = kontrola;
	gid("height").oninput = kontrola;
	gid("name").oninput = kontrola;
	kontrola();
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
	nameformat = gid("height").getAttribute("data-format");


//HERE XXXXX

if(porovnat("name") == true && porovnat("birth_year") == true && porovnat("height") == true){
	gid("main_button").removeAttribute("disabled");
}
else{
	gid("main_button").setAttribute("disabled", "disabled");
}

//HEREXXXXX


}

function gid(id){
	return document.getElementById(id);
}


function porovnat(jmenopole){
	if(gid(jmenopole).value > ""){
		if(gid(jmenopole).getAttribute("data-required")){
			if(gid(jmenopole).getAttribute("data-required").match("yes")){
				if(gid(jmenopole).getAttribute("data-format")){
					if(gid(jmenopole).value.match(gid(jmenopole).getAttribute("data-format"))){
						return true;
					}
					else{
						return false;
					}
				}
				else{
					if(gid(jmenopole).getAttribute("data-format")){
						if(gid(jmenopole).value.match(getAttribute("data-format"))){
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
				if(gid(jmenopole).getAttribute("data-format")){
					if(gid(jmenopole).value.match(gid(jmenopole).getAttribute("data-format"))){
						return true;
					}
					else{
						return false;
					}
				}
				else{
					if(gid(jmenopole).getAttribute("data-format")){
						if(gid(jmenopole).value.match(getAttribute("data-format"))){
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
		}
	}
	if(gid(jmenopole).value == ""){
		if(gid(jmenopole).getAttribute("data-required")){
			if(gid(jmenopole).getAttribute("data-required").match("yes")){
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
function spustit() {
	document.getElementById("main_button").onclick = hlaska;
	document.getElementById("name").oninput = kontrola;
	document.getElementById("birth_year").oninput = kontrola;
	document.getElementById("height").oninput = kontrola;

}

function hlaska(){
	var jmeno = document.getElementById("name").value;
	var datum = document.getElementById("birth_year").value;
	var vyska = document.getElementById("height").value;
	alert("Zadali jste tyto údaje:" + "\nJméno: " + jmeno + "\nNarozen: " + datum + "\nVýška: " + vyska);
}

function kontrola(){

}
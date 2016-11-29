function hlaska() 
{
	if ((document.getElementById('number').value) == '') 
	{
		alert('CHYBA: Je nezbytné nejprve vyplnit text');
	}

	else if ((document.getElementById('number').value.match(/^\d+$/))) 
	{
		alert('Zvolili jste si číslo: ' + document.getElementById('number').value);
	}

	else alert('CHYBA: zadali jste něco jiného, než číslo');
}

function spustit() 
{
	document.getElementById("main_button").setAttribute("disabled", "disabled");
	document.getElementById("number").onkeyup = kontrola;
}

function kontrola()
{
	if (document.getElementById("number").value.match(/^\d+$/))
	{
		document.getElementById("main_button").removeAttribute("disabled");
	}
	else document.getElementById("main_button").setAttribute("disabled", "disabled");
}

function NovoPitanje ()
{
	odgovoreno=false;
	$("#odgovorabcd").empty();
	$(".popup").hide();
	$(".odgovor").hide();
	$("#txtOdgovor").val("");
	$('#txtOdgovor').css("background-color","");
	$.ajax(
	{
		url: "get_question.php",
		type: "GET",
		dataType : "json",
		success: function( json ) {
			$( "#pitanje" ).html( json.tekst );
			if (json.vrsta==1){
				$("#odgovortext").fadeIn('fast', function() {
				$("#txtOdgovor").focus();
				tocni_odgovori=[];
				for(var i in json.odgovori) {
					if(json.odgovori.hasOwnProperty(i) && !isNaN(+i)) {
					tocni_odgovori.push(json.odgovori[i]);
				}
}
				});
			}else{
				pripremiABCD(json);
				$("#odgovorabcd").fadeIn();
				console.log("ready!");
			}
		},
	}
	);
}

function pripremiABCD(data)
{
	tocan_odgovor=data.tocan;
	var odgovori=[];
	for(var i in data.odgovori) {
		if(data.odgovori.hasOwnProperty(i) && !isNaN(+i)) {
		odgovori[i]=data.odgovori[i];
		}
	}
	
	for (var i in odgovori)
	{
		console.log(odgovori[i]);
		
		var button=$("<p>",
		{
			html: odgovori[i],
			"class": "btnOdg",
			onclick: "CheckABCDodgovor(this)"
		}
		);
		button.data("id",i);
		$("#odgovorabcd").append(button);
	}	
	
	
}

function OdabirPitanja ()
{
	$ ( '#tocno' ).fadeIn();
}

function CheckTekstOdgovora(giveup=false)
{
	if (odgovoreno) {NovoPitanje(); return;}
	for (var i=0;i<tocni_odgovori.length;i++)
	{
		if (tocni_odgovori[i]==$("input[id=txtOdgovor]").val()){
			$('#txtOdgovor').css("background-color","green");
			//$('#txtOdgovor').attr('disabled','disabled');
			$ ( '#tocno' ).fadeIn();
			odgovoreno=true;
		}
	}
	if (giveup)
	{
		odgovoreno=true;
		$('#txtOdgovor').css("background-color","red");
		$ ( '#krivo' ).fadeIn();
	}
}

function CheckABCDodgovor(ovo)
{
	if (odgovoreno) {NovoPitanje(); return;}
	odgovoreno=true;
	if ( $(ovo).data("id")==tocan_odgovor)
	{
		$(ovo).css("background-color","green");
		$ ( '#tocno' ).fadeIn();
	}
	else
	{
		$(ovo).css("background-color","red");
		$ ( '#krivo' ).fadeIn();
	}

}

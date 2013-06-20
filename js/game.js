/* Početni ekran i setup opcija */

function StartGame()
{
	gamemode="FFA";
	level=new Array(true,true,true);
	catlist=new Array();
	$("#startgame").fadeIn();
}

/* Funkcije za odabir opcija botunima */

function setMode(b)
{
	var mode=$(b).attr("id");

	if (mode=="CHA"){
		gamemode="CHA";
	}
	else if (mode=="FFA"){
		gamemode="FFA";
	}
	$('#FFA').css("background-color",(gamemode=="FFA")?"#222222":"#275f88");
	$('#CHA').css("background-color",(gamemode=="CHA")?"#222222":"#275f88");
}

function setLevel(b)
{
		switch($(b).attr("id"))
		{
			case "easy":
				level[0]=!level[0];
				break;
			case "med":
				level[1]=!level[1];
				break;
			case "hard":
				level[2]=!level[2];
				break;
		}
		$('#easy').css("background-color",level[0]?"#222222":"#275f88");
		$ ('#med').css("background-color",level[1]?"#222222":"#275f88");
		$('#hard').css("background-color",level[2]?"#222222":"#275f88");
}

/* Prikaz kategorija */

function Kategorije()
{
	$('#window_kategorija').empty();
	$.ajax(
	{
		url: 'get_tlc.php',
		type: 'GET',
		dataType: 'json',
		success: function(json){
			for(var i in json) {
				if(json.hasOwnProperty(i) && !isNaN(+i)) {
					$('#window_kategorija').append('<input type="checkbox" value="'+i+'" onclick=KatCheck(this) /> '+json[i]+' &nbsp;');
				}
		}
		$('#window_kategorija').append('<p class="right"><a href="#" onclick="KatClose()">Close</a></p>');
		$('#window_kategorija').fadeIn();
	}
	}
	);
}

function KatCheck(b)
{	
	if ($(b).is(':checked'))
	{
		catlist.push($(b).val());
	}else{
		catlist.splice(catlist.indexOf($(b).val()),1);
	}
}

function KatClose()
{
	$('#window_kategorija').fadeOut();
	$('#window_kategorija').empty();
}

/* Izvlači iz baze novo pitanje */

function NovoPitanje ()
{
	$(".gamescreen").hide();
	odgovoreno=false;
	$("#odgovorabcd").empty();
	$(".popup").hide();
	$(".odgovor").hide();
	$("#txtOdgovor").val("");
	$('#txtOdgovor').css("background-color","");
	$('#kategorija').empty();
	$.ajax(
	{
		url: "get_question.php",
		type: "GET",
		dataType : "json",
		data: {
			easy: level[0],
			med: level[1],
			hard: level[2],
			kategorije: catlist
		},
		success: function( json ) {
			$( "#pitanje" ).html( json.tekst );
			$('#kategorija').html(json.kategorija);
			$('#kategorija').append(" "+json.bodovi+" points");
			id_pitanja=json.id;
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
			}
		},
	}
	);
}

/* Postavlja tipke s odgovorima */

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

/* Provjera točnog odgovora kod unosa */

function CheckTekstOdgovora(giveup=false)
{
	if (odgovoreno) {NovoPitanje(); return;}
	for (var i=0;i<tocni_odgovori.length;i++)
	{
		if (tocni_odgovori[i].toLowerCase()==$("input[id=txtOdgovor]").val().toLowerCase()){
			$('#txtOdgovor').css("background-color","#AFFFAF");
			ReportOdgovor(true);
			$ ( '#tocno' ).fadeIn();
			odgovoreno=true;
		}
	}
	if (giveup)
	{
		odgovoreno=true;
		ReportOdgovor(false);
		$('#txtOdgovor').css("background-color","#FF9393");
		$ ( '#krivo' ).fadeIn();
	}
}

/* Provjera točnog odgovora kod multiple choice */

function CheckABCDodgovor(ovo)
{
	if (odgovoreno) {NovoPitanje(); return;}
	odgovoreno=true;
	if ( $(ovo).data("id")==tocan_odgovor)
	{
		ReportOdgovor(true);
		$(ovo).css("background-color","#AFFFAF");
		$ ( '#tocno' ).fadeIn();
	}
	else
	{
		ReportOdgovor(false);
		$(ovo).css("background-color","#FF9393");
		$ ( '#krivo' ).fadeIn();
	}

}

function ReportOdgovor(tocno)
{
	$.ajax({
		url: "odgovor.php",
		type: "POST",
		data:
		{
			id:id_pitanja,
			odgovor: tocno,
			mode: gamemode
		}
		});
}

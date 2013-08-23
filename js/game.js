/* Početni ekran i setup opcija */

var pitanjeTimeout;
var timerInterval;

function StartGame()
{
	TimerStop(timerInterval);
	$('#timer').empty();
	countdownTime=60; // vrijeme trajanja
	trenscore=0;
	CHAstart=0;
	tocniOdgovori=0;
	brojPitanja=0;
	gamemode="FFA";	
	level=new Array(true,false,false);
	catlist=new Array();
	$("#startgame").fadeIn();
	$("#trenscore").html('0');
	$("#total").load('myscore.php');
	$('#endgame').hide();
	$('#kategorija').hide();
	$('#pitanje').hide();
	$('#odgovorabcd').hide();
	$('#odgovortext').hide();
	$('#menu_btn').attr('disabled','disabled');
	setMode(false);
	setLevel(false);
}

/* Funkcije za odabir opcija botunima */

function setMode(b)
{
	if (b){
		var mode=$(b).attr("id");

		if (mode=="CHA"){
			gamemode="CHA";
		}
		else if (mode=="FFA"){
			gamemode="FFA";
		}
	}

	if (gamemode=="FFA") {
		$('#FFA').removeClass('btn-default').addClass('btn-primary');
		$('#CHA').removeClass('btn-primary').addClass('btn-default');
	} else if (gamemode=="CHA") {
		$('#CHA').removeClass('btn-default').addClass('btn-primary');
		$('#FFA').removeClass('btn-primary').addClass('btn-default');
	}
}

function setLevel(b)
{
	if (b){
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
	}

	if (level[0]) {
		$('#easy').removeClass('btn-default').addClass('btn-info');
	} else {
		$('#easy').removeClass('btn-info').addClass('btn-default');
	}

	if (level[1]) {
		$('#med').removeClass('btn-default').addClass('btn-warning');
	} else {
		$('#med').removeClass('btn-warning').addClass('btn-default');
	}

	if (level[2]) {
		$('#hard').removeClass('btn-default').addClass('btn-danger');
	} else {
		$('#hard').removeClass('btn-danger').addClass('btn-default');
	}
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
					$('#window_kategorija').append('<label class="checkbox-inline"><input type="checkbox" id="inlineCheckbox1" value="'+i+'" onclick=KatCheck(this)>'+json[i]+'</label>');
				}
			}
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

/* Izvlači iz baze novo pitanje */

function NovoPitanje ()
{
	$('#menu_btn').removeAttr('disabled');
	$(".gamescreen").hide();
	odgovoreno=false;
	$("#odgovorabcd").empty();
	$(".odgovor").hide();
	$("#txtOdgovor").val("");
	$('#txtOdgovor').css("background-color","");
	$('#kategorija').css('margin-bottom','20px');
	$('#kategorija').empty();
	$('#kategorija').fadeIn();
	$('#pitanje').fadeIn();

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
			$('#kategorija').append(" <span class='badge'>"+json.bodovi+"</span> points");
			id_pitanja=json.id;
			bodovi_pitanja=parseInt(json.bodovi);
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
	brojPitanja++;
	if (gamemode=='CHA' && CHAstart=='0') {
		CHAstart=1;
		TimerStart();
	}
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
		
		var button=$("<button>",
		{
			html: odgovori[i],
			"class": "btn btn-default btn-block",
			onclick: "CheckABCDodgovor(this)"
		}
		);
		button.data("id",i);
		$("#odgovorabcd").append(button);
	}	
}

/* Provjera točnog odgovora kod unosa */

function CheckTekstOdgovora(giveup)
{
	if (odgovoreno) {return;}
	for (var i=0;i<tocni_odgovori.length;i++)
	{
		if (tocni_odgovori[i].toLowerCase()==$("input[id=txtOdgovor]").val().toLowerCase()){
			$('#txtOdgovor').css("background-color","rgb(92, 184, 92)"); // TO-DO sredit boje
			ReportOdgovor(true);
			odgovoreno=true;
			tocniOdgovori++;
			NovoPitanjeTimeout();
		}
	}
	if (giveup)
	{
		odgovoreno=true;
		ReportOdgovor(false);
		$('#txtOdgovor').css("background-color","rgb(217, 83, 79)"); // TO-DO sredit boje
		NovoPitanjeTimeout();
	}
}

/* Provjera točnog odgovora kod multiple choice */

function CheckABCDodgovor(ovo)
{
	if (odgovoreno) {return;}
	odgovoreno=true;
	if ( $(ovo).data("id")==tocan_odgovor)
	{
		ReportOdgovor(true);
		tocniOdgovori++;
		$(ovo).removeClass('btn-default').addClass('btn-success');
		NovoPitanjeTimeout();
	}
	else
	{
		ReportOdgovor(false);
		$(ovo).removeClass('btn-default').addClass('btn-danger');
		NovoPitanjeTimeout();
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
	if (tocno)trenscore+=bodovi_pitanja;
	$('#trenscore').html(trenscore);
	$('#total').load('myscore.php');
}

function NovoPitanjeTimeout() {
	pitanjeTimeout=setTimeout(function(){
		NovoPitanje();
	}, 2000);
}

function TimeoutStop(timeoutVar) {
	clearTimeout(timeoutVar);
}

function TimerStart() {
	timerInterval=setInterval(function(){
		countdownTime--;
		$('#timer').html('<pre>Time: <strong>'+countdownTime+'</strong> sec</pre>');
		if (countdownTime==0) {
			$('#modal_title').html('Game Over');
			$('#window_kategorija').html('You answered correctly '+tocniOdgovori+' out of '+brojPitanja+' questions.<br>Success rate is '+Math.round((tocniOdgovori/brojPitanja)*100*10)/10+'%.');
			$('#myModal').modal('show');
			TimeoutStop(pitanjeTimeout);
			StartGame();
		}
	}, 1000);
}

function TimerStop(timerVar) {
	clearInterval(timerVar);
}
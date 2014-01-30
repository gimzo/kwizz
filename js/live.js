/* Stvari vezane za live igru */


//fancy animacije i brojanje vremena
var pitanjeTimeout;
var timerInterval;

var webSocket;

var answerable; // blokiranje tipki kad istekne vrijeme

/* helper funkcije za komunikaciju sa serverom */

function receive (e) {
   console.log(e.data); //TODO: remove
   stuff=JSON.parse(e.data)
   switch(stuff.tip) {
      case "opponent":
         console.log("opponent je "+stuff.ime); //TODO: remove
         break;
      case("odgovor"):
         to=stuff.tocno?"correctly!":"incorrectly!";
         $("#drugi_odgovor").html(stuff.ime+" has answered "+to);
         TimerStart();
         break;
      case("kraj"):
         GameOver(stuff);
         break;
      case("broj"):
         $("#broj_pitanja").html("Question " + stuff.sad+ " / " + stuff.total);
         break;
      default:
         console.log("ovo je default"); //TODO: remove
         NovoPitanjeTimeout(stuff);
   }
}


function error() {
   $('#endgame').hide();
	$('#kategorija').hide();
	$('#pitanje').hide();
	$('#odgovorabcd').hide();
	$('#odgovortext').hide();
	$("#join").hide();
   $("#buttonmsg").html("<h4>Connection error</h4><h5>Real time game may be offline</h5>");
}


function connect() {
   webSocket=new WebSocket("ws://"+window.location.hostname+":9000");
   webSocket.onmessage=receive;
   webSocket.onerror=error;
   webSocket.onopen=SetGame;
}


/* Početni ekran i setup opcija */

function SetGame() {
   answerable=false;
	TimerStop(timerInterval);
	$('#timer').empty();
	trenscore=0;
	tocniOdgovori=0;
	brojPitanja=0;
	$("#startgame").fadeIn();
	$("#trenscore").html('0');
	$("#total").load('myscore.php');
	$('#endgame').hide();
	$('#kategorija').hide();
	$('#pitanje').hide();
	$('#odgovorabcd').hide();
	$('#odgovortext').hide();
	$('#menu_btn').attr('disabled','disabled');
}


function Lobby() {
   webSocket.send("U"+username);
   $("#join").hide();
   $("#buttonmsg").html("<p class='lead text-center'>Waiting for other player...</p>");
}


/* Prima sa servera novo pitanje */

function NovoPitanje (json) {
   TimerStop(timerInterval);
   $('#timer').empty();
   countdownTime=5; // vrijeme trajanja
   $("#report").html("");
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
   $("#pitanje").html( json.tekst );
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
		})
	}else{
		pripremiABCD(json);
		$("#odgovorabcd").fadeIn();
	}
	brojPitanja++;
	answerable=true;
}


/* Postavlja tipke s odgovorima */

function pripremiABCD (data) {
	tocan_odgovor=data.tocan;
	var odgovori=[];
	for(var i in data.odgovori) {
		if(data.odgovori.hasOwnProperty(i) && !isNaN(+i)) {
			odgovori[i]=data.odgovori[i];
		}
	}
console.log(odgovori);
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

function CheckTekstOdgovora (giveup) {
   if (!answerable) { return;}
	if (odgovoreno) {return;}
	for (var i=0;i<tocni_odgovori.length;i++)
	{
		if (tocni_odgovori[i].toLowerCase()==$("input[id=txtOdgovor]").val().toLowerCase()){
			$('#txtOdgovor').css("background-color","rgb(92, 184, 92)"); // TO-DO sredit boje
			ReportOdgovor(true);
			odgovoreno=true;
			tocniOdgovori++;
			//NovoPitanjeTimeout();
		}
	}
	if (giveup)
	{
		odgovoreno=true;
		ReportOdgovor(false);
		$('#txtOdgovor').css("background-color","rgb(217, 83, 79)"); // TO-DO sredit boje
		//NovoPitanjeTimeout();
	}
}


/* Provjera točnog odgovora kod multiple choice */

function CheckABCDodgovor (ovo) {
   if (!answerable) {return;}
	TimerStop(timerInterval);
	$('#timer').empty();
	if (odgovoreno) {return;}
	odgovoreno=true;
	if ( $(ovo).data("id")==tocan_odgovor)
	{
		ReportOdgovor(true);
		tocniOdgovori++;
		$(ovo).removeClass('btn-default').addClass('btn-success');
		//NovoPitanjeTimeout();
	}
	else
	{
		ReportOdgovor(false);
		$(ovo).removeClass('btn-default').addClass('btn-danger');
		//NovoPitanjeTimeout();
	}
}


function ReportOdgovor (tocno) {
   answerable=false;
	TimerStop(timerInterval);
	$('#timer').empty();
   webSocket.send(tocno?"T":"N");
	if (tocno)trenscore+=bodovi_pitanja;
	$('#trenscore').html(trenscore);
	$('#total').load('myscore.php');
}


function NovoPitanjeTimeout (json) {
	pitanjeTimeout=setTimeout(function()
	{
	   NovoPitanje(json)
	}, 1000);
}


function TimeoutStop (timeoutVar) {
	clearTimeout(timeoutVar);
}


function TimerStart() {
	timerInterval=setInterval(function(){
		countdownTime--;
		$('#timer').html('<pre>Time: <strong>'+countdownTime+'</strong> sec</pre>');
		if (countdownTime==0) {
		   ReportOdgovor(false);
			TimeoutStop(pitanjeTimeout);
			TimerStop(timerInterval);
	      $('#timer').empty();
		}
	}, 1000);
}


function TimerStop (timerVar) {
	clearInterval(timerVar);
}


function GameOver (stuff) {
	TimerStop(timerInterval);
	$('#timer').empty();
	$('#broj_pitanja').hide();
	$('#drugi_odgovor').hide();
   endMsg="<p class='lead text-center'>Round complete</p>";
   if (stuff.broken) {
      endMsg+="<p class='lead text-center'>"+stuff.broken+" has left the game</p>";
   }
   TimerStop(timerInterval);
	$('#timer').empty();
   $('#endgame').hide();
	$('#kategorija').hide();
	$('#pitanje').hide();
	$('#odgovorabcd').hide();
	$('#odgovortext').hide();
	if (stuff.s1>stuff.s2) {
	   endMsg+="<p class='lead text-center'>"+stuff.p1+" Won this round!</p>";
	   endMsg+="<p class='lead text-center'>"+stuff.p1+ " : "+stuff.s1+"</p><p class='lead text-center'>"+stuff.p2+ " : "+stuff.s2+"</p>";
	}else if (stuff.s2>stuff.s1) {
	   endMsg+="<p class='lead text-center'>"+stuff.p2+" Won this round!</p>";
	   endMsg+="<p class='lead text-center'>"+stuff.p2+ " : "+stuff.s2+"</p><p class='lead text-center'>"+stuff.p1+ " : "+stuff.s1+"</p>";
	}else {
	   endMsg+="<p class='lead text-center'>TIED!</p>";
	   endMsg+="<p class='lead text-center'>"+stuff.p1+ " : "+stuff.s1+"</p><p class='lead text-center'>"+stuff.p2+ " : "+stuff.s2+"</p>";
	}
   $("#rezultat").html(endMsg);
   $("#rezultat").fadeIn();
   webSocket.close();
}
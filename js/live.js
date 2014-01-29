/* Stvari vezane za live igru */
/* Početni ekran i setup opcija */

var pitanjeTimeout;
var timerInterval;
var webSocket

var answerable;
function receive(e) {
   console.log(e.data);
   stuff=JSON.parse(e.data)
   switch(stuff.tip) {
      case "opponent":
         console.log("opponent je "+stuff.ime);
         break;
      case("odgovor"):
         to=stuff.tocno?"tocno":"krivo";
         $("#report").html(stuff.ime+" je "+to+" odgovorio!");
         TimerStart();
         break;
      case("kraj"):
         GameOver(stuff);
         break;
      case("broj"):
         $("#broj_pitanja").html("Pitanje " + stuff.sad+ " / " + stuff.total);
         break;
      default:
         console.log("ovo je default");
         NovoPitanjeTimeout(stuff);
   }
}
function error() {
   $(".gamescreen").hide();
   $('#endgame').hide();
	$('#kategorija').hide();
	$('#pitanje').hide();
	$('#odgovorabcd').hide();
	$('#odgovortext').hide();
	alert("Connection error - firewall problem ili live igra trenutno nije aktivna");
}

function connect() {
   webSocket=new WebSocket("ws://"+window.location.hostname+":9000");
   webSocket.onmessage=receive;
   webSocket.onerror=error;
   webSocket.onopen=SetGame;
}

function SetGame()
{
   answerable=false;
	TimerStop(timerInterval);
	$('#timer').empty();
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
}

/* Funkcije za odabir opcija botunima */

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

function Lobby ()
{
   webSocket.send("U"+username);
   $("#join").hide();
   $("#buttonmsg").html("<h4>Waiting for other player...</h4>");
}

/* Izvlači iz baze novo pitanje */

function NovoPitanje (json)
{
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

function CheckABCDodgovor(ovo)
{
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

function ReportOdgovor(tocno)
{
   answerable=false;
	TimerStop(timerInterval);
	$('#timer').empty();
   
   webSocket.send(tocno?"T":"N");
	if (tocno)trenscore+=bodovi_pitanja;
	$('#trenscore').html(trenscore);
	$('#total').load('myscore.php');
}

function NovoPitanjeTimeout(json) {
	pitanjeTimeout=setTimeout(function()
	{
	   NovoPitanje(json)
	}, 1000);
}

function TimeoutStop(timeoutVar) {
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

function TimerStop(timerVar) {
	clearInterval(timerVar);
}

function GameOver(stuff)
{
	TimerStop(timerInterval);
	$('#timer').empty();
	$('#broj_pitanja').hide();
   endMsg="<h2>Round complete</h2>";
   if (stuff.broken) {
      endMsg+="<h3>"+stuff.broken+" has left the game</h3>";
   }
   TimerStop(timerInterval);
	$('#timer').empty();
   $('#endgame').hide();
	$('#kategorija').hide();
	$('#pitanje').hide();
	$('#odgovorabcd').hide();
	$('#odgovortext').hide();
	if (stuff.s1>stuff.s2) {
	   endMsg+="<h4>"+stuff.p1+" Won this round!</h4>";
	   endMsg+="<h5>"+stuff.p1+ " : "+stuff.s1+"</h5><h5>"+stuff.p2+ " : "+stuff.s2+"</h5>";
	}else if (stuff.s2>stuff.s1) {
	   endMsg+="<h4>"+stuff.p2+" Won this round!</h4>";
	   endMsg+="<h5>"+stuff.p2+ " : "+stuff.s2+"</h5><h5>"+stuff.p1+ " : "+stuff.s1+"</h4>";
	}else {
	   endMsg+="<h4>TIED!</h4>";
	   endMsg+="<h5>"+stuff.p1+ " : "+stuff.s1+"</h5><h5>"+stuff.p2+ " : "+stuff.s2+"</h5>";
	}
   $("#rezultat").html(endMsg);
   $("#rezultat").fadeIn();
   webSocket.close();
}
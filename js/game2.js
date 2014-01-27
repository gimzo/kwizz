//--- Global variables ---//

// categoryId - id of selected category
// categoryName - name of selected category
difficulty = [false, false, false];

// Hide game section until a category is selected
$('#game-section').hide();

// Starting layout configuration
if (typeof categoryId == 'undefined') {
	$('#status-window').html('<p class="lead font-lg text-center">Firstly, choose a category of your choice:</p>');
} else {
	// Hide categories
	$('#categories-section').hide();
	// Show game section
	$('#game-section').show();
	showMenu();
}

//--- Functions ---//

function showMenu() {
	// Show menu instructions
	$('#status-window').html('<p class="lead font-lg text-center">Now, choose your game mode and difficulty<br>and<br>when you are done, press the start button to go!</p>');
	// Show game settings
	$('#game-window').html('<p class="lead text-center">You chose \''+categoryName+'\' as your theme.<br><br>Game mode:<br><br><button type="button" id="relax-mode-btn" class="btn btn-default">Relax mode</button>&nbsp;&nbsp;or&nbsp;&nbsp;<button type="button" id="time-ch-mode-btn" class="btn btn-default">Time challenge</button><br><br>Difficulty:<br><br><button type="button" id="easy-diff-btn" class="btn btn-default">Easy</button>&nbsp;&nbsp;<button type="button" id="medium-diff-btn" class="btn btn-default">Medium</button>&nbsp;&nbsp;<button type="button" id="hard-diff-btn" class="btn btn-default">Hard</button><br><br><br><button type="button" id="start-game-btn" class="btn btn-default btn-lg">Start game</button>&nbsp;&nbsp;or&nbsp;&nbsp;<button id="choose-category" type="button" class="btn btn-default">Change category</button></p>');
}

function startGame() {
	// Initialization here
	newQuestion();
}

function newQuestion() {
	$.ajax({
		url: "resources/library/get_question.php",
		type: "GET",
		dataType : "json",
		data: {
			easy: difficulty[0],
			med: difficulty[1],
			hard: difficulty[2],
			kategorije: categoryId
		},
		success: function( json ) {
			$('#game-window').empty();
			$('#game-window').append(json.tekst);
			$('#game-window').append(json.kategorija);
			$('#game-window').append("<span class='badge'>"+json.bodovi+"</span> points");
			questionId = json.id;
			questionPoints = parseInt(json.bodovi);
			if (json.vrsta == 1) {
				// $("#odgovortext").fadeIn('fast', function() {
					// $("#txtOdgovor").focus();
					correctAnswers = [];
					for (var i in json.odgovori) {
						if (json.odgovori.hasOwnProperty(i) && !isNaN(+i)) {
							correctAnswers.push(json.odgovori[i]);
						}
					}
				// });
			} else {
				prepareABCD(json);
				// $("#odgovorabcd").fadeIn();
			}
		},
	});
}

function checkTxtAnswer(giveup) {
	// if (odgovoreno) return;
	for (var i = 0; i < correctAnswers.length; i++) {
		if (correctAnswers[i].toLowerCase() == $("input[id=txtOdgovor]").val().toLowerCase()){
			// $('#txtOdgovor').css("background-color","rgb(92, 184, 92)"); // TO-DO sredit boje
			logAnswer(true);
			// odgovoreno=true;
			// tocniOdgovori++;
			// NovoPitanjeTimeout();
		}
	}
	if (giveup) {
		// odgovoreno=true;
		logAnswer(false);
		// $('#txtOdgovor').css("background-color","rgb(217, 83, 79)"); // TO-DO sredit boje
		// NovoPitanjeTimeout();
	}
}

function prepareABCD(data) {
	correctAnswer = data.tocan;
	var answers = [];

	for (var i in data.odgovori) {
		if(data.odgovori.hasOwnProperty(i) && !isNaN(+i)) {
			answers[i] = data.odgovori[i];
		}
	}
	
	for (var i in answers) {
		var button = $("<button>",
		{
			html: answers[i],
			"class": "btn btn-default btn-block",
			onclick: "checkABCDAnswer(this)"
		});
		button.data("id", i);
		$("#game-window").append(button);
	}	
}

function checkABCDAnswer(ovo) {
	// if (odgovoreno) return;
	// odgovoreno = true;
	if ($(ovo).data("id") == correctAnswer) {
		logAnswer(true);
		// tocniOdgovori++;
		$(ovo).removeClass('btn-default').addClass('btn-success');
		// NovoPitanjeTimeout();
	} else {
		logAnswer(false);
		$(ovo).removeClass('btn-default').addClass('btn-danger');
		// NovoPitanjeTimeout();
	}
}

function logAnswer(tocno) {
	// mode se ne koristi u log_answer.php
	$.ajax({
		url: "resources/library/log_answer.php",
		type: "POST",
		data:
		{
			id: questionId,
			odgovor: tocno,
			mode: gameMode
		}
	});
	// if (tocno)trenscore+=bodovi_pitanja;
	// $('#trenscore').html(trenscore);
	// $('#total').load('myscore.php');
}

function newQuestionTimeout() {
	pitanjeTimeout = setTimeout(function() {
		NovoPitanje();
	}, 2000);
}

function timeoutStop(timeoutVar) {
	clearTimeout(timeoutVar);
}

function timerStart() {
	timerInterval = setInterval(function() {
		countdownTime--;
		$('#timer').html('<pre>Time: <strong>'+countdownTime+'</strong> sec</pre>');
		if (countdownTime == 0) {
			$('#modal_title').html('Game Over');
			$('#window_kategorija').html('You answered correctly '+tocniOdgovori+' out of '+brojPitanja+' questions.<br>Success rate is '+Math.round((tocniOdgovori/brojPitanja)*100*10)/10+'%.');
			$('#myModal').modal('show');
			TimeoutStop(pitanjeTimeout);
			StartGame();
		}
	}, 1000);
}

function timerStop(timerVar) {
	clearInterval(timerVar);
}

//--- Button-press handlers ---//

// Pressed button state activate
$('button').click(function() {
	$(this).toggleClass('active');
});

// Choose category slide in
$('#choose-category').click(function() {
	$('#categories-section').slideToggle(function() {
		$('html,body').animate({ scrollTop: $('#categories-section').offset().top }, 'slow');
	});
});

// Set game mode
$('#relax-mode-btn').click(function() {
	gameMode = 'RM';
	$('#time-ch-mode-btn').removeClass('active');
});

$('#time-ch-mode-btn').click(function() {
	gameMode = 'TC';
	$('#relax-mode-btn').removeClass('active');
});

// Set difficulty level
$('#easy-diff-btn').click(function() {
	difficulty[0] = !difficulty[0];
});

$('#medium-diff-btn').click(function() {
	difficulty[1] = !difficulty[1];
});

$('#hard-diff-btn').click(function() {
	difficulty[2] = !difficulty[2];
});

// Start game on start game btn press
$('#start-game-btn').click(function() {
	startGame();
});
//--- Global variables ---//

// categoryId - id of selected category
// categoryName - name of selected category
var difficulty = [false, false, false];
var answerTimeout; // handler
var clockTimer; // handler
var tcModeDuration = 60; // seconds

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
	initBtnHandlers();
}

function startGame() {
	$('#categories-section').hide();
	if (gameMode == 'RM') {
		$('#status-window').html('<p class="lead text-center font-lg">'+categoryName+'</p>');
	} else if (gameMode == 'TC') {
		score = 0;
		countdownTime = tcModeDuration;
		$('#status-window').html('<div class="row"><div class="col-sm-4 col-md-4"><p class="lead text-center"><br>'+categoryName+'</p></div><div class="col-sm-4 col-md-4"><p id="status-display" class="text-center"><input id="timer-knob" value="'+countdownTime+'" data-skin="tron"></p></div><div class="col-sm-4 col-md-4"><p id="score-display" class="lead text-center"><br>Score: 0</p></div></div>');
		refreshTimerKnob();
		timerStart();
	}
	newQuestion();
}

function endGame() {
	timerStop(clockTimer);
	timeoutStop(answerTimeout);
	showMenu();
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
			$('#game-window').append('<button type="button" class="btn btn-default" onclick="endGame()"><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;Main Menu</button>');
			$('#game-window').append('<p class="lead text-center"><br>'+json.tekst+' | '+json.bodovi+' points</p><br>');
			answered = false;
			questionId = json.id;
			questionPoints = parseInt(json.bodovi);
			if (json.vrsta == 1) {
				$('#game-window').append('<div class="input-group"><input type="text" id="txt-answer" class="form-control" onkeyup="checkTxtAnswer()"><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="checkTxtAnswer(true)">I don\'t know!</button></span></div>');
					$("#txt-answer").focus();
					correctAnswers = [];
					for (var i in json.odgovori) {
						if (json.odgovori.hasOwnProperty(i) && !isNaN(+i)) {
							correctAnswers.push(json.odgovori[i]);
						}
					}
			} else {
				prepareABCD(json);
			}
		},
	});
}

function checkTxtAnswer(giveup) {
	if (answered) return;
	for (var i = 0; i < correctAnswers.length; i++) {
		if (correctAnswers[i].toLowerCase() == $("input[id=txt-answer]").val().toLowerCase()){
			$('#txt-answer').css("color","rgb(92, 184, 92)");
			logAnswer(true);
			newQuestionTimeout();
		}
	}
	if (giveup) {
		$('#txt-answer').css("color","rgb(217, 83, 79)");
		logAnswer(false);
		newQuestionTimeout();
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
	if (answered) return;
	if ($(ovo).data("id") == correctAnswer) {
		logAnswer(true);
		$(ovo).removeClass('btn-default').addClass('btn-correct');
		newQuestionTimeout();
	} else {
		logAnswer(false);
		$(ovo).removeClass('btn-default').addClass('btn-incorrect');
		newQuestionTimeout();
	}
}

function logAnswer(tocno) {
	answered = true;
	if (gameMode == 'TC') {
		if (tocno) {
			score += questionPoints;
			$('#score-display').html('<br>Score: '+score);
		}
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
	}
}

function newQuestionTimeout() {
	answerTimeout = setTimeout(function() {
		newQuestion();
	}, 1000);
}

function timeoutStop(timeoutVar) {
	clearTimeout(timeoutVar);
}

function timerStart() {
	clockTimer = setInterval(function() {
		countdownTime--;
		$('#status-display').html('<input id="timer-knob" value="'+countdownTime+'" data-skin="tron">');
		refreshTimerKnob();
		if (countdownTime == 0) {
			timerStop(clockTimer);
			timeoutStop(answerTimeout);
			showResult();
		}
	}, 1000);
}

function timerStop(timerVar) {
	clearInterval(timerVar);
}

function showResult() {
	$('#game-window').empty();
	$('#game-window').append('<p class="lead text-center font-lg">Game over! :(</p><br><br>');
	if (score <= 100) {
		$('#game-window').append('<p class="lead text-center font-lg">You scored a total of '+score+' points.</p>');
		$('#game-window').append('<p class="lead text-center font-lg">Better luck next time!</p>');
	} else if (score <= 200) {
		$('#game-window').append('<p class="lead text-center font-lg">You scored a total of '+score+' points.</p>');
		$('#game-window').append('<p class="lead text-center font-lg">You did pretty good out there!</p>');
	} else if (score > 200) {
		$('#game-window').append('<p class="lead text-center font-lg">You scored a total of '+score+' points.</p>');
		$('#game-window').append('<p class="lead text-center font-lg">Excellent result, you owned it!</p>');
	}
	$('#game-window').append('<br><br><p class="text-center"><button type="button" class="btn btn-default" onclick="showMenu()"><span class="glyphicon glyphicon-align-center"></span>&nbsp;&nbsp;Main Menu</button></p>');
}

function refreshTimerKnob() {
	$(function($) {
		$("#timer-knob").knob({
			min : 0, 
			max : tcModeDuration, 
			step : 1, 
			angleOffset : 0, 
			angleArc : 360, 
			stopper : true, 
			readOnly : true, 
			cursor : false,  
			lineCap : 'butt', 
			thickness : '0.1',
			height: 80,
			width : 80, 
			displayInput : true, 
			displayPrevious : false, 
			fgColor : '#ffffff', 
			inputColor : '#ffffff', 
			font : 'Arial', 
			fontWeight : 'normal', 
			bgColor : '#EEEEEE', 
			draw : function () {
				if(this.$.data('skin') == 'tron') {
                    var a = this.angle(this.cv)  // Angle
                    , sa = this.startAngle          // Previous start angle
                    , sat = this.startAngle         // Start angle
                    , ea                            // Previous end angle
                    , eat = sat + a                 // End angle
                    , r = 1;
                    this.g.lineWidth = this.lineWidth;
                    this.o.cursor
                    && (sat = eat - 0.3)
                    && (eat = eat + 0.3);
                    if (this.o.displayPrevious) {
                    	ea = this.startAngle + this.angle(this.v);
                    	this.o.cursor
                    	&& (sa = ea - 0.3)
                    	&& (ea = ea + 0.3);
                    	this.g.beginPath();
                    	this.g.strokeStyle = this.pColor;
                    	this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                    	this.g.stroke();
                    }
                    this.g.beginPath();
                    this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                    this.g.stroke();
                    this.g.lineWidth = 2;
                    this.g.beginPath();
                    this.g.strokeStyle = this.o.fgColor;
                    this.g.arc( this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                    this.g.stroke();
                    return false;
                }
            }
        });
	});
}

function initBtnHandlers() {
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
}
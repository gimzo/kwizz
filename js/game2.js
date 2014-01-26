// Hide game section until a category is selected
$('#game-section').hide();

if (typeof categoryId == 'undefined') {
	$('#status-window').html('<p class="lead font-lg text-center">Firstly, choose a category of your choice:</p>');
} else {
	// Hide categories
	$('#categories-section').hide();
	// Show game section
	$('#game-section').show();
	showMenu();
}

function showMenu() {
	// Show menu instructions
	$('#status-window').html('<p class="lead font-lg text-center">Now, choose your game mode and difficulty<br>and<br>when you are done, press the start button to go!</p>');
	// Show game settings
	$('#game-window').html('<p class="lead text-center">You chose \''+categoryName+'\' as your theme.<br><br>Game mode:<br><br><button type="button" class="btn btn-default">Relax mode</button>&nbsp;&nbsp;or&nbsp;&nbsp;<button type="button" class="btn btn-default">Time challenge</button><br><br>Difficulty:<br><br><button type="button" class="btn btn-default">Easy</button>&nbsp;&nbsp;<button type="button" class="btn btn-default">Medium</button>&nbsp;&nbsp;<button type="button" class="btn btn-default">Hard</button><br><br><br><button type="button" class="btn btn-default btn-lg">Start game</button>&nbsp;&nbsp;or&nbsp;&nbsp;<button id="choose-category" type="button" class="btn btn-default">Change category</button></p>');
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
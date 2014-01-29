if (contact_id) {
	populate_chat_window();

	setInterval( function() {
		populate_chat_window();
	}, 5000);
}

$("#message-content").keypress(function(e){
    if (e.which == 13){
		send_message($("#message-content").val());
		$("#message-content").val('');
		populate_chat_window();
    }
});

$("#send-btn").click( function() {
	send_message($("#message-content").val());
	$("#message-content").val('');
	populate_chat_window();
});

// Ucitavanje poruka
function populate_chat_window() {
	$.ajax({
		url: 'resources/library/getMessages.php',
		type: 'GET',
		data: 'user='+contact_id,
		success: function(messages) {
			clear_chat_window();
			var messages = $.parseJSON(messages);
			for (var i in messages) {
				if (messages[i].sender == user_id) {
					$("#chat-window").append('<div class="row"><blockquote><strong><p>You:</strong> '+messages[i].text+'</p><small>'+messages[i].time+'</small></blockquote></div>');
				} else {
					$("#chat-window").append('<div class="row"><blockquote class="pull-right"><p><strong>'+messages[i].nick+'</strong>: '+messages[i].text+'</p><small>'+messages[i].time+'</small></blockquote></div>');
				}
			}
		}
	});
}

// Brisanje chat windowa
function clear_chat_window() {
	$("#chat-window").empty();
}

// Slanje poruke
function send_message(text) {
	$.ajax({
		url: 'resources/library/sendMessage.php',
		type: 'GET',
		data: 'user='+contact_id+'&text='+text
	});
}
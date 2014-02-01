<?php
	session_start();
	include_once 'resources/config.php';
	header("Content-type: text/html; charset=utf-8");
	if (!isset($_SESSION['user'])) {
		header("Location: index.php");
		die();
	}
?>

<!DOCTYPE html> 
<html>
	<head>
		<title>Kwizz | Messages</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<!-- Header -->
		<?php include_once 'resources/templates/header.php'; ?>
		<!-- Menu -->
		<?php include_once 'resources/templates/menu.php'; ?>
		<div class="section purple">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<p class="lead text-center font-lg">Start messaging with your friends:</p>
					</div>
				</div>
			</div>
		</div>
		<div class="section red">
			<div class="container">
				<div class="row">
					<!-- Lista razgovora -->
					<div class="col-sm-5 col-md-4">
						<p class="lead">Conversations</p>
						<hr>
						<?php
							db_connect();

							// Povuci sve id-eve korisnika s kojima je korisnik bio u kontaktu
							$stmt = $mysqli->prepare("SELECT DISTINCT id_posiljatelj AS id FROM (SELECT id_posiljatelj, id_poruka FROM chat WHERE id_primatelj=? UNION SELECT id_primatelj, id_poruka FROM chat WHERE id_posiljatelj=? ORDER BY id_poruka DESC) AS result");
							$stmt->bind_param('ii', $_SESSION['id'], $_SESSION['id']);
							$stmt->execute();
							$contact_ids = $stmt->get_result();
							$stmt->close();

							while ($contact = $contact_ids->fetch_array()) {
								// Povuci name i username korisnika s kojim je vodio razgovor
								$stmt = $mysqli->prepare("SELECT ime, nadimak_korisnik FROM korisnik WHERE id_korisnik=?");
								$stmt->bind_param('i', $contact['id']);
								$stmt->execute();
								$result = $stmt->get_result();
								$user = $result->fetch_array();
								$stmt->close();
								// Povuci zadnju poruku iz razgovora sa prijateljem (na kojem smo trenutno)
								$stmt = $mysqli->prepare("SELECT tekst_poruka, id_poruka, id_posiljatelj FROM chat WHERE (id_primatelj=? AND id_posiljatelj=?) OR (id_primatelj=? AND id_posiljatelj=?) ORDER BY id_poruka DESC LIMIT 1");
								$stmt->bind_param('iiii', $contact['id'], $_SESSION['id'], $_SESSION['id'], $contact['id']);
								$stmt->execute();
								$result = $stmt->get_result();
								$conversation = $result->fetch_array();
								$stmt->close();

								echo '<span class="lead"><a href="messages.php?conversation='.$user['nadimak_korisnik'].'">Conversation</a> with <a href="profile.php?nickname='.$user['nadimak_korisnik'].'">'.$user['ime'].'</a></span><br><blockquote><p>'.($conversation['id_posiljatelj'] == $_SESSION['id'] ? '<span class="glyphicon glyphicon-share-alt"></span>&nbsp;&nbsp;' : '').$conversation['tekst_poruka'].'</p><sm>'.date('M j g:i A', strtotime($conversation['id_poruka'])).'</sm></blockquote>';
							}

							db_disconnect();
						?>
					</div>
					<!-- Chat prozor -->
					<div class="col-sm-7 col-md-8">
						<?php
							if (isset($_GET['conversation'])) {
								db_connect();
								$stmt = $mysqli->prepare("SELECT id_korisnik, ime FROM korisnik WHERE nadimak_korisnik=?");
								$stmt->bind_param('s', $_GET['conversation']);
								$stmt->execute();
								$result = $stmt->get_result();
								$user = $result->fetch_array();
								$stmt->close();
								db_disconnect();

								echo '
								<p class="lead">Conversation with '.$user['ime'].'</p>
								<hr>
								<div id="chat-window"></div>
								<hr>
								<div class="input-group">
									<input type="text" id="message-content" class="form-control">
									<span class="input-group-btn">
										<button id="send-btn" class="btn btn-default btn-primary" type="button">Send</button>
									</span>
								</div><!-- /input-group -->
								<script type="text/javascript">
									var contact_id = '.$user['id_korisnik'].';
									var user_id = '.$_SESSION['id'].';
								</script>
								';
							} else {
								echo '<p class="lead text-center">Please select a conversation or search for a friend.</p>';
							}
						?>
					</div>
				</div>
			</div>
		</div>

		<!-- Footer -->
		<?php include_once 'resources/templates/footer.php'; ?>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		<script src="js/chat.js"></script>
	</body>
</html>
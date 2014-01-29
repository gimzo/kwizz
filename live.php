<script src="js/live.js"></script>
<button id="menu_btn" type="button" class="btn btn-default" onclick="location.reload();">
	<span class="glyphicon glyphicon-align-center"></span> Main Menu
</button>
<span id="timer" class="pull-right"></span>
<hr>

<!-- Sucelje -->
<div id="startgame" class="gamescreen text-center">
	<div class="hr"></div>
	<div id="kat">
	</div>
	<div class="hr"></div>
	<div>
	</div>
	<div class="hr"></div>
	<div id="buttonmsg">
		<button id="join" class="btn btn-success" onclick="Lobby()">Join game</button>
	</div>
</div>
<!-- Modal za kategorije -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 id='modal_title' class="modal-title text-center">Categories</h4>
			</div>
			<div id="window_kategorija" class="modal-body text-center"></div>
		</div>
	</div>
</div>
<div id="rezultat"></div>
<!-- Prikaz kategorija -->
<div id="kategorija"></div>
<!-- Prikaz pitanja -->
<div id="pitanje" class="well well-sm text-center"></div>
<!-- Odgovori a,b,c,d -->
<div id="odgovorabcd" class="odgovor"></div>
<!-- Unos odgovora -->
<div id="odgovortext" class="odgovor input-group">
	<input type="text" id="txtOdgovor" class="form-control" onkeyup="CheckTekstOdgovora()">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button" id="neznam" onclick="CheckTekstOdgovora(true)">I don't know!</button>
	</span>
</div>
<div id="drugi_odgovor"></div>
<div id="broj_pitanja"></div>

<!-- Pocetak igre -->
<script>
  <?php echo "var username='$_SESSION[user]';" ?>
	$(window).load(connect());
</script>

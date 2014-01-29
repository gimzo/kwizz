<script src="js/live.js"></script>
<button id="menu_btn" type="button" class="btn btn-default" onclick="StartGame()">
	<span class="glyphicon glyphicon-align-center"></span> Main Menu
</button>
<span id="timer" class="pull-right"></span>
<hr>

<!-- Sucelje -->
<div id="startgame" class="gamescreen text-center">
	<div class="hr"></div>
	<div id="kat">
		<h5>Select Category:</h5>
		<button data-toggle="modal" href="#myModal" class="btn btn-default" onclick="Kategorije()">Categories</button>
	</div>
	<div class="hr"></div>
	<div>
		<h5>Select Difficulty:</h5>
		<button class="btn btn-info" id="easy" onclick="setLevel(this)">Easy</button>
		<button class="btn btn-warning" id="med" onclick="setLevel(this)">Medium</button>
		<button class="btn btn-danger" id="hard" onclick="setLevel(this)">Hard</button>
	</div>
	<div class="hr"></div>
	<div>
		<button class="btn btn-success" onclick="Lobby()">Start!</button>
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

<!-- Pocetak igre -->
<script>
  <?php echo "var username='$_SESSION[user]';" ?>
	$(window).load(connect());
</script>

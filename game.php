<!-- Sucelje -->
<div id="startgame" class="gamescreen text-center">
	<div>
		<h5>Select Mode:</h5>
		<span class="btn btn-default" id="FFA" onclick="setMode(this)">Free For All</span>
		<span class="btn btn-default" id="CHA" onclick="setMode(this)">Challenge</span>
	</div>
	<div class="hr"></div>
	<div id="kat">
		<h5>Select Category:</h5>
		<a data-toggle="modal" href="#myModal" class="btn btn-default" onclick="Kategorije()">Categories</a>
	</div>
	<div class="hr"></div>
	<div>
		<h5>Select Difficulty:</h5>
		<span class="btn btn-info" id="easy" onclick="setLevel(this)">Easy</span>
		<span class="btn btn-warning" id="med" onclick="setLevel(this)">Medium</span>
		<span class="btn btn-danger" id="hard" onclick="setLevel(this)">Hard</span>
	</div>
	<div class="hr"></div>
	<div>
		<span class="btn btn-success" onclick="NovoPitanje()">Start!</span>
	</div>
</div>
<!-- Modal za kategorije -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Categories</h4>
			</div>
			<div id="window_kategorija" class="modal-body">
				...
			</div>
		</div>
	</div>
</div>
<!-- TO-DO za kraj igre -->
<div id="endgame" class="gamescreen"></div>

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
	$(window).load(StartGame());
</script>

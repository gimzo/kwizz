<div id="kategorija"></div>
<div id="pitanje"></div>
<div id="odgovorabcd" class="odgovor"></div>
<div id="odgovortext" class="odgovor">
	<input type="text" id="txtOdgovor" onkeyup="CheckTekstOdgovora()">
	<button type="button" id="neznam" onclick="CheckTekstOdgovora(true)">I don't know!</button>
</div>
<div id="tocno" name="tocno" class="popup">
	<p>Correct answer!</p>
</div>
<div id="krivo" name="krivo" class="popup">
	<p>Incorrect answer!</p>
</div>
<div id="startgame" class="gamescreen">
	<p>Start new game:</p>
	<div>
		<p>Mode</p>
		<span class="rbotun" id="FFA" onclick="setMode(this)">Free For All</span>
		<span class="rbotun" id="CHA" onclick="setMode(this)">Challenge</span>
	</div>
	<div id="kat">
		<a href='#' onclick="Kategorije()">Categories</a>
	</div>
	<div>
		<p>Level</p>
		<span class="rbotun"id="easy" onclick="setLevel(this)">Easy</span>
		<span class="rbotun"id="med" onclick="setLevel(this)">Medium</span>
		<span class="rbotun"id="hard" onclick="setLevel(this)">Hard</span>
	</div>
	<div>
		<span class="botun" onclick="NovoPitanje()">Start!</span></div>
</div>
<div id="endgame" class="gamescreen"></div>
<div id="window_kategorija"></div>
<script>
	$( window ).load(StartGame());
</script>

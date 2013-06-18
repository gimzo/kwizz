<div id="pitanje">
</div>
<div id="odgovorabcd" class="odgovor">
</div>
<div id="odgovortext" class="odgovor">
	<input type="text" id="txtOdgovor" onkeyup="CheckTekstOdgovora()">
	<button type="button" id="neznam" onclick="CheckTekstOdgovora(true)">Ne znam</button>
</div>
<div id="tocno" name="tocno" class="popup">
	<p>Odgovor je točan!</p>
</div>
<div id="krivo" name="krivo" class="popup">
	<p>Odgovor je kriv!</p>
</div>
<div id="startgame" class="gamescreen">
	<p>Start new game</p>
	<div>
		<p>Mode</p>
		<span class="rbotun" id="FFA" onclick="setMode(this)">Free For All</span>
		<span class="rbotun" id="CHA" onclick="setMode(this)">Challenge</span>
	</div>
	<div id="kat">
		<p>Categories</p>
	</div>
	<div>
		<p>Level</p>
		<span class="rbotun"id="easy" onclick="setLevel(this)">EASY</span>
		<span class="rbotun"id= "med" onclick="setLevel(this)">MEDIUM</span>
		<span class="rbotun"id="hard" onclick="setLevel(this)">HARD</span>
	</div>
	<div>
		<span class="botun" onclick="NovoPitanje()">Start!</span></div>
</div>
<div id="endgame" class="gamescreen">
</div>

<script>
	$( window ).load(StartGame());
</script>

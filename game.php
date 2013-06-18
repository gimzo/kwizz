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

<script>
	$( window ).load(NovoPitanje());
</script>

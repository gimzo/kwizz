<?php
	if (isset($_SESSION['user'])) {
echo <<<END
		<div id="chatBar">
			<div id="chatWrapper">
			</div>
		</div>
END;
	}
?>
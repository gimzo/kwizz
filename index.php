<?php 
	session_start();
	include_once 'resources/config.php';
	header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html> 
<html>
	<head>
		<title>Kwizz</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style-landing.css">
	</head>
	<body>
		<!-- Header -->
		<?php include_once 'resources/templates/header.php'; ?>
		<!-- Menu -->
		<?php
			if (isset($_SESSION['user'])) {
			 	include_once 'resources/templates/menu.php';
			 	echo '
			 	<div class="section purple">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<p class="lead text-center font-lg">Welcome '.$_SESSION['user'].'!<br>Have fun :)</p>
							</div>
						</div>
					</div>
				</div>
			 	';
			} else {
				echo '
				<div class="section purple">
					<div class="container">
						<div class="jumbotron">
							<h1>Howdy, stranger!</h1><br>
							<p class="text-center">Register now to have fun playing a bunch of different quizzes with a lot of categories to choose from. Sign in if you are already a part of the community.</p><br>
							<p class="text-center"><button id="register-btn" type="button" class="btn btn-primary blue btn-lg">Register now!</button>&nbsp; or &nbsp;<button id="sign-in-btn" type="button" class="btn btn-primary blue btn-lg" role="button">Sign in</button></p>
						</div>
					</div>
				</div>
				<div id="register-section" class="section wgreen">
					<div class="container">
						<div class="row">
							<div class="col-sm-12"><h3 class="text-center"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Registration</h3><br><br></div>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
									<form id="register-form" role="form">
										<div class="form-group">
											<label>Desired nickname</label>
											<input type="text" class="form-control" name="nickname" placeholder="Nickname" maxlength="20">
										</div>
										<div class="form-group">
											<label>Password</label>
											<input type="password" class="form-control" name="password" placeholder="Password" maxlength="45">
										</div>
										<div class="form-group">
											<label>Country</label>
											<select class="form-control" name="country">
												<option value="default" disabled="disabled" selected="selected">Select</option>
												<option value="af">Afghanistan</option>
												<option value="ax">Aaland Islands</option>
												<option value="al">Albania</option>
												<option value="dz">Algeria</option>
												<option value="as">American Samoa</option>
												<option value="ad">Andorra</option>
												<option value="ao">Angola</option>
												<option value="ai">Anguilla</option>
												<option value="aq">Antarctica</option>
												<option value="ag">Antigua And Barbuda</option>
												<option value="ar">Argentina</option>
												<option value="am">Armenia</option>
												<option value="aw">Aruba</option>
												<option value="au">Australia</option>
												<option value="at">Austria</option>
												<option value="az">Azerbaijan</option>
												<option value="bs">Bahamas</option>
												<option value="bh">Bahrain</option>
												<option value="bd">Bangladesh</option>
												<option value="bb">Barbados</option>
												<option value="by">Belarus</option>
												<option value="be">Belgium</option>
												<option value="bz">Belize</option>
												<option value="bj">Benin</option>
												<option value="bm">Bermuda</option>
												<option value="bt">Bhutan</option>
												<option value="bo">Bolivia, Plurinational State Of</option>
												<option value="bq">Bonaire, Sint Eustatius And Saba</option>
												<option value="ba">Bosnia And Herzegovina</option>
												<option value="bw">Botswana</option>
												<option value="bv">Bouvet Island</option>
												<option value="br">Brazil</option>
												<option value="io">British Indian Ocean Territory</option>
												<option value="bn">Brunei Darussalam</option>
												<option value="bg">Bulgaria</option>
												<option value="bf">Burkina Faso</option>
												<option value="bi">Burundi</option>
												<option value="kh">Cambodia</option>
												<option value="cm">Cameroon</option>
												<option value="ca">Canada</option>
												<option value="cv">Cape Verde</option>
												<option value="ky">Cayman Islands</option>
												<option value="cf">Central African Republic</option>
												<option value="td">Chad</option>
												<option value="cl">Chile</option>
												<option value="cn">China</option>
												<option value="cx">Christmas Island</option>
												<option value="cc">Cocos (Keeling) Islands</option>
												<option value="co">Colombia</option>
												<option value="km">Comoros</option>
												<option value="cg">Congo</option>
												<option value="cd">Congo, The Democratic Republic Of The</option>
												<option value="ck">Cook Islands</option>
												<option value="cr">Costa Rica</option>
												<option value="ci">Cote D\'Ivoire</option>
												<option value="hr">Croatia</option>
												<option value="cu">Cuba</option>
												<option value="cw">Curacao</option>
												<option value="cy">Cyprus</option>
												<option value="cz">Czech Republic</option>
												<option value="dk">Denmark</option>
												<option value="dj">Djibouti</option>
												<option value="dm">Dominica</option>
												<option value="do">Dominican Republic</option>
												<option value="ec">Ecuador</option>
												<option value="eg">Egypt</option>
												<option value="sv">El Salvador</option>
												<option value="gq">Equatorial Guinea</option>
												<option value="er">Eritrea</option>
												<option value="ee">Estonia</option>
												<option value="et">Ethiopia</option>
												<option value="fk">Falkland Islands (Malvinas)</option>
												<option value="fo">Faroe Islands</option>
												<option value="fj">Fiji</option>
												<option value="fi">Finland</option>
												<option value="fr">France</option>
												<option value="gf">French Guiana</option>
												<option value="pf">French Polynesia</option>
												<option value="tf">French Southern Territories</option>
												<option value="ga">Gabon</option>
												<option value="gm">Gambia</option>
												<option value="ge">Georgia</option>
												<option value="de">Germany</option>
												<option value="gh">Ghana</option>
												<option value="gi">Gibraltar</option>
												<option value="gr">Greece</option>
												<option value="gl">Greenland</option>
												<option value="gd">Grenada</option>
												<option value="gp">Guadeloupe</option>
												<option value="gu">Guam</option>
												<option value="gt">Guatemala</option>
												<option value="gg">Guernsey</option>
												<option value="gn">Guinea</option>
												<option value="gw">Guinea-Bissau</option>
												<option value="gy">Guyana</option>
												<option value="ht">Haiti</option>
												<option value="hm">Heard Island And Mcdonald Islands</option>
												<option value="va">Holy See (Vatican City State)</option>
												<option value="hn">Honduras</option>
												<option value="hk">Hong Kong</option>
												<option value="hu">Hungary</option>
												<option value="is">Iceland</option>
												<option value="in">India</option>
												<option value="id">Indonesia</option>
												<option value="ir">Iran, Islamic Republic Of</option>
												<option value="iq">Iraq</option>
												<option value="ie">Ireland</option>
												<option value="im">Isle Of Man</option>
												<option value="il">Israel</option>
												<option value="it">Italy</option>
												<option value="jm">Jamaica</option>
												<option value="jp">Japan</option>
												<option value="je">Jersey</option>
												<option value="jo">Jordan</option>
												<option value="kz">Kazakhstan</option>
												<option value="ke">Kenya</option>
												<option value="ki">Kiribati</option>
												<option value="kp">Korea, Democratic People\'S Republic Of</option>
												<option value="kr">Korea, Republic Of</option>
												<option value="kw">Kuwait</option>
												<option value="kg">Kyrgyzstan</option>
												<option value="la">Lao People\'S Democratic Republic</option>
												<option value="lv">Latvia</option>
												<option value="lb">Lebanon</option>
												<option value="ls">Lesotho</option>
												<option value="lr">Liberia</option>
												<option value="ly">Libya</option>
												<option value="li">Liechtenstein</option>
												<option value="lt">Lithuania</option>
												<option value="lu">Luxembourg</option>
												<option value="mo">Macao</option>
												<option value="mk">Macedonia, The Former Yugoslav Republic Of</option>
												<option value="mg">Madagascar</option>
												<option value="mw">Malawi</option>
												<option value="my">Malaysia</option>
												<option value="mv">Maldives</option>
												<option value="ml">Mali</option>
												<option value="mt">Malta</option>
												<option value="mh">Marshall Islands</option>
												<option value="mq">Martinique</option>
												<option value="mr">Mauritania</option>
												<option value="mu">Mauritius</option>
												<option value="yt">Mayotte</option>
												<option value="mx">Mexico</option>
												<option value="fm">Micronesia, Federated States Of</option>
												<option value="md">Moldova, Republic Of</option>
												<option value="mc">Monaco</option>
												<option value="mn">Mongolia</option>
												<option value="me">Montenegro</option>
												<option value="ms">Montserrat</option>
												<option value="ma">Morocco</option>
												<option value="mz">Mozambique</option>
												<option value="mm">Myanmar</option>
												<option value="na">Namibia</option>
												<option value="nr">Nauru</option>
												<option value="np">Nepal</option>
												<option value="nl">Netherlands</option>
												<option value="nc">New Caledonia</option>
												<option value="nz">New Zealand</option>
												<option value="ni">Nicaragua</option>
												<option value="ne">Niger</option>
												<option value="ng">Nigeria</option>
												<option value="nu">Niue</option>
												<option value="nf">Norfolk Island</option>
												<option value="mp">Northern Mariana Islands</option>
												<option value="no">Norway</option>
												<option value="om">Oman</option>
												<option value="pk">Pakistan</option>
												<option value="pw">Palau</option>
												<option value="ps">Palestine, State Of</option>
												<option value="pa">Panama</option>
												<option value="pg">Papua New Guinea</option>
												<option value="py">Paraguay</option>
												<option value="pe">Peru</option>
												<option value="ph">Philippines</option>
												<option value="pn">Pitcairn</option>
												<option value="pl">Poland</option>
												<option value="pt">Portugal</option>
												<option value="pr">Puerto Rico</option>
												<option value="qa">Qatar</option>
												<option value="re">Reunion</option>
												<option value="ro">Romania</option>
												<option value="ru">Russian Federation</option>
												<option value="rw">Rwanda</option>
												<option value="bl">Saint Barthelemy</option>
												<option value="sh">Saint Helena, Ascension And Tristan Da Cunha</option>
												<option value="kn">Saint Kitts And Nevis</option>
												<option value="lc">Saint Lucia</option>
												<option value="mf">Saint Martin (French Part)</option>
												<option value="pm">Saint Pierre And Miquelon</option>
												<option value="vc">Saint Vincent And The Grenadines</option>
												<option value="ws">Samoa</option>
												<option value="sm">San Marino</option>
												<option value="st">Sao Tome And Principe</option>
												<option value="sa">Saudi Arabia</option>
												<option value="sn">Senegal</option>
												<option value="rs">Serbia</option>
												<option value="sc">Seychelles</option>
												<option value="sl">Sierra Leone</option>
												<option value="sg">Singapore</option>
												<option value="sx">Sint Maarten (Dutch Part)</option>
												<option value="sk">Slovakia</option>
												<option value="si">Slovenia</option>
												<option value="sb">Solomon Islands</option>
												<option value="so">Somalia</option>
												<option value="za">South Africa</option>
												<option value="gs">South Georgia And The South Sandwich Islands</option>
												<option value="ss">South Sudan</option>
												<option value="es">Spain</option>
												<option value="lk">Sri Lanka</option>
												<option value="sd">Sudan</option>
												<option value="sr">Suriname</option>
												<option value="sj">Svalbard And Jan Mayen</option>
												<option value="sz">Swaziland</option>
												<option value="se">Sweden</option>
												<option value="ch">Switzerland</option>
												<option value="sy">Syrian Arab Republic</option>
												<option value="tw">Taiwan, Province Of China</option>
												<option value="tj">Tajikistan</option>
												<option value="tz">Tanzania, United Republic Of</option>
												<option value="th">Thailand</option>
												<option value="tl">Timor-Leste</option>
												<option value="tg">Togo</option>
												<option value="tk">Tokelau</option>
												<option value="to">Tonga</option>
												<option value="tt">Trinidad And Tobago</option>
												<option value="tn">Tunisia</option>
												<option value="tr">Turkey</option>
												<option value="tm">Turkmenistan</option>
												<option value="tc">Turks And Caicos Islands</option>
												<option value="tv">Tuvalu</option>
												<option value="ug">Uganda</option>
												<option value="ua">Ukraine</option>
												<option value="ae">United Arab Emirates</option>
												<option value="gb">United Kingdom</option>
												<option value="us">United States</option>
												<option value="um">United States Minor Outlying Islands</option>
												<option value="uy">Uruguay</option>
												<option value="uz">Uzbekistan</option>
												<option value="vu">Vanuatu</option>
												<option value="ve">Venezuela, Bolivarian Republic Of</option>
												<option value="vn">Viet Nam</option>
												<option value="vg">Virgin Islands, British</option>
												<option value="vi">Virgin Islands, U.S.</option>
												<option value="wf">Wallis And Futuna</option>
												<option value="eh">Western Sahara</option>
												<option value="ye">Yemen</option>
												<option value="zm">Zambia</option>
												<option value="zw">Zimbabwe</option>
											</select>
										</div>
										<button id="register" type="submit" class="btn btn-default btn-lg center-block">Register</button>
									</form><br>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="sign-in-section" class="section yellow">
					<div class="container">
						<div class="row">
							<div class="col-sm-12"><h3 class="text-center"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;Sign in</h3><br><br></div>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
									<form id="sign-in-form" role="form">
										<div class="form-group">
											<label>Nickname</label>
											<input type="text" class="form-control" name="nickname" placeholder="Nickname" maxlength="20">
										</div>
										<div class="form-group">
											<label>Password</label>
											<input type="password" class="form-control" name="password" placeholder="Password" maxlength="45">
										</div>
										<button id="sign-in" type="submit" class="btn btn-default btn-lg center-block">Sign in</button>
									</form><br>
								</div>
							</div>
						</div>
					</div>
				</div>
				';
			}
		?>
		<!-- Content -->
		<div class="section red">
			<?php include_once 'resources/templates/categories.php'; ?>
		</div>
		<!-- Footer -->
		<footer>
			<div class="container">
				<div class="row">
					<p class="lead text-center">Created and maintained by:</p>
				</div><br>
				<div class="row">
					<div class="col-sm-4">
						<div class="user">
							<a href="https://github.com/swimR">
								<img src="images/iva.jpg" alt="" class="img-circle img-responsive center-block">
							</a>
						</div>
						<p class="text-center">Iva Petrović</p>
					</div>
					<div class="col-sm-4">
						<div class="user">
							<a href="https://github.com/gimzo">
								<img src="images/david.jpg" alt="" class="img-circle img-responsive center-block">
							</a>
						</div>
						<p class="text-center">David Dubrović</p>
					</div>
					<div class="col-sm-4">
						<div class="user">
							<a href="https://github.com/bcr3ative">
								<img src="images/paolo.jpg" alt="" class="img-circle img-responsive center-block">
							</a>
						</div>
						<p class="text-center">Paolo Perković</p>
					</div>
				</div><br><br>
				<p class="text-center">Kwizz &copy; 2014 | <a href="#">Support</a> &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a> &middot; <a href="#">Blog</a> &middot; <a href="#">About Us</a></p>
			</div>
		</footer>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		<script>
			// Register, sign in button handling
			$("#register-section").hide();
			$("#sign-in-section").hide();
			$("#register-btn").click(function() {
				$(this).toggleClass("hovered");
				$("#register-section").slideToggle();
			});
			$("#sign-in-btn").click(function() {
				$(this).toggleClass("hovered");
				$("#sign-in-section").slideToggle();
			});

			// Registration
			$("#register").click(function(event) {
				event.preventDefault();
				value = $("#register-form").serialize();
				$.ajax({
					url: 'resources/library/register.php',
					type: 'POST',
					dataType: 'json',
					data: value,
					success: function(status) {
						// to do alerts
					}
				});
			});

			// Sign in
			$("#sign-in").click(function(event) {
				event.preventDefault();
				value = $("#sign-in-form").serialize();
				$.ajax({
					url: 'resources/library/sign-in.php',
					type: 'POST',
					dataType: 'json',
					data: value,
					success: function(status) {
						// to do alerts
						location.reload(true);
					}
				});
			});
		</script>
	</body>
</html>

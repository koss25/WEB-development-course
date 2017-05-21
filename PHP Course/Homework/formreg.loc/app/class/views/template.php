<?php
ob_start();
// session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--<link rel="stylesheet" href="http://php.localadvert.ru/css/styles.css"/>-->
	<link rel="stylesheet" href="css/styles.css"/>
	<title>Document</title>
</head>
<body>

<nav class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">Simple MVC app</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<?php if($_SERVER['REQUEST_URI'] === '/'):?>
				<li class="active"><a href="/">Home</a></li>
				<?php else:?>
				<li><a href="/">Home</a></li>
				<?php endif;?>

				<?php if($_SERVER['REQUEST_URI'] === '/about'):?>
				<li class="active"><a href="/about">About</a></li>
				<?php else:?>
				<li><a href="/about">About</a></li>
				<?php endif;?>

				

			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php if($_SERVER['REQUEST_URI'] === '/register'):?>
				<li class="active"><a href="/register">Register</a></li>
				<?php else:?>
				<li><a href="/register">Register</a></li>
				<?php endif;?>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
		<?php
			require PATH.'/app/class/views/'.$content_view;
		?>
	</div>
</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>	
		<!--<script src="http://php.localadvert.ru/js/scripts.js"></script>-->
		<script src="js/scripts.js"></script>
	</body>
</html>
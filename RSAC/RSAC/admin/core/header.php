<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?php echo WEBSITE; ?></title>
		<link href="<?= URL; ?>public/css/default.css" rel='stylesheet' type='text/css'>
		<link href="<?= URL; ?>public/css/mobile.css" rel='stylesheet' type='text/css'>
		<link href="<?= URL; ?>public/css/widgets.css" rel='stylesheet' type='text/css'>
		<link href="<?= URL; ?>public/css/fa/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<script src="<?= URL; ?>public/js/jquery.js"></script>
		<script src="<?= URL; ?>public/js/default.js"></script>
		<script src="<?= URL; ?>public/widgets/widget.js"></script>
		<script data-base="<?= URL."public/widgets" ;?>"data-api="<?=REQUEST_API;?>" data-json="<?= ($GLOBALS['PLUGIN']) ? URL . "plugins/" . $GLOBALS['PLUGIN'] . "/" : URL . "core/".$this->page."/bin/widgets.json";?>"src="<?= URL; ?>public/js/widget_manager.js"></script>
		<?php if (isset($this->css)): ?>
			<?php foreach ($this->css as $css): ?>
				<link rel="stylesheet" type="text/css"
					  href="<?= ($GLOBALS['PLUGIN']) ? URL . "plugins/" . $GLOBALS['PLUGIN'] . "/" : URL . "core/"; ?><?= $css; ?>"/>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php if (isset($this->js)): ?>
			<?php foreach ($this->js as $js): ?>
				<script type="text/javascript"
						src="<?= ($GLOBALS['PLUGIN']) ? URL . "plugins/" . $GLOBALS['PLUGIN'] . "/" : URL . "core/"; ?><?= $js; ?>"></script>
			<?php endforeach; ?>
		<?php endif; ?>
	</head>
	<body id="<?= $this->page; ?>">
	<?php if (isset($this->error)): ?>
		<div id="error_wrap">
			<div id="error_center" class="centered">
				<p id="error_response">~<?= $this->error; ?>~</p>
			</div>
		</div>
	<?php endif; ?>
	<div id="header">
		<div id="nav-position">
			<div id="nav-wrap">
				<div class="navbar">
					<ul>
						<li class="navr">
							<a href='<?=URL;?>'><i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
						</li>
						<li class="navr">
							<a href='#'><i class="fa fa-sign-out" aria-hidden="true"></i></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div id='content-wrapper'>
		<?php include "sidebar.php";?>
		<div id="content">
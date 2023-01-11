<!DOCTYPE html>
<html lang="en">

<head>
	<title>Quizoo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<style>
		body {
			padding-top: 70px;
		}

		img {
			height: 60px;
			width: 60px;
			padding-right: 5px;
		}

		button {
			background-color: #4D47C3;
			padding: 6px 15px;
			border: none;
			color: white;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
			cursor: pointer;
		}

		.menuStyle {
			margin-right: -9.9%;
		}

		.logoStyle {
			float: left;
		}

		.leaderBoardStyle {
			float: right;
		}

		.titleStyle {
			text-align: center;
			padding-top: 10%
		}

		.tagStyle {
			text-align: center;
			margin-top: 0px;
		}

		.searchAreaStyle {
			margin-left: 35%
		}
	</style>
</head>

<body>
	<div class="container" id="contentView">

		<div class='row menuStyle'>
			<div class='col-md-3 logoStyle'>
				<a href="<?php echo base_url() ?>index.php">
					<img src="<?php echo base_url() ?>/application/resource/logo.png" alt="profile">
				</a>
			</div>
			<div class='col-md-5 leaderBoardStyle'>
				<a href="<?php echo base_url() ?>index.php/scoreController/leaderBoardView">
					<img src="<?php echo base_url() ?>/application/resource/score.png" alt="score">
				</a>
				<a href="<?php echo base_url() ?>index.php/quizController/createQuizView">
					<img src="<?php echo base_url() ?>/application/resource/editQuiz.png" alt="createQuiz">
				</a>
				<a href="<?php echo base_url() ?>index.php/scoreController/profile">
					<img src="<?php echo base_url() ?>/application/resource/profile.png" alt="profile">
				</a>
				<a href="<?php echo base_url() ?>index.php/SearchQuizController/browseView">
					<img src="<?php echo base_url() ?>/application/resource/browse.png" alt="browse">
				</a>
				<a href="<?php echo base_url() ?>index.php/userAuthentication/logout">
					<img src="<?php echo base_url() ?>/application/resource/logout.png" alt="logout">
				</a>
			</div>
		</div>
		<div class='row titleStyle'>
			<h1>Quizoo</h1>
		</div>
		<div class='row tagStyle'>
			<h2>Search for fun quizzes </h2>
		</div>
		<div class='row searchAreaStyle'>
			<div class='col-md-6'>
				<input type="search" class="form-control rounded" placeholder="Search quizzes by a tag or category"
					aria-label="Search" aria-describedby="search-addon" id="keywords" />
			</div>
			<div class='col-md-6'>
				<button type="button" id="searchButton">
					Search
				</button>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
	<script language="Javascript">
		$(document).ready(function () {
			var ContentAreaView = Backbone.View.extend(
				{
					el: $('#contentView'),
					events: {
						"click #searchButton": "searchButtonEvent"
					},
					initialize: function () {
					},
					render: function () {
					},
					searchButtonEvent: function (event) {
						if($("#keywords").val()){
							document.location.href = "<?php echo base_url() ?>index.php/SearchQuizController/browseQuizzesView/tag/" + $("#keywords").val();
						}
					}
				}
			)

			var contentView = new ContentAreaView();
		});
	</script>
</body>

</html>
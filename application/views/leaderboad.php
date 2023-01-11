<!DOCTYPE html>
<html lang="en">

<head>
	<title>Quizoo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<style>
		.row {
			margin-top: 2%;
		}

		.titleStyle {
			text-align: center;
		}

		#userRankArea {
			padding-left: 2%;
		}

		table {
			width: 90%;
		}
	</style>
</head>

<body>
	<div>

		<div class="container">
			<div class="row titleStyle">
				<h1>Leader Board</h1>
			</div>
			<div class="row" id="userRankArea">
			</div>
			<table class="table table-dark">
				<thead>
					<tr class="table-secondary">
						<th scope="col">Rank</th>
						<th scope="col">Username</th>
						<th scope="col">Score</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>


	<script language="Javascript">
		$(document).ready(function () {
			var User = Backbone.Model.extend({
				url: function () {
					return "<?php echo base_url() ?>index.php/scoreController/userRank";
				},
				idAttribute: "id",
				defaults: {
					username: null,
					score: null,
				}
			});

			var Users = Backbone.Collection.extend(
				{
					model: User,
					url: "<?php echo base_url() ?>index.php/scoreController/maxScoreUsers"
				}
			);

			var users = new Users();
			var user = new User();

			var ContentAreaView = Backbone.View.extend({
				model: user,
				el: $('#contentArea'),
				events: {},
				initialize: function () {
					users.fetch({ async: false });
					user.fetch({ async: false });
					console.log(users);
					console.log(user)
					this.render();
				},
				render: function () {
					var count = 0;
					$("#userRankArea").append(
						"<h3>#" + user.get("username") + " Score " + user.get("score") + "</h3>"
					);

					users.each(function (user) {
						$("tbody").append(
							`<tr>
									<th scope="row">`+ count + `</th>
									<td>`+ user.get('username') + `</td>
									<td>`+ user.get('score') + `</td>
								</tr>`
						)
						count = count + 1;
					})
				}
			})
			var contentView = new ContentAreaView();
		});
	</script>

</body>

</html>
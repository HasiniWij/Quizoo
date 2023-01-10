<!DOCTYPE html>
<html lang="en">

<head>
	<title>Quizoo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<style>
		#categoryButton {
			background-color: #4D47C3;
			border: none;
			color: white;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
			cursor: pointer;
			font-size: 30px;
			width: 250px;
			height: 130px;
			margin: 30px;
		}

		.titleStyle {
			text-align: center;
			padding-top: 5%
		}
	</style>
</head>

<body>
	<div class="container" id="contentArea">
		<div class='row titleStyle'>
			<h1>Browse</h1>
		</div>
		<div id="buttonArea"></div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>

	<script language="Javascript">
		$(document).ready(function () {
			var Category = Backbone.Model.extend({
				idAttribute: "category",
				defaults: {
					category: null
				}
			});

			var Categories = Backbone.Collection.extend(
				{
					model: Category,
					url: "<?php echo base_url() ?>index.php/QuizController/categories"
				}
			)

			var categories = new Categories();

			var ContentAreaView = Backbone.View.extend(
				{
					model: categories,
					el: $('#contentArea'),
					events: {
						"click #categoryButton": "selectCategoryEvent"
					},
					initialize: function () {
						categories.fetch({ async: false });
						this.render();
					},
					render: function () {
						var self = this;
						categories.each(function (c) {
							console.log(c.get('category'));
							var button = "<button type='button' id='categoryButton' data-category=" + c.get('category') + ">" + c.get('category') + "</button>";
							$("#buttonArea").append(button);
						})
					},
					selectCategoryEvent: function (event) {
						var category = $(event.currentTarget).data('category');
						document.location.href = "<?php echo base_url() ?>index.php/SearchQuizController/browseQuizzesView/category/" + category;
					}
				}
			)

			var contentArea = new ContentAreaView();
		});
	</script>
</body>

</html>
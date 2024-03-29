<!DOCTYPE html>
<html lang="en">

<head>
	<title>Quizoo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<style>
		.quizArea {
			width: 250px;
			height: 130px;
			margin: 30px;
			background-color: #4D47C3;
			display: inline-block;
		}

		#likeButton {
			background-color: #4D47C3;
			border: none;
			float: right;
		}

		img {
			height: 35px;
		}

		.quizButton {
			background-color: #4D47C3;
			border: none;
			color: white;
			text-align: center;
			text-decoration: none;
			font-size: 14px;
			cursor: pointer;
		}

		.titleArea {
			height: 70px;
			text-align: center;
		}

		.bottomArea {
			height: 60px;
		}

		.row {
			margin-left: 0;
		}

		#numberLikesTagStyle {
			color: white
		}

		#titleSectionStyle {
			text-align: center;
			padding-top: 5%
		}
	</style>
</head>

<body>
	<div class="container" id="contentArea">
		<div class='row' id="titleSectionStyle">
			<h1>
				<?php echo $query ?>
			</h1>
		</div>
		<div id="buttonArea"></div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>

	<script language="Javascript">
		$(document).ready(function () {
			var Quiz = Backbone.Model.extend({
				url: function () {
					return "<?php echo base_url() ?>index.php/QuizController/voteQuiz";
				},
				defaults: {
					category: null
				}
			});

			var Quizzes = Backbone.Collection.extend(
				{
					model: Quiz,
					url: "<?php echo base_url() ?>index.php/QuizController/quizzes/<?php echo $queryType ?>/<?php echo $query ?>"
				}
			);

			var UserLikedQuizzes = Backbone.Collection.extend(
				{
					model: Quiz,
					url: "<?php echo base_url() ?>index.php/QuizController/userLikedQuizzes"
				}
			);

			var quiz = new Quiz();
			var quizzes = new Quizzes();
			var userLikedQuizzes = new UserLikedQuizzes();
			var likedQuizzes = [];
			var ContentAreaView = Backbone.View.extend(
				{
					model: quiz,
					el: $('#contentArea'),
					events: {
						"click .quizButton": "selectCategoryEvent",
						"click #likeButton": "likeButtonEvent"
					},
					initialize: function () {
						quizzes.fetch({ async: false });
						userLikedQuizzes.fetch({ async: false });
						this.render();
					},
					render: function () {

						$("#buttonArea").empty();
						likedQuizzes = [];

						userLikedQuizzes.each(function (quiz) {
							likedQuizzes.push(quiz.get('quizId'));
						});

						if (quizzes.length == 0) {
							$("#buttonArea").append("<h2>No results found</h2>");
						}

						quizzes.each(function (quiz) {
							var button =
								`<div class='container quizArea'>
									<div class='row'>
										<button type='button' class='quizButton' data-quiz=`+ quiz.get('quizId') + `> 
											<div class='titleArea'><h2>` + quiz.get('title') + `</h2></div>
										</button>
									</div>
										<div class='row bottomArea'>
										<div class='col-sm-6'>
											<p id="numberLikesTagStyle">`+ quiz.get('numberOfLikes') + ` Likes</p>
										</div>
										<div class='col-sm-6'>
											<button id="likeButton" data-id='`+ quiz.get('quizId') + `'>` + (likedQuizzes.includes(quiz.get('quizId')) ? `
												<img src="<?php echo base_url() ?>/application/resource/redHeart.png" alt="like">`:
									`<img src="<?php echo base_url() ?>/application/resource/heart.png" alt="unlike">`) + `
											</button>
										</div>
									</div>
								</div>`;
							$("#buttonArea").append(button);
						})
					},

					selectCategoryEvent: function (event) {
						var quizId = $(event.currentTarget).data('quiz');
						document.location.href = "<?php echo base_url() ?>index.php/quizController/QuizView/" + quizId;
					},

					likeButtonEvent: function (event) {
						var quizId = $(event.currentTarget).data('id');
						var vote = "like";
						if (likedQuizzes.includes(quizId.toString())) {
							vote = "unlike";
						}
						quiz.save({
							"vote": vote,
							"quizId": quizId
						},
							{
								success: function () {
									contentArea.initialize()
								}
							})
					}
				}
			)

			var contentArea = new ContentAreaView();
		});
	</script>









	<!-- <script language="Javascript">
		$(document).ready(function () {

			var category = "food";
			var Quiz = Backbone.Model.extend({
				// url: function () {s
				// 	return "<?php echo base_url() ?>index.php/Celebs/celeb?name=";
				// },
				idAttribute: "quizId",
				defaults: {
					title:null,
					numberOfLikes:null
				}
			});

			var Quizzes = Backbone.Collection.extend(
				{
					model : Quiz,
					url: "<?php echo base_url() ?>index.php/QuizController/quiz?"+category
				}
			)

			// create collections object
			var quizzes = new Quizzes();

			var ContentAreaView = Backbone.View.extend(
				{
					model: quizzes, // connect view to collections object
					el : $('#contentArea'), // connect view to page area
					events : {
						// "click #categoryButton" : "selectCategoryEvent"
					},
					initialize : function () {
						quizzes.fetch({async:false});
						console.log(quizzes);
						this.render();
					},
					render : function () {
						var self = this;
							// categories.each(function (c) {
							// 	console.log(c.get('category'));
							// 	var button = "<button type='button' id='categoryButton'>" + c.get('category')  + "</button>";
							// 	$( "#buttonArea" ).append(button);
							// })
					},
					selectCategoryEvent : function (event) {
						// document.location.href = "<?php echo base_url() ?>index.php/userAuthentication/home";
						// location.href='https://google.com';
						// window.location.pathname = ('/newpage.html')
						// $('.cname').remove()
						// $(event.currentTarget).parent().append("<div class='cname'>"
						// 	+ celebs.get(event.currentTarget.id).get('name') + " is <br/>"
						// 	+ celebs.get(event.currentTarget.id).get('age') + " years old"
						// 	+ "</div>")
					}
				}
			)
		});
		// 	var contentArea = new ContentAreaView();
		// });
		</script> -->

</body>

</html>
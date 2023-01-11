<!DOCTYPE html>
<html lang="en">

<head>
	<title>Quizoo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<style>
		.row {
			padding-top: .5%;
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

		.wrapper {
			display: grid;
			grid-template-columns: repeat(5, 1fr);
			gap: 10px;
			grid-auto-rows: minmax(50px, auto);
		}

		.tagStyle {
			background-color: #F0EFFF;
			text-align: center
		}

		select {
			height: 30px;
			padding-left: 10px
		}

		#cancelButtonStyle {
			background-color: grey;
		}

		#errorMessage {
			color: red
		}

		.questionContainer {
			background-color: #F0EFFF;
			margin-top: 2%;
			padding: 1%
		}

		.titleStyle {
			text-align: center;
		}

		.buttonRowStyle {
			margin-top: 15px;
		}
	</style>
</head>

<body>
	<div class="contentArea" id="contentArea">
		<div class="container">
			<div class='row titleStyle'>
				<h1>Create Quiz</h1>
			</div>
			<div class='row'>
				<div class="col-md-2">
					<h4>Title:</h4>
				</div>
				<div class="col-md-9 input-style">
					<input class="form-control rounded" placeholder="Enter a title" aria-label="title" id="title" />
				</div>
			</div>
			<div class='row'>
				<div class="col-md-2">
					<h4>Category:</h4>
				</div>
				<div class="col-md-10 input-style dropdown">
					<select name="category" id="category">
						<option value="other">Other</option>
						<option value="food">Food</option>
						<option value="education">Education</option>
						<option value="transport">Transport</option>
						<option value="health">Health</option>
						<option value="travel">Travel and Hospitality</option>
						<option value="technology">Technology</option>
						<option value="agriculture">Agriculture</option>
						<option value="commerce">Commerce</option>
						<option value="environment">Environment</option>
					</select>
				</div>
			</div>
			<div class='row'>
				<div class="col-md-2">
					<h4>Tags:</h4>
				</div>
				<div class="col-md-2 input-style">
					<input class="form-control rounded" placeholder="Enter a tag" aria-label="enter tag" id="tag" />
				</div>
				<div class="col-md-1">
					<button type="button" class="btn btn-outline-primary" id="addTag">Add</button>
				</div>
				<div id="tagArea" class="col-md-7 wrapper">
				</div>
			</div>
		</div>

		<div id="questionAnswersArea"></div>

		<div class="container">
			<div class="row buttonRowStyle">
				<div class='col-md-8' id="errorMessage"></div>
				<div class='col-md-1'>
					<button type="button" onClick="window.location.href = '<?php echo base_url() ?>index.php';"
						id="cancelButtonStyle">
						Cancel
					</button>
				</div>
				<div class='col-md-2'>
					<button type="button" id="addQuestion">
						Add Question
					</button>
				</div>
				<div class='col-md-1'>
					<button type="button" id="finish">
						Finish
					</button>
				</div>
			</div>
		</div>

	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>

	<script language="Javascript">
		$(document).ready(function () {

			var Quiz = Backbone.Model.extend({
				url: function () {
					return "<?php echo base_url() ?>index.php/QuizController/quiz";
				},
				idAttribute: "quizId",
				defaults: {
					quizId: null,
					title: null,
					category: null,
					numberOfLikes: null,
					authorId: null
				}
			});

			var quiz = new Quiz();

			var tagObjects = [];
			var tagCount = 1;
			var questionCount = 1;
			var questionIndexes = [];
			var questions = [];

			var ContentAreaView = Backbone.View.extend(
				{
					model: quiz,
					el: $('#contentArea'),
					events: {
						"click #addQuestion": "addQuestionEvent",
						"click #finish": "finishEvent",
						"click #addTag": "addTagEvent",
						"click .removeTag": "removeTagEvent",
						"click .removeQuestion": "removeQuestionEvent"
					},
					initialize: function () {
						this.addQuestionEvent()
					},
					render: function () {
					},

					addQuestionEvent: function (event) {
						questionIndexes.push(questionCount);

						$("#questionAnswersArea").append(
							`<div class="container questionContainer" id="questionContainer` + questionCount + `">
								<div class='row' style="float:right">
									<div class="col-md-10">	</div>
									<div class="col-md-1 input-style">
										<button class="removeQuestion" id="remove`+ questionCount + `" data-question=` + questionCount + `>X</button>
									</div>
								</div>

								<div class='row'>
									<div class="col-md-2">
										<h4>Question:</h4>
									</div>
									<div class="col-md-9 input-style">
										<input class="form-control rounded" placeholder="Enter a question" id="question`+ questionCount + `" aria-label="question"/>    
									</div>
								</div>
				
								<div class='row'>
									<div class="col-md-2">
										<h4>Answer A:</h4>
									</div>
									<div class="col-md-9 input-style">
										<input class="form-control rounded" placeholder="Enter a answer" aria-label="answerA" id="answerA`+ questionCount + `"/>    
									</div>		
									<div class="col-md-1 input-style">
										<input type="radio" id="answerA" name="answer`+ questionCount + `" value="a">
									</div>
								</div>
				
								<div class='row'>
									<div class="col-md-2">
										<h4>Answer B:</h4>
									</div>
									<div class="col-md-9 input-style">
										<input class="form-control rounded" placeholder="Enter a answer" aria-label="answerB" id="answerB`+ questionCount + `"/> 
									</div>
									<div class="col-md-1 input-style">
										<input type="radio" id="answerB" name="answer`+ questionCount + `" value="b">
									</div>
								</div>
								<div class='row'>
									<div class="col-md-2">
										<h4>Answer C:</h4>
									</div>
									<div class="col-md-9 input-style">
										<input class="form-control rounded" placeholder="Enter a answer" aria-label="answerC" id="answerC`+ questionCount + `"/>    
									</div>
									<div class="col-md-1 input-style">
										<input type="radio" id="answerC" name="answer`+ questionCount + `" value="c">
									</div>
								</div>
								<div class='row'>
									<div class="col-md-2">
										<h4>Answer D:</h4>
									</div>
									<div class="col-md-9 input-style">
										<input class="form-control rounded" placeholder="Enter a answer" aria-label="answerD" id="answerD`+ questionCount + `"/>    
									</div>
									<div class="col-md-1 input-style">
										<input type="radio" id="answerD" name="answer`+ questionCount + `" value="d">
									</div>
								</div>
							</div>`
						);
						questionCount = questionCount + 1;

					},

					finishEvent: function (event) {
						$("#errorMessage").empty();
						if ($("#title").val() === '') {
							$("#errorMessage").append('<h4>Please fill in the title</h5>');
							return;
						}
						if (questionIndexes.length == 0) {
							$("#errorMessage").append('<h4>There needs to be at least one question for a quiz to be created</h5>');
							return;
						}
						var isAllCompleted = true;
						questionIndexes.forEach(function (index) {
							if ($("#question" + index).val() && $("#answerA" + index).val() && $("#answerB" + index).val() && $("#answerC" + index).val() && $("#answerD" + index).val() && $("input[type='radio'][name='answer" + index + "']:checked").val()) {
								var questionAnswer = {
									question: $("#question" + index).val(),
									answerA: $("#answerA" + index).val(),
									answerB: $("#answerB" + index).val(),
									answerC: $("#answerC" + index).val(),
									answerD: $("#answerD" + index).val(),
									correctAnswer: $("input[type='radio'][name='answer" + index + "']:checked").val()
								};
								questions.push(questionAnswer);
							}
							else {
								isAllCompleted = false;
								$("#errorMessage").empty();
								$("#errorMessage").append('<h4>Please fill in all question and answer fields and select a correct answer for all questions</h5>');
							}
						});

						if (isAllCompleted) {
							let tags = tagObjects.map(({ tag }) => tag);
							quiz.save({
								"title": $("#title").val(),
								"category": $("#category").val(),
								"tags": tags,
								"questionAnswers": questions
							});
							window.location.href = '<?php echo base_url() ?>index.php';
						}
					},
					addTagEvent: function (event) {
						var newTag = $("#tag").val().toLowerCase().trim();
						if (newTag) {
							tagObjects.push({ "tag": newTag, "id": tagCount });
							$("#tagArea").append('<div class="tagStyle" id="tagDiv' + tagCount + '"><p>' + newTag + '</p><button id="' + tagCount + '" class="removeTag" data-tag="' + tagCount + '">X</button></div>');
							tagCount = tagCount + 1;
						}
					},
					removeTagEvent: function (event) {
						var tagNumber = $(event.currentTarget).data('tag');
						const indexOfObject = tagObjects.findIndex(object => {
							return object.id === tagNumber;
						});
						tagObjects.splice(indexOfObject, 1);
						$("#tagDiv" + tagNumber).remove();
					},
					removeQuestionEvent: function (event) {
						var questionId = $(event.currentTarget).data('question');
						const removingIndex = questionIndexes.indexOf(questionId);
						questionIndexes.splice(removingIndex, 1);
						$("#questionContainer" + questionId).remove();
					}
				}
			);

			var contentView = new ContentAreaView();

		});
	</script>
</body>

</html>
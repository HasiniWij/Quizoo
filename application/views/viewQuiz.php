<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Quizoo</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<style>
		.row{
            padding-top:2%
        }
        .buttonStyle {
                background-color: #4D47C3;
				padding: 6px 15px;
				border: none;
				color: white;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-size: 14px;
				cursor: pointer;
                margin-top:6%;
        }
		.modal {
			display: none; /* Hidden by default */
			position: fixed; /* Stay in place */
			z-index: 1; /* Sit on top */
			left: 0;
			top: 0;
			width: 100%; /* Full width */
			height: 100%; /* Full height */
			overflow: auto; /* Enable scroll if needed */
			background-color: rgb(0,0,0); /* Fallback color */
			background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
		}

		/* Modal Content/Box */
		.modal-content {
			background-color: #fefefe;
			margin: 15% auto; /* 15% from the top and centered */
			padding: 20px;
			border: 1px solid #888;
			width: 60%; /* Could be more or less, depending on screen size */
		}


		</style>
    </head>
    <body style="background-color:#D3D2D0">
	<div class="container" id="contentArea" >
		
        <div class='row' style="text-align: center; padding-top:3%" id="title"></div>
        <div class='row' style="text-align: center; " id="question"></div>
		<input type="radio" id="answerA" name="answer" value="a">
		<div id="answerAArea">
		
		</div>
		
		<input type="radio" id="answerB" name="answer" value="b">
		<div id="answerBArea">
		</div>
		
		<input type="radio" id="answerC" name="answer" value="c">
		<div id="answerCArea">
		</div>
		<input type="radio" id="answerD" name="answer" value="d">
		<div id="answerDArea">
		</div>

        <!-- <div class="btn-group btn-group-toggle" data-toggle="buttons">
            
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="answerB" autocomplete="off"> 
            </label>
            <div>
                <label class="btn btn-secondary">
                    <input type="radio" name="options" id="answerC" autocomplete="off"> 
                 </label>
                 <label class="btn btn-secondary">
                    <input type="radio" name="options" id="answerD" autocomplete="off"> 
                 </label>
            </div>
        </div> -->
      
		<div class='row'>
            <div class='col-md-6'>
              
            </div>
            <div class='col-md-2'>
                <button type="button" class="buttonStyle" id="cancel">
                    Exit quiz
                </button>
            </div>
            <div class='col-md-2'>
                <button type="button" class="buttonStyle" id="getResult">
                    Continue
				</button>
            </div>
        </div>
		
		<div id="myModal" class="modal">
			<div class="modal-content" style="text-align: center; ">
				<div id="resultModal">

				</div>
				<button type="button" class="buttonStyle" id="nextQuestion">
						Next
				</button>
			</div>
		</div>
	</div>



		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
		
		<script language="Javascript">
			var modal = document.getElementById("myModal");

			// Get the button that opens the modal
			var btn = document.getElementById("getResult");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks on the button, open the modal
			btn.onclick = function() {
			modal.style.display = "block";
			}

		$(document).ready(function () {
			var Quiz = Backbone.Model.extend({
				url: function () {
					return "<?php echo base_url() ?>index.php/QuizController/quiz/id/<?php echo $quizId ?>";
				},
				idAttribute: "quizId",
				defaults: {
					quizId: null,
                    title:null,
                    questionAnswers:null

				}
			});
			var User = Backbone.Model.extend({
				url: function () {
					return "<?php echo base_url() ?>index.php/userAuthentication/score/"+score;
				},
				idAttribute: "userId",
				defaults: {
					score: null,

				}
			});

		

			var user = new User();
			var quiz = new Quiz();
            var questionNumber = 1;
			var score = 0;

			function appendQuestion(){
				$( "#question" ).empty();
				$( "#answerAArea" ).empty();
				$( "#answerBArea" ).empty();
				$( "#answerCArea" ).empty();
				$( "#answerDArea" ).empty();
				$( "#question" ).append("<h3>"+ quiz.get('questionAnswers')[questionNumber-1].question  + "</h3>");
                $( "#answerAArea" ).append( "<h3>"+ quiz.get('questionAnswers')[questionNumber-1].answerA + "</h3>");
                $( "#answerBArea" ).append( "<h3>"+ quiz.get('questionAnswers')[questionNumber-1].answerB + "</h3>");
                $( "#answerCArea" ).append( "<h3>"+ quiz.get('questionAnswers')[questionNumber-1].answerC + "</h3>");
                $( "#answerDArea" ).append( "<h3>"+ quiz.get('questionAnswers')[questionNumber-1].answerD + "</h3>");
						
			};
			var ContentAreaView = Backbone.View.extend(
				{
					model: quiz, // connect view to collections object
					el : $('#contentArea'), // connect view to page area
					events : {
						"click #getResult" : "getResultEvent",
						"click #nextQuestion" : "nextQuestionEvent",
						"click #cancel":"cancelEvent"
					},
					initialize : function () {
						quiz.fetch({async:false});
						console.log(quiz);
						this.render();
					},
					render : function () {
						var self = this;
                        $( "#title" ).append( "<h1>"+ quiz.get('title') + "</h1>");
						appendQuestion();
					},
					getResultEvent : function (event) {
						$( "#resultModal" ).empty();
						console.log("in");
						console.log(quiz.get('questionAnswers')[questionNumber-1].correctAnswer)
						console.log($("input[type='radio'][name='answer']:checked").val())
						if(quiz.get('questionAnswers')[questionNumber-1].correctAnswer == $("input[type='radio'][name='answer']:checked").val()){
							$( "#resultModal" ).append( `<h2>Congratulations you got it!</h2>
				<div style="display: flex;
				align-items: center;
				justify-content: center;">
					<img src="<?php echo base_url() ?>/application/resource/correct.png" alt="correct">
				</div>`);
				score=score+1;
						}
						else{
							$( "#resultModal" ).append( `
							<h2>Oops! Wrong answer</h2>
							<p>Correct answer:</p>
				<div style="display: flex;
				align-items: center;
				justify-content: center;">
				
					<img src="<?php echo base_url() ?>/application/resource/wrong.png" alt="wrong">
				</div>`);
						}
						$('#myInput').trigger('focus');
                        questionNumber=questionNumber+1;
					},
					nextQuestionEvent: function (event){
						console.log(quiz.get('questionAnswers').length);
						console.log(questionNumber);
						if(quiz.get('questionAnswers').length<questionNumber){
							user.save();
							window.location.href = '<?php echo base_url()?>index.php/QuizController/finishQuiz/'+score;
							console.log("finish")
							console.log(score)
						}
						else{
							appendQuestion();
						}
						
						modal.style.display = "none";

					},
					cancelEvent: function (event){
						window.location.href = '<?php echo base_url()?>index.php/userAuthentication/home';
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
						// document.location.href = "<?php echo base_url()?>index.php/userAuthentication/home";
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
	<!-- Button trigger modal -->

    </body>
    </html>
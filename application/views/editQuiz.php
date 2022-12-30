<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>iLikeCatz</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<style>
            .input-style{
                /* padding-top: 20px; */
            }
			.row{
				padding-top:.5%;
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
                margin-top:6%;
            }
		</style>
    </head>
    <body>
    <div class="contentArea" id="contentArea">
		<div class="container">
			<div class='row'>
				<h1>Create Quiz</h1>
			</div>
			<div class='row'>
				<div class="col-md-2">
					<h4>Title:</h4>
				</div>
				<div class="col-md-9 input-style">
					<input class="form-control rounded" placeholder="Enter a title" aria-label="title" id="title"/>    
				</div>
			</div>
			<div class='row'>
				<div class="col-md-2">
					<h4>Category:</h4>
				</div>
				<div class="col-md-10 input-style dropdown">
					<select name="category" id="category" style="height:30px; padding-left:10px">
						<option value="food">Food</option>
						<option value="education">Education</option>
						<option value="transport">Transport</option>
						<option value="health">Health</option>
						<option value="travel">Travel and Hospitality</option>
						<option value="technology">Technology</option>
						<option value="agriculture">Agriculture</option>
						<option value="commerce">Commerce</option>
						<option value="environment">Environment</option>
						<option value="other">Other</option>
					</select>
				</div>
			</div>
			<div class='row'>
				<div class="col-md-2">
					<h4>Tags:</h4>
				</div>
				<div class="col-md-2 input-style">
					<input class="form-control rounded" placeholder="Enter a tag" aria-label="enter tag"/>    
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-outline-primary" id="addTag">Add</button>
				</div>
			</div>
		</div>

		<div id="questionAnswersArea">
		<div class="container" id="questionContainer" style="background-color: #F0EFFF; margin-top:2%; padding:1%">
        <div class='row'>
            <div class="col-md-2">
                <h4>Question:</h4>
            </div>
            <div class="col-md-9 input-style">
                <input class="form-control rounded" placeholder="Enter a question" aria-label="question"/>    
            </div>
        </div>
        <div class='row'>
            <div class="col-md-2">
                <h4>Answer A:</h4>
            </div>
            <div class="col-md-9 input-style">
                <input class="form-control rounded" placeholder="Enter a answer" aria-label="answerA"/>    
            </div>
            <div class="col-md-1 input-style">
                <input type="radio" id="answerA" name="answer" value="answerA">
            </div>
        </div>
        <div class='row'>
            <div class="col-md-2">
                <h4>Answer B:</h4>
            </div>
            <div class="col-md-9 input-style">
                <input class="form-control rounded" placeholder="Enter a answer" aria-label="answerB"/> 
            </div>
            <div class="col-md-1 input-style">
                <input type="radio" id="answerB" name="answer" value="answerB">
            </div>
        </div>
        <div class='row'>
            <div class="col-md-2">
                <h4>Answer C:</h4>
            </div>
            <div class="col-md-9 input-style">
                <input class="form-control rounded" placeholder="Enter a answer" aria-label="answerC"/>    
            </div>
            <div class="col-md-1 input-style">
                <input type="radio" id="answerC" name="answer" value="answerC">
            </div>
        </div>
        <div class='row'>
            <div class="col-md-2">
                <h4>Answer D:</h4>
            </div>
            <div class="col-md-9 input-style">
                <input class="form-control rounded" placeholder="Enter a answer" aria-label="answerD"/>    
            </div>
            <div class="col-md-1 input-style">
                <input type="radio" id="answerD" name="answer" value="answerD">
            </div>
        </div>
		</div>
		</div>
		
		<div class="container">
			<div class="row" style="float:right">
			<div class='col-md-3'>
                    <button type="button" onClick="window.location.href = '<?php echo base_url()?>index.php/userAuthentication/home';" style="background-color:grey;">
						Cancel
					</button>
                </div>
				<div class='col-md-6'>
                    <button type="button" id="addQuestion">
						Add Question
					</button>
                </div>
				<div class='col-md-3'>
                    <button type="button" id="finish" >
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
					quizId:null,
					title: null,
					category: null,
					numberOfLikes: null,
					authorId:null
				}
			});

			var quiz = new Quiz();

			var ContentAreaView = Backbone.View.extend(
				{
					model: quiz, // connect view to collections object
					el : $('#contentArea'), // connect view to page area
					events : {
						"click #addQuestion" : "addQuestionEvent",
						"click #finish" : "finishEvent",
						"click #addTag" : "addTagEvent"
					},
					initialize : function () {
						// user.fetch({async:false});
						// this.emailView = new EmailArea();
						// this.usernameAreaView = new UsernameAreaView();
						this.render();
					},
					render : function () {
						// this.emailView.setElement(this.$('#emailArea')).render();
					//    var self = this;
                    //    var userDetails = "<div class='row'><div class='col-md-2'><h3>Email:</h3></div><div class='col-md-6'> <h3>"+ 
                    //    user.get('email') +
                    //    "</h3> </div> </div>  <div class='row'> <div class='col-md-2'> <h3>Username:</h3>  </div> <div class='col-md-6'> <h3>"+
                    //    user.get('username') + "</h3>  </div></div>"+" <div class='row'> <div class='col-md-2'> <h3>Score:</h3>  </div> <div class='col-md-6'> <h3>"+
                    //    user.get('score') + "</h3>  </div></div>"
					//    self.$el.append(userDetails)
					},
					addQuestionEvent : function (event) {
						alert("add quiz");
						$( "questionContainer" ).appendTo( $( "#questionAnswersArea" ) );
						
					},
					finishEvent : function (event) {
						quiz.save({
							"title": $("#title").val(),
							"category": $("#category").val(),
						});
						// alert("add finish");
						
					},
					addTagEvent : function (event) {alert("cancel");}
				}
			);
		
			var contentView = new ContentAreaView();
			
		});
		</script>
    </body>
 </html>
	
<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Quizoo</title>
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
			.wrapper {
				display: grid;
				grid-template-columns: repeat(5, 1fr);
				gap: 10px;
				grid-auto-rows: minmax(50px, auto);
			}
			.tagStyle{
				background-color:#F0EFFF;text-align: center
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
					<input class="form-control rounded" placeholder="Enter a tag" aria-label="enter tag" id="tag"/>    
				</div>
				<div class="col-md-1">
					<button type="button" class="btn btn-outline-primary" id="addTag">Add</button>
				</div>
				<div id="tagArea" class="col-md-7 wrapper">
				</div>
			</div>
		</div>



		<!-- <div class="container" id="questionContainer" style="background-color: #F0EFFF; margin-top:2%; padding:1%">
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
		</div> -->



		<div id="questionAnswersArea">

		</div>
		
		<div class="container">
			<div class="row">
				<div class='col-md-8' id="errorMessage"></div>
				<div class='col-md-1'>
                    <button type="button" onClick="window.location.href = '<?php echo base_url()?>index.php/userAuthentication/home';" style="background-color:grey;">
						Cancel
					</button>
                </div>
				<div class='col-md-2'>
                    <button type="button" id="addQuestion">
						Add Question
					</button>
                </div>
				<div class='col-md-1'>
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
			var tagObjects = [];
			var tagCount = 1;
			var questionCount = 1;
			var questionIndexes=[];
			var questions= [];

			var ContentAreaView = Backbone.View.extend(
				{
					model: quiz, // connect view to collections object
					el : $('#contentArea'), // connect view to page area
					events : {
						"click #addQuestion" : "addQuestionEvent",
						"click #finish" : "finishEvent",
						"click #addTag" : "addTagEvent",
						"click .removeTag" : "removeTagEvent",
						"click .removeQuestion" : "removeQuestionEvent"
					},
					initialize : function () {
						var id="19";
						if(id){
							quiz.fetch({'id':id});
						}
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
						questionIndexes.push(questionCount);
					
						$( "#questionAnswersArea" ).append( 
						`<div class="container" id="questionContainer`+questionCount+`" style="background-color: #F0EFFF; margin-top:2%; padding:1%">
		
						<div class='row'>
				<div class="col-md-10">
					<h4>`+questionCount+`</h4>
				</div>
				<div class="col-md-1 input-style">
					<button class="removeQuestion" id="remove`+questionCount+`" data-question=`+questionCount+`>X</button>
				</div>
			</div>

						<div class='row'>
				<div class="col-md-2">
					<h4>Question:</h4>
				</div>
				<div class="col-md-9 input-style">
					<input class="form-control rounded" placeholder="Enter a question" id="question`+questionCount+`" aria-label="question"/>    
				</div>
			</div>
			<div class='row'>
				<div class="col-md-2">
					<h4>Answer A:</h4>
				</div>
				<div class="col-md-9 input-style">
					<input class="form-control rounded" placeholder="Enter a answer" aria-label="answerA" id="answerA`+questionCount+`"/>    
				</div>				<div class="col-md-1 input-style">
					<input type="radio" id="answerA" name="answer`+questionCount+`" value="answerA">
				</div>
			</div>
			<div class='row'>
				<div class="col-md-2">
					<h4>Answer B:</h4>
				</div>
				<div class="col-md-9 input-style">
					<input class="form-control rounded" placeholder="Enter a answer" aria-label="answerB" id="answerB`+questionCount+`"/> 
				</div>
				<div class="col-md-1 input-style">
					<input type="radio" id="answerB" name="answer`+questionCount+`" value="answerB">
				</div>
			</div>
			<div class='row'>
				<div class="col-md-2">
					<h4>Answer C:</h4>
				</div>
				<div class="col-md-9 input-style">
					<input class="form-control rounded" placeholder="Enter a answer" aria-label="answerC" id="answerC`+questionCount+`"/>    
				</div>
				<div class="col-md-1 input-style">
					<input type="radio" id="answerC" name="answer`+questionCount+`" value="answerC">
				</div>
			</div>
			<div class='row'>
				<div class="col-md-2">
					<h4>Answer D:</h4>
				</div>
				<div class="col-md-9 input-style">
					<input class="form-control rounded" placeholder="Enter a answer" aria-label="answerD" id="answerD`+questionCount+`"/>    
				</div>
				<div class="col-md-1 input-style">
					<input type="radio" id="answerD" name="answer`+questionCount+`" value="answerD">
				</div>
			</div>
		</div>`);
		questionCount=questionCount+1;
						// alert("add quiz");
						// $( "#questionContainer" ).appendTo(  "#questionAnswersArea" );
						// $( "span" ).appendTo( "#foo" );
						// $("h1").appendTo("p");
						
					},
					finishEvent : function (event) {
						console.log("finish");
						$( "#errorMessage" ).empty();
						console.log($("#title").val());
						if($("#title").val()===''){
							$( "#errorMessage" ).append('<h4 style="color:red">Please fill in the title</h5>');
							console.log('no title');
							return;
						}
						var isAllCompleted = true;
						questionIndexes.forEach(function(index) {
							if($("#question"+index).val() && $("#answerA"+index).val() && $("#answerB"+index).val()&&$("#answerC"+index).val()&&$("#answerD"+index).val()&&$("input[type='radio'][name='answer"+index+"']:checked").val()){
							var questionAnswer = {
								questionNumber:index,
								question:$("#question"+index).val(),
								answerA:$("#answerA"+index).val(),
								answerB:$("#answerB"+index).val(),
								answerC:$("#answerC"+index).val(),
								answerD:$("#answerD"+index).val(),
								correctAnswer:$("input[type='radio'][name='answer"+index+"']:checked").val()
							};
							questions.push(questionAnswer);
							console.log(' question');
							}
							else{
								console.log('no question');
								isAllCompleted = false;
								$( "#errorMessage" ).empty();
								$( "#errorMessage" ).append('<h4 style="color:red">Please fill in all question and answer fields and select a correct and for all questions</h5>');
								// return;
							}
						});
					
						if(isAllCompleted){
						let tags = tagObjects.map(({ tag }) => tag);
							quiz.save({
							"title": $("#title").val(),
							"category": $("#category").val(),
							"tags":tags,
							"questionAnswers":questions
						});
						window.location.href = '<?php echo base_url()?>index.php/userAuthentication/home';
						}
						
						
					},
					addTagEvent : function (event) {
						console.log("Add tag");
						var newTag = $("#tag").val().toLowerCase();
						if(newTag){
							tagObjects.push({"tag":newTag,"id":tagCount});
							$( "#tagArea" ).append( '<div class="tagStyle" id="tagDiv'+tagCount+'"><p>'+newTag+'</p><button id="'+tagCount+'" class="removeTag" data-tagnum="'+tagCount+'">X</button></div>' );
							tagCount=tagCount+1;
							console.log(tagObjects);
						}
					},
					removeTagEvent : function (event) {
						// console.log()
						// document.getElementById("demo").remove();
						// $( "#tagDiv1" ).remove();
						
						var tagNumber = $(event.currentTarget).data('tagnum');
						console.log(tagNumber);
						const indexOfObject = tagObjects.findIndex(object => {
							return object.id === tagNumber;
						});
						tagObjects.splice(indexOfObject, 1);
						$( "#tagDiv"+tagNumber ).remove();
						console.log(tagObjects);

						// alert("HI");
					},
					removeQuestionEvent : function (event) {
						var questionId = $(event.currentTarget).data('question');
						// console.log(index);
						const removingIndex = questions.findIndex(object => {
							return object.questionNumber === questionId;
						});
						questions.splice(removingIndex, 1);

						$( "#questionContainer"+questionId ).remove();
						// console.log(tagObjects);
					}
				}
			);
		
			var contentView = new ContentAreaView();
			
		});
		</script>
    </body>
 </html>
	
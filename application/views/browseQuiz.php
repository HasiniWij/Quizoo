<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Quizoo</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<style>
			#categoryButton{
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
		</style>
    </head>
    <body>
	<div class="container" id="contentArea">
		<div class='row' style="text-align: center; padding-top:5%">
	       	<h1>Browse</h1>
		</div>
		<div id="buttonArea"></div>	
	</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
		<script language="Javascript">
		$(document).ready(function () {
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
					url: "<?php echo base_url() ?>index.php/QuizController/quiz"
				}
			)

			// create collections object
			var quizzes = new Quizzes();

			var ContentAreaView = Backbone.View.extend(
				{
					model: categories, // connect view to collections object
					el : $('#contentArea'), // connect view to page area
					events : {
						"click #categoryButton" : "selectCategoryEvent"
					},
					initialize : function () {
						categories.fetch({async:false});
						console.log(categories);
						this.render();
					},
					render : function () {
						var self = this;
							categories.each(function (c) {
								console.log(c.get('category'));
								var button = "<button type='button' id='categoryButton'>" + c.get('category')  + "</button>";
								$( "#buttonArea" ).append(button);
							})
					},
					selectCategoryEvent : function (event) {
						document.location.href = "<?php echo base_url()?>index.php/userAuthentication/home";
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

			var contentArea = new ContentAreaView();
		});
		</script>
			
    </body>
    </html>
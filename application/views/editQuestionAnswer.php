<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>iLikeCatz</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<style>
            .input-style{
                padding-top: 20px;
            }
            .title-style{
                text-align: center;
            }
            .row{
               margin-top: 30px;
            }
		</style>
    </head>
    <body>
    <div class="container">
		<div class='row'>
            <h1 class="title-style">Food Quiz</h1>
        </div>
        <div class='row'>
            <div class="col-md-2">
                <h2>Question:</h2>
            </div>
            <div class="col-md-9 input-style">
                <input class="form-control rounded" placeholder="Enter a question" aria-label="question"/>    
            </div>
        </div>
        <div class='row'>
            <div class="col-md-2">
                <h2>Answer A:</h2>
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
                <h2>Answer B:</h2>
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
                <h2>Answer C:</h2>
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
                <h2>Answer D:</h2>
            </div>
            <div class="col-md-9 input-style">
                <input class="form-control rounded" placeholder="Enter a answer" aria-label="answerD"/>    
            </div>
            <div class="col-md-1 input-style">
                <input type="radio" id="answerD" name="answer" value="answerD">
            </div>
        </div>

        <div class="row">
            <button type="button" class="btn btn-outline-primary">Cancel</button>
            <button type="button" class="btn btn-outline-primary">Back</button>
            <button type="button" class="btn btn-outline-primary">Next</button>
            <button type="button" class="btn btn-outline-primary">Finish</button>
        </div>

       
     
       
       
       
       
        <!-- <div class="col-md-6">
                <h1>Signin to </h1>
				<h2>Quizoo</h2>
				<p>If you dont have a account you can Register here!</p>
            </div>
            <div class="col-md-6">
				<h2>Sign in</h2>
				<input class="form-control rounded" placeholder="Enter email" aria-label="email" aria-describedby="search-addon" />
				<input  class="form-control rounded" placeholder="password" aria-label="password" aria-describedby="search-addon" />
                <button type="button" class="btn btn-outline-primary">Login</button>
            </div> -->
	</div> 
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
		<!-- <script language="Javascript">
		$(document).ready(function () {
			var Celeb = Backbone.Model.extend({
				url: function () {
					var urlstr = 
						"<?php echo base_url() ?>index.php/Celebs/celeb?name="
						+ this.get("name");
					return urlstr;
				},
				idAttribute: "_id",
				defaults: {
					name: null,
					imageurl: null,
					age: null
				}
			});

			var Celebrities = Backbone.Collection.extend(
				{
					model : Celeb,
					url: "http://localhost:8999/6cosc005w/ilikecelebs/index.php/celebs/celeb"
				}
			)

			// create collections object
			var celebs = new Celebrities();

			var ContentAreaView = Backbone.View.extend(
				{
					model: celebs, // connect view to collections object
					el : $('#contentarea'), // connect view to page area
					events : {
						"click img" : "displayEvent"
					},
					initialize : function () {
						// when view object created, we want something to
						// happen to load initial content
						celebs.fetch({async:false})
						this.render()
					},
					render : function () {
						// display content
						var self = this;
						celebs.each(function (c) {
							var cimg = "<div class='celebimg'><img id='" + c.get('_id') + "' src='" + c.get('imageurl') + "'>"
							self.$el.append(cimg)
						})
					},
					displayEvent : function (event) {
						$('.cname').remove()
						$(event.currentTarget).parent().append("<div class='cname'>"
							+ celebs.get(event.currentTarget.id).get('name') + " is <br/>"
							+ celebs.get(event.currentTarget.id).get('age') + " years old"
							+ "</div>")
					}
				}
			)

			var contentview = new ContentAreaView();
		}); -->
		</script>
			
    </body>
    </html>
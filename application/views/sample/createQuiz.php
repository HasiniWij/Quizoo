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
		</style>
    </head>
    <body>
    <div class="container">
		<div class='row'>
            <h1>Create Quiz</h1>
        </div>
        <div class='row'>
            <div class="col-md-2">
                <h2>Title:</h2>
            </div>
            <div class="col-md-10 input-style">
                <input class="form-control rounded" placeholder="Enter a title" aria-label="title"/>    
            </div>
        </div>
        <div class='row'>
            <div class="col-md-2">
                <h2>Category:</h2>
            </div>
            <div class="col-md-10 input-style dropdown">
                <select name="category" id="category">
                    <option value="Food">Food</option>
                    <option value="Education">Education</option>
                    <option value="Transport">Transport</option>
                    <option value="Health">Health</option>
                    <option value="Travel">Travel and Hospitality</option>
                    <option value="Technology">Technology</option>
                    <option value="Agriculture">Agriculture</option>
                    <option value="Commerce">Commerce</option>
                    <option value="Environment">Environment</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class="col-md-2">
                <h2>Tags:</h2>
            </div>
            <div class="col-md-10 input-style">
                <input class="form-control rounded" placeholder="Enter a tag" aria-label="enter tag"/>    
                <button type="button" class="btn btn-outline-primary">Add</button>
            </div>
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
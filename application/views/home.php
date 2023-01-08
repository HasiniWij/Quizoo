<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Quizoo</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<style>
			body { padding-top: 70px; } /* needed to position navbar properly */
			.celebimg {
				float:left;
				padding:10px;
				height: 260px;
			}
			img {
				height: 60px;
				width:60px;
				padding-right:5px;
			}
		</style>
    </head>
    <body>
	<div class="container" id="contentview">
			
			<div class='row' style="margin-right: -9.9%">
				<div class='col-md-3' style="float:left;">
					<a href="#">
                		<img src="<?php echo base_url() ?>/application/resource/logo.png" alt="profile">
            		</a>
				</div>
				<div class='col-md-5' style="float:right ;">
					<a href="<?php echo base_url()?>index.php/userAuthentication/leaderbord">
                		<img src="<?php echo base_url() ?>/application/resource/score.png" alt="score">
            		</a>
					<a href="<?php echo base_url()?>index.php/quizController/editQuiz">
                		<img src="<?php echo base_url() ?>/application/resource/editQuiz.png" alt="editQuiz">
            		</a>
					<a href="<?php echo base_url()?>index.php/userAuthentication/profile">
                		<img src="<?php echo base_url() ?>/application/resource/profile.png" alt="profile">
            		</a>
					<a href="<?php echo base_url()?>index.php/SearchQuizController/browse">
                		<img src="<?php echo base_url() ?>/application/resource/browse.png" alt="browse">
            		</a>
					<a href="<?php echo base_url()?>index.php/userAuthentication/logout">
                		<img src="<?php echo base_url() ?>/application/resource/logout.png" alt="logout">
            		</a>
				</div>
			</div>


			<div class='row' style="text-align: center; padding-top:10%">
	        	<h1>Quizoo</h1>
			</div>
			<div class='row' style="text-align: center;margin-top:0px;">
				<h2>Search for fun quizzes </h2>
			</div>
			<div class='row' style="margin-left:35%">
				<div class='col-md-6'>
					<input type="search" class="form-control rounded" placeholder="Search quizzes by a tag or category" aria-label="Search" aria-describedby="search-addon" id="keywords"/>
				</div>
				<div class='col-md-6'>
					<button type="button" id="searchButton" style="  
					background-color: #4D47C3;
					padding: 6px 15px;
					border: none;
					color: white;
					text-align: center;
					text-decoration: none;
					display: inline-block;
					font-size: 14px;
					cursor: pointer;">
						Search
					</button>
				</div>
			</div>
	</div> <!-- container -->
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
		<script language="Javascript">
		$(document).ready(function () {
			// var Celeb = Backbone.Model.extend({
			// 	url: function () {s
			// 		var urlstr = 
			// 			"<?php echo base_url() ?>index.php/Celebs/celeb?name="
			// 			+ this.get("name");
			// 		return urlstr;
			// 	},
			// 	idAttribute: "_id",
			// 	defaults: {
			// 		name: null,
			// 		imageurl: null,
			// 		age: null
			// 	}
			// });

			// var Celebrities = Backbone.Collection.extend(
			// 	{
			// 		model : Celeb,
			// 		url: "http://localhost:8999/6cosc005w/ilikecelebs/index.php/celebs/celeb"
			// 	}
			// )

			// create collections object
			// var celebs = new Celebrities();

			var ContentAreaView = Backbone.View.extend(
				{
					// model: celebs, // connect view to collections object
					el : $('#contentview'), // connect view to page area
					events : {
						"click #searchButton" : "searchButtonEvent"
					},
					initialize : function () {
						// when view object created, we want something to
						// happen to load initial content
						// celebs.fetch({async:false})
						// this.render()
					},
					render : function () {
						// display content
						// var self = this;
						// celebs.each(function (c) {
						// 	var cimg = "<div class='celebimg'><img id='" + c.get('_id') + "' src='" + c.get('imageurl') + "'>"
						// 	self.$el.append(cimg)
						// })
					},
					searchButtonEvent : function (event) {
						document.location.href = "<?php echo base_url()?>index.php/SearchQuizController/quizzesOfCategory/tag/"+$("#keywords").val();
						// $('.cname').remove()
						// $(event.currentTarget).parent().append("<div class='cname'>"
						// 	+ celebs.get(event.currentTarget.id).get('name') + " is <br/>"
						// 	+ celebs.get(event.currentTarget.id).get('age') + " years old"
						// 	+ "</div>")
					}
				}
			)

			var contentview = new ContentAreaView();
		});
		</script>
			
    </body>
    </html>
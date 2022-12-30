<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Quizoo</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<style>
			h5{
				color:red;
			}
		</style>
    </head>
    <body>
	<div class="container" id="contentarea">
		<div class='row'>
            <div class="col-md-6">
                <h1>Sign Up to </h1>
				<h2>Quizoo</h2>
				<p>If you already have an account</p>
                <p>You can <a href="<?php echo base_url()?>index.php/userAuthentication/"> login here! </a></p>
            </div>
            <div class="c">
				<h2>Sign up</h2>
				<!-- <form action="<?php echo base_url()?>index.php/userAuthentication/user" method=POST> -->
					<input class="form-control rounded" placeholder="Enter email" aria-label="email" id="email"/>
					<input  class="form-control rounded" placeholder="Create Username" aria-label="username" id="username" />
					<input class="form-control rounded" placeholder="password" aria-label="password" id="password" />
					<input  class="form-control rounded" placeholder="confirmPassword" aria-label="confirmPassword" id="confirmPassword" />
					<div id="errorMessage"></div>
					<button type="button" class="btn btn-outline-primary" id='register'>Register</button>
			</div>
        </div>
	</div> 
    		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script> -->
		<script>
			$(document).ready(function(){
						$("#register").click(function(event){
							
							if(!$("#email").val() || !$("#username").val() || !$("#password").val() ){
								document.getElementById("errorMessage").innerHTML =
           							 "<h5>Please fill all the fields </h5>";
							}
							
							else if($("#confirmPassword").val()==$("#password").val()){
								// event.preventDefault();
							var obj  = $.ajax(
								{
									url: "<?php echo base_url()?>index.php/userAuthentication/user",
									method:'POST',
									data: {'email':$("#email").val(), 'username':$("#username").val(), 'password':$("#password").val()}
								}
							);
							console.log("x");
							obj.done(function(data){
								console.log("false");
								document.location.href = "<?php echo base_url()?>index.php/userAuthentication/home";
							});
							}
							 
							else{
								document.getElementById("errorMessage").innerHTML =
           							 "<h5>Confirm password mismatch</h5>";
							}

						});


					});
		</script>
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
        });
        </script>
		<script language="Javascript">
		$(document).ready(function () {
			var User = Backbone.Model.extend({
				url: function () {
					var urlstr = 
						"<?php echo base_url() ?>index.php/UserAuthentication/user";
					return urlstr;
				},
				idAttribute: "_id",
				defaults: {
					email: null,
					username: null,
					password: null
				}
			});

			// create collections object
			// var user = new user();

			var ContentAreaView = Backbone.View.extend(
				{
					// model: User, // connect view to collections object
					el : $('#contentarea'), // connect view to page area
					events : {
						"click #register" : "registerEvent"
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
					registerEvent : function (event) {
						var user = new User({
							email: $("#email").val(),
							username: $("#username").val(),
							password:$("#password").val(),
						});
						user.create({async:false})
						// this.listeClients.add(tmpClient);
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
		</script> -->
			
    </body>
    </html>
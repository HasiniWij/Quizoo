<!doctype html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" ></script>


</head>
<body>

<form action="<?php echo base_url() ?>index.php/Test/index" method="GET">
<input type=text  id="title"/>
<input type=submit id="btn">
</form>

<form action="<?php echo base_url() ?>index.php/Test/index" method="GET">
Title <input type=text  id="newTitle"/>
Author<input type=text  id="author"/>
Genre<input type=text  id="genre"/>
<input type=submit id="btn2">
</form>

<script language="javascript">
    $(document).ready(function () {
        $('#btn').click(function (event) {
            var title = document.getElementById("title").value;
            console.log(title)
            event.preventDefault();
            $.ajax({
                url : "<?php echo base_url() ?>index.php/Test/book/"+title,
                type: "\get"
            }).done(function (data) {
                alert(data);
            })
        })
    })

    $(document).ready(function () {
        $('#btn2').click(function (event) {
            var title = document.getElementById("newTitle").value;
            var author = document.getElementById("author").value;
            var genre = document.getElementById("genre").value;
            console.log(title)
            event.preventDefault();
            $.ajax({
                url : "<?php echo base_url() ?>index.php/Test/book/"+title,
                type: "\get"
            }).done(function (data) {
                alert(data);
            })
        })
    })

</script>
</body>
</html>
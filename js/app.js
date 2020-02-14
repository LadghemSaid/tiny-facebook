$(document).ready(function () {

    //On pressing a key on "Search box" in "search.php" file. This function will be called.

    $("#search").keyup(function () {

        //Assigning search box value to javascript variable named as "name".

        var name = $('#search').val();

        //Validating, if "name" is empty.

        if (name == "") {

            //Assigning empty value to "display" div in "search.php" file.

            $("#display").html("");

        }

        //If name is not empty.
        else {

            //AJAX is called.

            $.ajax({

                //AJAX type is "Post".

                type: "POST",

                //Data will be sent to "ajax.php".
                //Ajax sur Wamp url: "/tinyfacebook/tiny-facebook/tiny-facebook-project/traitement/searchfriend.php",
                //Ajax sur C9.io
                url: "/tiny-facebook/tiny-facebook-project/traitement/searchfriend.php",

                //Data, that will be sent to "ajax.php".

                data: {

                    //Assigning value of "name" into "search" variable.

                    search: name

                },

                //If result found, this funtion will be called.

                success: function (html) {

                    //Assigning result to "display" div in "search.php" file.
                    $("#display").html(html).show();

                }

            });

        }

    });

});







$(document).ready(function(){

// Si user click sur like button
$('.like-btn').on('click', function(){
  var post_id = $(this).data('id');
  $clicked_btn = $(this);
  if ($clicked_btn.is('.liked')) {
  var action = 'unlike';
  } else{
  var action = 'like';
  }
  $.ajax({
  	type: "POST",
  	url: '/tiny-facebook/tiny-facebook-project/traitement/likes.php',
  	data:{
  		'action': action,
  		'post_id': post_id
  	},
  	success: function(data){
  		res = JSON.parse(data);
  		if (action == "like") {
  		    console.log(action);
  			$clicked_btn.removeClass('glyphicon glyphicon-thumbs-up');
  			$clicked_btn.addClass('glyphicon glyphicon-thumbs-up liked');
  			$clicked_btn.siblings('i.disliked').removeClass('glyphicon glyphicon-thumbs-down disliked').addClass('glyphicon glyphicon-thumbs-down');
  		} else if(action == "unlike") {
  		    console.log(action);
  			$clicked_btn.removeClass('glyphicon glyphicon-thumbs-up liked');
  			$clicked_btn.addClass('glyphicon glyphicon-thumbs-up');
  		}
  		// Affiche le nombre de like dislike
  	
  		$clicked_btn.siblings('span.likes').text(res.likes);
  		$clicked_btn.siblings('span.dislikes').text(res.dislikes);
  	

  		// Change le style du boutton suivant si user click dessus
  	//	$clicked_btn.siblings('i.glyphicon glyphicon-thumbs-up liked').removeClass('glyphicon glyphicon-thumbs-up').addClass('glyphicon glyphicon-thumbs-up');
  	}, error: function(jq,status,message) {
        alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
        console.log(status + message);
    }
  });		

});

// Si user click sur dislike button
$('.dislike-btn').on('click', function(){
  var post_id = $(this).data('id');
  $clicked_btn = $(this);
  if ($clicked_btn.is('.disliked')) {
  var action = 'undislike';
  } else{
  var action = 'dislike';
  }


  $.ajax({
  	type: 'POST',
  	url: '/tiny-facebook/tiny-facebook-project/traitement/likes.php',
  	data:{
  		'action': action,
  		'post_id': post_id
  	},
  	success: function(data){
  	   
  		res = JSON.parse(data);
  		if (action == "dislike") {
  		    console.log(action);
  			$clicked_btn.removeClass('glyphicon glyphicon-thumbs-down ');
  			$clicked_btn.addClass('glyphicon glyphicon-thumbs-down disliked');
  			$clicked_btn.siblings('i.liked').removeClass('glyphicon glyphicon-thumbs-up liked').addClass('glyphicon glyphicon-thumbs-up');
  		} else if(action == "undislike") {
  		    console.log(action);
  			$clicked_btn.removeClass('glyphicon glyphicon-thumbs-down disliked');
  			$clicked_btn.addClass('glyphicon glyphicon-thumbs-down');
  		// display the number of likes and dislikes
  		}
  		$clicked_btn.siblings('span.likes').text(res.likes);
  		$clicked_btn.siblings('span.dislikes').text(res.dislikes);
  		
  		
  		// change button styling of the other button if user is reacting the second time to post
  		//$clicked_btn.siblings('i.glyphicon glyphicon-thumbs-down disliked').removeClass('glyphicon glyphicon-thumbs-down').addClass('glyphicon glyphicon-thumbs-down');
  	}, error: function(jq,status,message) {
        alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
        console.log(status + message);
    }
  });	

});

});

//Partie likes des commentaire



$(document).ready(function(){

// Si user click sur like button
$('.com-like').on('click', function(){
  var com_id = $(this).data('id');
  var post_id = $(this).data('post');
  $clicked_btn = $(this);
  if ($clicked_btn.is('.liked')) {
  var action = 'unlike-com';
  } else{
  var action = 'like-com';
  }
  $.ajax({
  	type: "POST",
  	url: '/tiny-facebook/tiny-facebook-project/traitement/likes.php',
  	data:{
  		'action': action,
  		'com_id': com_id,
  		'post_id': post_id
  	},
  	success: function(data){
  	    console.log(data);
  		res = JSON.parse(data);
  		if (action == "like-com") {
  		    console.log(action);
  			$clicked_btn.removeClass('glyphicon glyphicon-thumbs-up');
  			$clicked_btn.addClass('glyphicon glyphicon-thumbs-up liked');
  		} else if(action == "unlike-com") {
  		    console.log(action);
  			$clicked_btn.removeClass('glyphicon glyphicon-thumbs-up liked');
  			$clicked_btn.addClass('glyphicon glyphicon-thumbs-up');
  		}
  		// Affiche le nombre de like dislike
  	
  		$clicked_btn.siblings('span.com-likes').text(res.likes);
  	    }, error: function(jq,status,message) {
        alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
        console.log(status + message);
    }
  });		

});

});
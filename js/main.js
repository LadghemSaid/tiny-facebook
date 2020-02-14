 function afficherCom(p1) {
     //  p0 = "#affichercomment" + p1
     p2 = "commentsection" + p1;
     //alert(p2);
     var elements = document.getElementsByClassName(p2);
     for (var i in elements) {
         console.log(elements);
         if (elements.hasOwnProperty(i)) {
            //elements[i].removeclassName = 'hided';
            elements[i].classList.remove("hided");
            
        }
}
         

 }


$(document).ready(function () {
    var myElem =document.getElementById("submitdeletepost");
    if (myElem === null){
        //alert('does not exist!');
       
       
        }else{
            console.log("clickedDeletePost");
        document.getElementById("submitdeletepost").onclick = function() {
        document.getElementById("deletepostform").submit();
        }
    }

});
//Footer stike

/*
$(document).ready(function () {

    var docHeight = $(window).height();
    var footerHeight = $('#footer').height();
    var footerTop = $('#footer').position().top + footerHeight;

    if (footerTop < docHeight) {
        $('#footer').css('margin-top', -30 + (docHeight - footerTop) + 'px');
    }
});
*/


function myFunction(x) {
    x.classList.toggle("change");
    $("#friendlistwrap").toggle("slow", function () {
        right: '250px'
    });
    $("#visible").toggle("slow", function () {
        right: '250px'
    });
}


$(document).ready(function () {
    $('.toggle').click(function () {
        $('#target').toggle('slow');
    });

    $(function () {
        $('#file-input').bind('click', function (e) {
            document.getElementById("dim").style.display = "block";
            document.getElementById("submit").style.display = "block";
        });

    });

    $(function () {
        $('#submit').bind('click', function (e) {
            document.getElementById("submit").style.display = "none";
        });
    });
    console.log("ready!");



});

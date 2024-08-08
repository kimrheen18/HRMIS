/*Toast Message*/
$(document).ready(function(){
    $('.toast').toast('show');
  });

/*sidebar*/
function openLink(evt, animName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("page");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-cyan", "");
  }
  document.getElementById(animName).style.display = "block";
  evt.currentTarget.className += " w3-cyan";
}

function openLinks(evt, animName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("page");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace("", "");
  }
  document.getElementById(animName).style.display = "block";
  evt.currentTarget.className += "";
}

/*searchbar*/
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#mySidebar button").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});



/*typeWriterStyle*/
var i = 0;
var txt = "                                                   Hello! This is DOST Online Help."; /* text */
var speed = 100; /* The speed/duration*/

function typeWriter() {
  if (i < txt.length) {
    document.getElementById("text-body").innerHTML += txt.charAt(i);
    i++;
    setTimeout(typeWriter, speed);
  }
}
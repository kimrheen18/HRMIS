/*Toast Message*/
$(document).ready(function(){
    $('.toast').toast('show');
  });
  
/*typeWriterStyle*/
var i = 0;
var txt = '        Hello! This is DOST Online Help.'; /* text */
var speed = 100; /* The speed/duration*/

function typeWriter() {
  if (i < txt.length) {
    document.getElementById("text-body").innerHTML += txt.charAt(i);
    i++;
    setTimeout(typeWriter, speed);
  }
}

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



/*sidebarfunction*/
function sidebar_open() {
  document.getElementById("main").style.marginLeft = "230px";
  document.getElementById("mySidebar").style.display= "block";
  document.getElementById("myOverlay").style.display = "block";
  document.getElementById("openNav").style.display = 'none';
}
function sidebar_close() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
  document.getElementById("openNav").style.display = "inline-block";
}


/*Dropdownbtn*/ 
function myDropFunc() {
  var x = document.getElementById("Drop");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += "";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace("", "");
  }
}

function myDropFuncTask() {
  var x = document.getElementById("taskDrop");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += "";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace("", "");
  }
}
function myDropFuncpds() {
  var x = document.getElementById("pdsDrop");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += "";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace("", "");
  }
}
function myDropFuncpds1() {
  var x = document.getElementById("pds1Drop");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += "";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace("", "");
  }
}

function myDropFuncAtt() {
  var x = document.getElementById("AttDrop");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += "";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace("", "");
  }
}

function myDropFuncRep() {
  var x = document.getElementById("RepDrop");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += "";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace("", "");
  }
}
function myDropFuncUser() {
  var x = document.getElementById("userDrop");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += "";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace("", "");
  }
}
function myDropFuncDix() {
  var x = document.getElementById("DixDrop");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += "";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace("", "");
  }
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



/*dropdownsign*/
var acc = document.getElementsByClassName("btn");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}



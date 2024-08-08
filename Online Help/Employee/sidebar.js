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
  
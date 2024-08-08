/*Toast Message*/
$(document).ready(function(){
    $('.toast').toast('show');
  });

/*Search Filter*/
  $(document).ready(function(){
    $("#floatingInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#accordionFlushExample .accordion-item").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

/*typeWriterStyle*/
var i = 0;
var txt = ' Hello! This is DOST Frequently Asked Questions.'; /* text */
var speed = 100; /* The speed/duration*/

function typeWriter() {
  if (i < txt.length) {
    document.getElementById("text-body").innerHTML += txt.charAt(i);
    i++;
    setTimeout(typeWriter, speed);
  }
}

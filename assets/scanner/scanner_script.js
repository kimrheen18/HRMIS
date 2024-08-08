$(function(){

  // Add Needed Variables
  let scan_animation = $(".scan-animation");
  let status_container = $(".status-container");
  let status_text = $(".status-text");
  let success_animation = document.querySelector("#success");
  let failed_animation = document.querySelector("#failed");
  let again_button = $("#again");
  let process_container = $(".processing-container");
  let video = document.createElement("video");
  let canvasElement = document.getElementById("canvas");
  let canvas = canvasElement.getContext("2d");
  let canvas_container = $(".canvas-container");
  let reqAnim;
  let once = true;
  let code_output;

  // Add Animation when QR Scan Animation is click
  scan_animation.click(()=> {
    scan_animation.addClass("animate__animated animate__bounceOut");
    setTimeout(function(){
      scan_animation.removeClass("animate__animated animate__bounceOut");
      scan_animation.css('display','none');
      $.fn.openCamera();
    },1000);
  });

  // Function that ask permission to open the camera
  $.fn.openCamera = function() {
    navigator.mediaDevices.getUserMedia({ video: { facingMode:"user"}}).then(function(stream) {
      video.srcObject = stream;
      video.setAttribute("playsinline", true);
      video.play();
      reqAnim = requestAnimationFrame($.fn.tick);
    });
  };

  // Function for displaying the video
  $.fn.tick = function() {
    if (video.readyState === video.HAVE_ENOUGH_DATA) {
      canvasElement.hidden = false;
      canvas_container.addClass("animate__animated animate__bounceIn");
      canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
      let imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
      let code = jsQR(imageData.data, imageData.width, imageData.height, {
          inversionAttempts: "dontInvert",
      });

      // If camera detects a QR Code
      if(code && once){
        code_output = code;
        canvas_container.addClass("animate__bounceOut");
        once = false;
        setTimeout(function(){
          cancelAnimationFrame(reqAnim);
          video.srcObject.getVideoTracks()[0].stop();
          canvasElement.hidden = true;
          canvas_container.css('display','none');
          canvas_container.removeClass("animate__animated animate__bounceIn animate__bounceOut");
          $.fn.processData();
        },1000);
      }  
    }
    reqAnim = requestAnimationFrame($.fn.tick);
  };

  // Method for displaying, either the success or failed animation 
  $.fn.successOrFailed = function(status, message){
    process_container.addClass("animate__bounceOut");
    setTimeout(function(){
      process_container.addClass("d-none");
      process_container.removeClass("animate__animated animate__bounceIn animate__bounceOut");
      status_container.removeClass("d-none");
      status_container.addClass("animate__animated animate__bounceIn");

      if(status == "success"){
        success_animation.play();
        success_animation.classList.remove("d-none");
        status_text.text(message);
      } else if(status == "failed"){
        failed_animation.play();
        failed_animation.classList.remove("d-none");
        status_text.text(message);
      }

    },1000);
  };

  //Method that process the data with database
  $.fn.processData = function(){
    process_container.removeClass("d-none");
    process_container.addClass("animate__animated animate__bounceIn");

    $.ajax({
      url: "dtrscan/DTR_Controller/saveData/" + code_output.data,
      type: "POST",
      dataType: "text",  
      cache: false,
      success: function(dataResult){
        var dataResult = JSON.parse(dataResult);
        console.log(dataResult.scheme);

        if(dataResult.statusCode==200){
          $.fn.successOrFailed("success", dataResult.statusSched);
        } else if(dataResult.statusCode==404){
          $.fn.successOrFailed("failed", "User QR Not Found!");
        } else {
          $.fn.successOrFailed("failed", "Failed Try Again!");
        }
      }, 
      error: function(xhr, status, error){
        $.fn.successOrFailed("failed", error);
      },
    });

    // Open Camera again after scanning for 5 seconds
    setTimeout(function(){ again_button.click() }, 5000);
  };

  // Scan again the qr code
  again_button.click(()=> {
    once = true;
    status_container.addClass("animate__bounceOut");
    setTimeout(function(){
      status_container.addClass("d-none");
      status_container.removeClass("animate__animated animate__bounceIn animate__bounceOut");

      if(!success_animation.classList.contains("d-none")){
        success_animation.stop();
        success_animation.classList.add("d-none");
      }else if(!failed_animation.classList.contains("d-none")){
        failed_animation.stop();
        failed_animation.classList.add("d-none");
      }
      canvas_container.css("display","block");
      $.fn.openCamera();
    },1000);
  });

  // Time Format for Digital Clock
  $.fn.formatAMPM = function(){
    let date = new Date();
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0'+ minutes : minutes;

    $("#hour").text(hours);
    $("#minutes").text(minutes);
    $("#meridiem").text(ampm);
  };

  // Ticking the clock
  setInterval($.fn.formatAMPM,1000);

});

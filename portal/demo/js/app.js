var wrapper1 = document.getElementById("signature-pad1"),
    clearButton1 = wrapper1.querySelector("[data-action=clear]"),
    canvas1 = wrapper1.querySelector("canvas"),
    signaturePad1;

var wrapper2 = document.getElementById("signature-pad2"),
clearButton2 = wrapper2.querySelector("[data-action=clear]"),
canvas2 = wrapper2.querySelector("canvas"),
signaturePad2;

var wrapper3 = document.getElementById("signature-pad3"),
clearButton3 = wrapper3.querySelector("[data-action=clear]"),
canvas3 = wrapper3.querySelector("canvas"),
signaturePad3;

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas1.width = canvas1.offsetWidth * ratio;
    canvas1.height = canvas1.offsetHeight * ratio;
    canvas1.getContext("2d").scale(ratio, ratio);
    
    canvas2.width = canvas2.offsetWidth * ratio;
    canvas2.height = canvas2.offsetHeight * ratio;
    canvas2.getContext("2d").scale(ratio, ratio);
    
    canvas3.width = canvas3.offsetWidth * ratio;
    canvas3.height = canvas3.offsetHeight * ratio;
    canvas3.getContext("2d").scale(ratio, ratio);
}


window.onresize = resizeCanvas;
resizeCanvas();

signaturePad1 = new SignaturePad(canvas1);
signaturePad2 = new SignaturePad(canvas2);
signaturePad3 = new SignaturePad(canvas3);

clearButton1.addEventListener("click", function (event) {
    signaturePad1.clear();
});
clearButton2.addEventListener("click", function (event) {
    signaturePad2.clear();
});
clearButton3.addEventListener("click", function (event) {
    signaturePad3.clear();
});

$('form').on('submit', function (event) {
	event.preventDefault();
	if (signaturePad1.isEmpty() || signaturePad2.isEmpty() || ((document.getElementById("prefillLastName2").value != "" || document.getElementById("prefillFirstName2").value != "") && signaturePad3.isEmpty())) {
        alert("Please provide signature first.");
        return;
    } 
    else if (validateForm() === true){
    	var sigUrl1 = signaturePad1.toDataURL();
    	var name1 = new Date().getTime();
    	document.getElementById("signed1").value = name1 + ".png";
    	
    	var sigUrl2 = signaturePad2.toDataURL();
    	var name2 = new Date().getTime();
    	document.getElementById("signed2").value = name2 + ".png";
    	
    	if (!signaturePad3.isEmpty()){
    		var sigUrl3 = signaturePad3.toDataURL();
    		var name3 = new Date().getTime();
    		document.getElementById("signed3").value = name3 + ".png";
    		$.ajax({
      		  type: "POST",
      		  url: "canvasImage.php",
      		  data: { 
      		     imgBase64: sigUrl3, name: name3
      		  }
      		}).done(function(o) {
      		  console.log('saved'); 
      		});
    	}
    	
    	$.ajax({
    		  type: "POST",
    		  url: "canvasImage.php",
    		  data: { 
    		     imgBase64: sigUrl1, name: name1
    		  }
    		}).done(function(o) {
    		  console.log('saved'); 
    		});
    	
    	$.ajax({
  		  type: "POST",
  		  url: "canvasImage.php",
  		  data: { 
  		     imgBase64: sigUrl2, name: name2
  		  }
  		}).done(function(o) {
  		  console.log('saved'); 
  		});
    	//document.getElementById(id).value = signaturePad.toDataURL();
    	
    	event.currentTarget.submit();
    }
});

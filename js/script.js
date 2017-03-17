function affichage(id){
  var div = document.getElementById(id);
  if(div.style.display == "none") {
    div.style.display = "block";
  } else {
    div.style.display = "none";
  }
}

function affichageFooter(id){
	var div = document.getElementById(id);
	if (window.matchMedia("(max-width: 640px)").matches) {
  		if(div.style.display == "none") {
   			div.style.display = "block";
  		}else {
    		div.style.display = "none";
  		} 
	}
}
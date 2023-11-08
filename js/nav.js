var url = window.location.pathname;
var filename = url.substring(url.lastIndexOf('/')+1);
let link = document.getElementsByClassName(filename);
link[0].style.color="var(--darkblue)";
if(filename==="signUp"||filename==="logIn"){
    document.getElementById("navbar").style.background="none";
}
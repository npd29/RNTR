
let images = document.getElementsByClassName("loader");
for(let i=0;i<images.length;i++) {
    images[i].onload = function()
    {
        document.getElementsByTagName("img").style.background = "none";
    }
}

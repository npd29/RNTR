//initialized on multiStepForm.js

function adjustCheck(x) {
  let element = document.getElementById(x);
  if (element.checked) {
    element.checked = false;
    element.parentElement.style.background = "0";
    element.nextElementSibling.style.color = "white";
  } else {
    element.checked = true;
    element.parentElement.style.backgroundColor = "white";
    element.nextElementSibling.style.color = "var(--purple)";
  }
}

function checkCheck() {
  let elements = document.querySelectorAll("input[type=checkbox]");
  for (let i = 0; i < elements.length; i++) {
    if (elements[i].checked) {
      elements[i].parentElement.style.backgroundColor = "white";
      elements[i].nextElementSibling.style.color = "var(--purple)";

    } else {
      elements[i].parentElement.style.background = "0";
      elements[i].nextElementSibling.style.color = "white";
    }
  }
}

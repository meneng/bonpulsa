function openNav() {
  document.getElementById("mySidenav").style.width = "100%";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

function openForm(namae) {
  document.getElementById("nama").value = namae;
  document.getElementById("myForm").style.width = "100%";
}

function closeForm() {
  document.getElementById("myForm").style.width = "0";
}

function openFormAdd() {
  document.getElementById("nameForm").style.width = "100%";
}

function closeFormAdd() {
  document.getElementById("nameForm").style.width = "0";
}

function openTab(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
  //close sidenav
  document.getElementById("mySidenav").style.width = "0";
}

let element =  document.getElementById('defaultOpen');
if (typeof(element) != 'undefined' && element != null) {
  // Exists.
  document.getElementById("defaultOpen").click();
}
















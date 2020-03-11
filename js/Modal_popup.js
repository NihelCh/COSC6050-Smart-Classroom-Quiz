  
  //Function To Display Popup for create class
    function Display() {
    document.getElementById('myModal').style.display = "block";
    }
    //Function to Hide Popup
    function closeForm() {
        document.getElementById("myModal").style.display = "none";
      }
   
 //Function To Display Popup for join class
 function ClickJoin() {
  document.getElementById('myModal2').style.display = "block";
  }
//Function to Hide Popup
  function closeForm3() {
      document.getElementById("myModal2").style.display = "none";
    }
 //Function To Display Popup for create quiz
 function ClickCreate() {
	document.getElementById("addQuizModal").style.display = "block";
	document.preventDefault();
	document.getElementById("body").style.overflow = "hidden";
	document.getElementById("body").style.position = "fixed";
	document.getElementById("wrapper").style.overflow = "hidden";
	document.getElementById("container").style.overflow = "hidden";
  }
//Function to Hide Popup
function closeForm4() {
  document.getElementById("addQuizModal").style.display = "none";
}
	
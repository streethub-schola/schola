
var textBox = document.querySelector(".textBox");
var messageContainer = document.querySelector(".message");
var add_Question = document.getElementById("AddAss");
var textMessage = document.getElementById("assignmentText");
var remove_Question = document.getElementById("remove");
var btn_Submit = document.getElementById("submitBtn");
var sname = document.getElementById("staff-name");
 
const delete_Assignment = document.getElementById("deleteAssignment");
// delete_Assignment.addEventListener("click", ()=>{
//     messageContainer.style.display = "none";
// })
add_Question.addEventListener("click", ()=>{

     textBox.innerHTML += `
         <div class="message">
                <textarea name="" id="assignmentText" cols="30" rows="10" placeholder="Type your questions">

                        </textarea>
                 <i class="fa-solid fa-trash-can" id="deleteAssignment"></i>

            </div>
        `;
      textBox.addEventListener("click", (event) => {
        if (event.target.matches(".fa-solid.fa-trash-can")) {
          const closestMessage = event.target.closest(".message");
          closestMessage.parentNode.removeChild(closestMessage);
        }
      });
   
        
});

remove_Question.addEventListener("click", ()=>{
    if (textBox.innerHTML == 0) {
        alert("Add a question to remove");
        return false
        updateMessage()
    } 
    function updateMessage() {
         let actionMessage = prompt(
           "conform you want to delete all questions",
           "yes/no"
         );
         actionMessage = actionMessage.toLowerCase();
         console.log(actionMessage);
         if (actionMessage == "yes") {
            textBox.innerHTML = "";
            alert("All assignments have been deleted as per your request")
         }else if (actionMessage == "no") {
            alert("Keep working")
         }
           
    }
    updateMessage()

    

})


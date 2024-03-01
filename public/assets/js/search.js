const content = document.querySelector("#searchBox");
const searchController = document.querySelector("#searchNow");
let count = 0;


// Check wheather search input is empty
content.addEventListener("input", (e) => {
    e.preventDefault();

    if(content.value.length == 0 && count == 1){
    	console.log("input is empty");
            count = 0;
            location.reload();
           
    }
    else{
       count = 1;
    }

}) 

// we are searching with fname column

searchController.addEventListener("click", (e) => {
  e.preventDefault();

  if (content.value == "" || content.value == " ") {
    alert("Please enter a valid student firstname");
  } else {
    // console.log(content.value);

    const searchData = {
      searchstring: content.value,
      searchcolumn: "firstname",
    };

    const configData = {
      method: "POST",
      mode: "no-cors",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(searchData),
    };

    // fetch('http://localhost/api/studentapi/groupsearch.php', configData)
    fetch("https://schola-2.myf2.net/api/studentapi/groupsearch.php",
      configData
    )
      .then((res) => res.json())
      .then((data) => {
        console.log(data.message);
            
        if(data.status == 1){    
        	displayStudents(data.message);
        }
        else{
          	alert(data.message);
        }

      })
      .catch((err) => alert("There is an issue with your network."));
  }
});

function initialize(student) {
  const defaultRow = fname;
  const searchString = content.value;

  console.log(student);
}

let serialNo = 1

function getUsers() {
    let source = document.getElementById('showStudents')
    
    // fetch('data.json')
    fetch('http://localhost/api/studentapi/getstudents.php')
    // fetch('https://scholabe.myf2.net/api/studentapi/getstudents.php')
    .then((res) => res.json())
    .then(data => {
        console.log(data.records[1])
        data.records.forEach(items => {
            let output = `
            <td class="px-4">${serialNo++}</td>
            <td class="tbody_td">${items.admin_no}</td>
            <td class="tbody_td">${items.firstname} ${items.lastname}</td>
            <td class="tbody_td">${items.usercode}</td>
            <td class="tbody_td_controller" id="controller">
            <a href="edit_student.html?studentId=${items.admin_no}" data-te-toggle="tooltip" title="Edit Record">
            <i class="fa fa-pen-to-square text-lg text-blue-400"></i>  
            </a>
            <a href="view.html?studentId=${items.admin_no}" data-te-toggle="tooltip" title="View Record">
            <i class="fa-regular fa-eye text-lg text-blue-400"></i>
            </a>
            <a href="edit_student.html?studentId=${items.admin_no}" data-te-toggle="tooltip" title="Delete Record">
            <i class="fa fa-trash text-red-500 text-lg"></i>
            </button>
            </td>
            `

            source.insertAdjacentHTML("beforeend", output)
            
            
        });
    })
        
            
}



getUsers()
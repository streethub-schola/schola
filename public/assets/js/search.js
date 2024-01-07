const content = document.querySelector('#searchBox');
const searchController = document.querySelector('#searchNow');

// we are searching with fname column

searchController.addEventListener('click', (e) => {

    // console.log(content.value)
    

    // const configData = {
    //     method: 'GET',
    //     mode: 'no-cors',
    //     headers: {
    //         'Content-Type':'application/json',
    //     },
    // };


    fetch('http://localhost/api/studentapi/groupsearch.php')
    // fetch('https://schola.myf2.net/api/studentapi/groupsearch.php')  
    .then(res => res.json())
    .then(data => initialize(data))
    .catch(err => console.log(err))
})

function initialize(student){
    const defaultRow = fname;
    const searchString = content.value;

    

}
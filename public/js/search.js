const content = document.querySelector('#searchBox');

// we are searching with fname column

content.addEventListener('change', (e) => {

    console.log(content.value)
    // const searchString = content.value;

    // const configData = {
    //     method: 'GET',
    //     mode: 'no-cors',
    //     headers: {
    //         'Content-Type':'application/json',
    //     }
    // };


    // fetch('https://scholabe.myf2.net/api/studentapi/groupsearch.php', configData)
    // .then(res => res.json())
    // .then(data => {
    //     console.log(data.fname[searchString])

    // })




})
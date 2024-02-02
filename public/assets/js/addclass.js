const form = document.querySelector('form');

console.log(form);

form.addEventListener('submit', (e) => {
    e.preventDefault();

    let class_name = form.className.value;
    let class_level = form.classlevel.value;
    let class_extension = form.classextension.value;

    // console.log(`
    // ${class_name}, 
    // ${class_level}, 
    // ${class_extension}
    // `);

    const classdata = {
        class_name,
        class_level,
        class_extension
    }

    const configData = {
        method: 'POST',
        mode: 'no-cors',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(classdata)
    }

    fetch("http://localhost/api/classapi/createclass.php", configData)
 .then(res => res.json())
 .then(data => {
    console.log(data);
 })
 .catch(err => console.error(err));

});
const form = document.querySelector('#form');

form.addEventListener('submit', (e)=> {
    e.preventDefault()

    const stdFName = form.studenFName.value;
    const stdLName =form.studentLName.value;
    const stdDoB = form.studentDOB.value;
    const stdAddress = form.studentAddress.value;
    const guardianName = form.guardianName.value;
    const guardianPhone = form.guardianPhone.value;
    const guardianEmail = form.guardianEmail.value;
    const guardianAddress = form.guardianAddress.value;
    const studentPassword = form.studentPassword.value;

    console.log(`
    ${stdFName},
    ${stdLName},
    ${stdDoB},
    ${stdAddress},
    ${guardianName},
    ${guardianPhone},
    ${guardianEmail},
    ${guardianAddress},
    ${studentPassword}
    `)
    
})
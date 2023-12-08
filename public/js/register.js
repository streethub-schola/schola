// This js validates the register page to make sure that all the inputs are well validated
// This function below is meant to validate the form to ensure that users put in the right inputs

// defining a variable for all of our inputs
// For teacher input
let NameTeacher = document.getElementById("TeacherName");
// for TSC input
let TSC = document.getElementById("TSCNumber");
// teachers work station 
let Teachers_Station = document.getElementById("TaechersSatation");
// For teachers Designation Input
let DesignateTeacher = document.getElementById("TaechersDesignate");
// for Date of Birth Input
let DateOfBirth = document.getElementById("DOB");
// for date of appointment input
let AppointmentDate = document.getElementById("Appointment");
// To get the password input
var userPassword = document.getElementById("TeachersPasword");
// Getting our Submit Btn 
var SubmitFormBtn = document.querySelector(".SubmitBtn");

function ValidateForm() {
  if (NameTeacher.value == 0 ) {
    let NameTeacherValidate = document.querySelector(".ValidateName")
    NameTeacherValidate.innerHTML = "Name is required";
    NameTeacherValidate.style.color = "red"
    event.preventDefault()
  }else if (TSC.value == 0) {
  let TSCValidate = document.querySelector(".ValidateTSC");
    TSCValidate.innerHTML = "A TSC Number is compulsory";
    TSCValidate.style.color = "red"
        event.preventDefault()
  }else if (Teachers_Station.value == 0) {
    let Teachers_StationValidate = document.querySelector(".ValidateWorkStation");
    Teachers_StationValidate.innerHTML = "Please enter a work Station Name";
    Teachers_StationValidate.style.color = "red"
            event.preventDefault()

  }else if (DesignateTeacher.value == 0) {
    let DesignateTeacherValidate = document.querySelector(".ValidateDesignation");
    DesignateTeacherValidate.innerHTML = "Please enter a designation"
    DesignateTeacherValidate.style.color = "red";
                event.preventDefault()

  }else if (DateOfBirth.value == 0) {
    let DateOfBirthValidate = document.querySelector(".ValidateDOB");
    DateOfBirthValidate.innerHTML = "Date of Birth is required";
    DateOfBirthValidate.style.color = "red";
                    event.preventDefault()

  }else if (AppointmentDate.value == 0) {
    let AppointmentDateValidate = document.querySelector(".ValidateAppointment");
    AppointmentDateValidate.innerHTML = "Appointment date is required";
    AppointmentDateValidate.style.color = "red";
                        event.preventDefault()

  }else if (userPassword.value == 0) {
    let userPasswordValidate = document.querySelector(".ValidatePassword");
    userPasswordValidate.innerHTML = "A Password is required";
    userPasswordValidate.style.color = "red";
                            event.preventDefault();
  }else if (userPassword.value.length <= 5) {
        let userPasswordValidate = document.querySelector(".ValidatePassword");
    userPasswordValidate.innerHTML = "Password must exceed 5 characters";
    userPasswordValidate.style.color = "#e26482";
                                  event.preventDefault();
  }else if (userPassword.value.length >=30) {
     let userPasswordValidate = document.querySelector(".ValidatePassword");
    userPasswordValidate.innerHTML = "Exceeded Maximum Characters";
    userPasswordValidate.style.color = "#e26482";
                                         event.preventDefault();
  }else{
    alert("Sucess")
  }
}




// Defining variables for the Hide and Display password Icon
var PasswordVisible = document.getElementById("showPassword");
var passwordHide = document.getElementById("HidePassword");

var TeacherPassCode = document.getElementById("TeachersPasword")
passwordHide.addEventListener("click", function () {
    if (TeacherPassCode.type = "password") {
        TeacherPassCode.type = "text";
        PasswordVisible.style.display = "block"
        passwordHide.style.display = "none"
    }else{
        // TeacherPassCode.type = "password"
      
    }
    console.log(TeacherPassCode)
    // alert("hello")
})
PasswordVisible.addEventListener('click', () =>{
      if (TeacherPassCode.type = "text") {
        TeacherPassCode.type = "password"
          passwordHide.style.display = "block";
        PasswordVisible.style.display = "none"
      }
})
// This js validates the register page to make sure that all the inputs are well validated
// This function below is meant to validate the form to ensure that users put in the right inputs

// defining a variable for all of our inputs
// For Student Reg No input
let Reg_No_Student = document.getElementById("StudentReg");
// for Student First name input
let firstNameStudent = document.getElementById("Student-F-Name");
// for Students last name input
let latsNameStudent = document.getElementById("Student-L-Name");
// For student's age Input
let age_Of_Student = document.getElementById("ageOfStudent");
// for Date of Birth Input
let DateOfBirth = document.getElementById("DOB");
// for students address input
let address_Of_Student = document.getElementById("addressOfStudent");
// To get the password input
var userPassword = document.getElementById("TeachersPasword");
// Getting our Submit Btn 
var SubmitFormBtn = document.querySelector(".SubmitBtn");

function ValidateForm() {
  if (Reg_No_Student.value == 0 ) {
    alert("Error - Missing fields")
    let Re_NoValidate = document.querySelector(".ValidateRegNo")
    Re_NoValidate.innerHTML = "Reg No is required";
    Re_NoValidate.style.color = "red"
    event.preventDefault()
  }else if (firstNameStudent.value == 0) {
        alert("Error - Missing fields");
  let StudentFNameValidate = document.querySelector(".Validate-F-Name");
    StudentFNameValidate.innerHTML = "First Name is required";
    StudentFNameValidate.style.color = "red"
        event.preventDefault()
  }else if (latsNameStudent.value == 0) {
        alert("Error - Missing fields");
    let studentLastNameValidate = document.querySelector(".Validate-L-Name");
    studentLastNameValidate.innerHTML = "Last Name is required";
    studentLastNameValidate.style.color = "red"
            event.preventDefault()
  }else if (age_Of_Student.value == 0) {
    alert("Error - Missing fields")
    let studentAgeValidate = document.querySelector(".ValidateAge");
    studentAgeValidate.innerHTML = "Please enter your age"
    studentAgeValidate.style.color = "red";
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
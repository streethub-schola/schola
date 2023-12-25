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
// Confirm Password input
var passcode_Confirm = document.getElementById("password-Confirm");
// Getting our Submit Btn 
var SubmitFormBtn = document.querySelector(".SubmitBtn");

// Getting the value of the checkbox
let guardian_AddressCheck = document.getElementById("G-checkboxAddress");

// Getting the value the Guardian Email
let emailOfGuardian = document.getElementById("G-EmailID");

function ValidateForm() {
  // if (Reg_No_Student.value == 0 ) {
  //   alert("Error - Missing fields");
  //   console.log(passcode_Confirm)
  //   let Re_NoValidate = document.querySelector(".ValidateRegNo")
  //   Re_NoValidate.innerHTML = "Reg No is required";
  //   Re_NoValidate.style.color = "red"
  //   event.preventDefault()
  // }
 if (firstNameStudent.value == 0) {
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
  }
  // else if (age_Of_Student.value == 0) {
  //   alert("Error - Missing fields")
  //   let studentAgeValidate = document.querySelector(".ValidateAge");
  //   studentAgeValidate.innerHTML = "Please enter your age"
  //   studentAgeValidate.style.color = "red";
  //               event.preventDefault()

  // }
  else if (DateOfBirth.value == 0) {
    alert("Error - Missing fields")
    let DateOfBirthValidate = document.querySelector(".ValidateDOB");
    DateOfBirthValidate.innerHTML = "Date of Birth is required";
    DateOfBirthValidate.style.color = "red";
                    event.preventDefault()

  }else if (address_Of_Student.value == 0) {
    alert("Error - Missing fields");
    let studentAddressValidate = document.querySelector(".ValidateAddress");
    studentAddressValidate.innerHTML = "Address is required";
    studentAddressValidate.style.color = "red";
                        event.preventDefault()

  }else if (emailOfGuardian.value == 0) {
      alert("Error - Missing fields");
      let email_Guardianvalidate = document.querySelector(".validateG-Email");
      email_Guardianvalidate.innerHTML = "A Guardian Email is needed";
      email_Guardianvalidate.style.color = "red";
      event.preventDefault()
  }
  else if (userPassword.value == 0) {
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
  } else if (passcode_Confirm.value != userPassword.value) {
    let passcodeConfirmval = document.querySelector(".ValidateNewPassword");
   passcodeConfirmval.innerHTML = "Passoword does not match";
   passcodeConfirmval.style.color = "ff0000";
    event.preventDefault();
    console.log(passcodeConfirmval)
  }
  else{
    alert("Sucess")
  }
}
 guardian_AddressCheck.addEventListener("click", function (){
    if (guardian_AddressCheck.checked) {
    let G_Address = document.getElementById("G-Address");
    let address_Of_Student = document.getElementById("addressOfStudent");
    G_Address.value = address_Of_Student.value;
    // alert("Adress has been autofiled");
  }else if (address_Of_Student.value == 0) {
    alert("Cannot autofil empty Address");
    event.preventDefault();
  }else{
    alert("address removed");
      let address_Of_Student = document.getElementById("addressOfStudent");
          let G_Address = document.getElementById("G-Address");
    G_Address.value = " ";
    console.log(address_Of_Student.value)
    // console.log(guardian_AddressCheck.unchecked);
  }
 });


  
  console.log(guardian_AddressCheck);
  if (guardian_AddressCheck.checked) {
    let G_Address = document.getElementById("G-Address");
    let address_Of_Student = document.getElementById("addressOfStudent");
    G_Address.value = address_Of_Student.value;
    // alert("Adress has been autofiled");
  }
  // else if (address_Of_Student.value == 0) {
  //   alert("Cannot autofil empty Address");
  //   event.preventDefault()
  // }




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
var confirm_Show_passcode = document.getElementById("showPasswordConfirm");
var confirm_Hide_passcode = document.getElementById("HidePasswordConfirm");

function confirmpasscodeShow(){
  if (passcode_Confirm.type = "password"){
    passcode_Confirm.type = "text";
    confirm_Show_passcode.style.display = "block";
    confirm_Hide_passcode.style.display = "none"
  }
}

function confirmPasscodeHide(){
  if(passcode_Confirm.type = "text"){
    passcode_Confirm.type = "password";
      confirm_Show_passcode.style.display = "none";
    confirm_Hide_passcode.style.display = "block"
  }
}
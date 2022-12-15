const form = document.getElementById("form")
const firstName = document.getElementById("first-name")
const lastName = document.getElementById("last-name")
const email = document.getElementById("email")
const mobile = document.getElementById("mobile")
const password = document.getElementById("password")
const comfirmPassword = document.getElementById("comfirm-password")
const gender = document.getElementById("gender")
const male = document.getElementById("male")
const female = document.getElementById("female")
const state= document.getElementById("state")
const tnc= document.getElementById("checkbox")

form.addEventListener("submit", e => {
    checkInputs(); 

    if(isFormValid() == true){
        form.submit();
    }
    else{
        e.preventDefault();
    }
});

function isFormValid(){
    const inputContainers = form.querySelectorAll(".form-control");
    let result = true;
    inputContainers.forEach((container)=>{
        if(container.classList.contains("error")){
            result = false;
        }
    });
    return result;
}

function checkInputs(){
    //get the values from the inputs
    const firstNameValue = firstName.value.trim();
    const lastNameValue = lastName.value.trim();
    const emailValue = email.value.trim();
    const mobileValue = mobile.value.trim();
    const passwordValue = password.value.trim();
    const comfirmPasswordValue = comfirmPassword.value.trim();
    const stateValue = state.value.trim();

    if(firstNameValue == ""){
        setErrorFor(firstName, "First name cannot be blank");
    }
    else if(firstNameValue != capitalize(firstNameValue)){
        setErrorFor(firstName, "First character uppercase and follow by lowercase");
    }
    else {
        setSuccessFor(firstName);
    }

    if(lastNameValue == ""){
        setErrorFor(lastName, "Last name cannot be blank");
    }
    else if(lastNameValue != capitalize(lastNameValue)){
        setErrorFor(lastName, "First character uppercase and follow by lowercase");
    }
    else{
        setSuccessFor(lastName);
    }

    if(emailValue == ""){
        setErrorFor(email, "Email cannot be blank");
    }
    else if(!isEmail(emailValue)){
        setErrorFor(email, "Email is not valid");
    }
    else{
        setSuccessFor(email);
    }

    if(mobileValue == ""){
        setErrorFor(mobile, "Mobile cannot be blank");
    }
    else if(!isMobile(mobileValue)){
        setErrorFor(mobile, "Please match the requested format");
    }
    else{
        setSuccessFor(mobile);
    }

    if(passwordValue == ""){
        setErrorFor(password, "Password cannot be blank");
    }
    else if(passwordValue.length < 6){
        setErrorFor(password, "Password length must be 6 digits length");
    }
    else if(passwordValue.search(/[0-9]/)== -1){
        setErrorFor(password, "At least 1 numeric value must be enter");
    }
    else if(passwordValue.search(/[a-z]/)== -1){
        setErrorFor(password, "At least 1 lowercase letter must be enter");
    }
    else if(passwordValue.search(/[A-Z]/)== -1){
        setErrorFor(password, "At least 1 uppercase letter must be enter");
    }
    else if(passwordValue.search(/[!\@\#\$\%\^\&\*]/)== -1){
        setErrorFor(password, "At least 1 special character must be enter");
    }
    else if(passwordValue.search(' ') > 0){
        setErrorFor(password, "Password should not have space");
    }
    else{
        setSuccessFor(password);
    }

    if(comfirmPasswordValue == ""){
        setErrorFor(comfirmPassword, "Password cannot be blank");
    }
    else if(comfirmPasswordValue != passwordValue){
        setErrorFor(comfirmPassword, "Passwords do not match");
    }
    else{
        setSuccessFor(comfirmPassword);
    }

    if(male.checked){ 
        genderDisplay(male);
    }
    else if(female.checked){
        genderDisplay(female);
    } else{
        setErrorFor(male, "Gender cannot be blank");
    }

    if(stateValue == ""){
        setErrorFor(state, "Please make a selection");
    } else{
        setSuccessFor(state);
    }

    if(tnc.checked){
        setSuccessFor(tnc);
    } else{
        setErrorFor(tnc, "Please accept terms and conditions");
    }
}

function setErrorFor(input, message){
    const formControl = input.parentElement; //.form-control
    const small = formControl.querySelector("small");

    //add error message inside small
    small.innerText = message;

    //add error class
    formControl.className = "form-control error";
}

function setSuccessFor(input){
    const formControl = input.parentElement;
    formControl.className = "form-control success";
}

function capitalize(words){
    var separateWords = words.toLowerCase().split(' ');

    for( var i=0; i<separateWords.length; i++){
        separateWords[i] = separateWords[i][0].toUpperCase() + separateWords[i].substr(1);
    }
    return separateWords.join(' ');
}

function isEmail(email){
    return /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}

function isMobile(mobile){
    return /^(\+?6?01)[02-46-9][-][0-9]{7}$|^(\+?6?01)[1][-][0-9]{8}$/.test(mobile);
}

function genderDisplay(input){
    const formControl = input.parentElement;

    if(input == male){
        formControl.className = "form-control male";
    }
    else{
        formControl.className = "form-control female";
    }
}

function togglePassword(){
    var password = document.querySelector('[name=password]')
    if(password.getAttribute('type')==='password'){
        password.setAttribute('type', 'text');
        document.getElementById("togglePassword").style.color='#8c8c8c';
    }
    else{
        password.setAttribute('type', 'password');
        document.getElementById("togglePassword").style.color='black';
    }
}

function togglePassword2(){
    var password = document.querySelector('[name=password2]')
    if(password.getAttribute('type')==='password'){
        password.setAttribute('type', 'text');
        document.getElementById("togglePassword2").style.color='#8c8c8c';
    }
    else{
        password.setAttribute('type', 'password');
        document.getElementById("togglePassword2").style.color='black';
    }
}

function genderMale(){
    male.parentElement.className = "form-control male";
}

function genderFemale(){
    female.parentElement.className = "form-control female";
}

function myReset(){
    document.getElementById("form").reset();
    firstName.parentElement.className = "form-control";
    lastName.parentElement.className = "form-control";
    email.parentElement.className = "form-control";
    mobile.parentElement.className = "form-control";
    password.parentElement.className = "form-control";
    comfirmPassword.parentElement.className = "form-control";
    gender.parentElement.className = "form-control";
    state.parentElement.className = "form-control";
    tnc.parentElement.className = "form-control";
}

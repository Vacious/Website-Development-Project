const form = document.getElementById("form")
const CourseName = document.getElementById("course-name")
const CourseDesc = document.getElementById("course-desc")
const CoursePrice = document.getElementById("price")

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
    const CourseNameValue = CourseName.value.trim();
    const CourseDescValue = CourseDesc.value.trim();
    const CoursePriceValue = CoursePrice.value.trim();

    if(CourseNameValue == ""){
        setErrorFor(CourseName, "Course name cannot be blank");
    }
    else if(CourseNameValue != capitalize(CourseNameValue)){
        setErrorFor(CourseName, "First character uppercase and follow by lowercase");
    }
    else {
        setSuccessFor(CourseName);
    }

    if(CourseDescValue == ""){
        setErrorFor(CourseDesc, "Course description cannot be blank");
    }
    else if(CourseDescValue != capitalize(CourseDescValue)){
        setErrorFor(CourseDesc, "First character uppercase and follow by lowercase");
    }
    else{
        setSuccessFor(CourseDesc);
    }

    if(CoursePriceValue == ""){
        setErrorFor(CoursePrice, "Price cannot be blank");
    }
    else if(CoursePriceValue.search(' ') > 0){
        setErrorFor(CoursePrice, "Price should not have space");
    }
    else{
        setSuccessFor(CoursePrice);
    }

}

function myReset(){
    document.getElementById("form").reset();
    CourseName.parentElement.className = "form-control";
    CourseDesc.parentElement.className = "form-control";
    CoursePrice.parentElement.className = "form-control";
}

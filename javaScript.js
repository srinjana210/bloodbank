
//Checing password length and password match with confirm password

var passwordR = document.getElementById("passwordR");
var confirmPasswordR = document.getElementById("confirmPasswordR"); 

passwordR.addEventListener("keyup", lengthCheck);
confirmPasswordR.addEventListener("keyup", matchCheck)

function lengthCheck(){
    if(passwordR.value.length < 8){
        passwordR.style.border = "solid 0.5px red";
        document.getElementById("passError").innerHTML = "Minimun length should be 8";
    }
    else{
        passwordR.style.border = "";
        document.getElementById("passError").innerHTML = "";
    }
}

function matchCheck(){

    if(passwordR.value != confirmPasswordR.value){
        confirmPasswordR.style.border = "solid 0.5px red";
        document.getElementById("confirmPassError").innerHTML = "Paasword Doesn't match";
    }
    else{
        confirmPasswordR.style.border = "";
        document.getElementById("confirmPassError").innerHTML = "";
    }

}










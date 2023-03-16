function validateLogin(event) {

        const email = document.getElementById("inputEmail").value;
        const password = document.getElementById("inputPassword").value;

        let emailError = document.getElementById('emailError')
        let passwordError = document.getElementById('passwordError')

        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        if(email == ""){
                emailError.innerHTML = "email can't be blank";
                emailError.style.color = 'red';
                return false;  
        }
        if (!email.match(mailformat)){
                emailError.innerHTML = "enter valid email";
                emailError.style.color = 'red';
                return false;  
        }
        if (password == ""){
                passwordError.innerHTML = "password can't be blank";
                passwordError.style.color = 'red';
                return false;  
        }
        if(password.length < 6){
                passwordError.innerHTML = " Password must be at least 6 char long";
                passwordError.style.color = 'red';
                return false;  
        }

}

function validateRegister() {
        
        const fname = document.getElementById('fname').value
        const lname = document.getElementById('lname').value 
        const email = document.getElementById('inputEmail').value 
        const password = document.getElementById('password').value 
        const cpassword = document.getElementById('cpassword').value 
        var fileInput = document.getElementById('inputfile').value
      

        
        
        //p element error message
        var nameError = document.getElementById('nameError')
        var emailError = document.getElementById('emailError')
        var passwordError = document.getElementById('passwordError')
        var cpasswordError = document.getElementById('cpasswordError')
        var fileError = document.getElementById('fileError')
       
        
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;


        if (fname == "" || lname == ""){
                nameError.innerHTML = "Name can't be blank";
                nameError.style.color = 'red';
                return false
        }
        if (email == "") {
                emailError.innerHTML = "Email can't be blank";
                emailError.style.color = 'red';
                return false;
        }
        if (!email.match(mailformat)) {
                emailError.innerHTML = "Enter valid email";
                emailError.style.color = 'red';
                return false;
        }
        if (password == "") {
                passwordError.innerHTML = "Password can't be blank";
                passwordError.style.color = 'red';
                return false;
        }
        if (password.length < 6) {
                passwordError.innerHTML = " Password must be at least 6 char long";
                passwordError.style.color = 'red';
                return false;
        }
        if (password != cpassword) {
                cpasswordError.innerHTML = "Password should be matched";
                cpasswordError.style.color = 'red';
                return false;
        }
        if (!fileInput) {
                //alert('Please upload the file');
                fileError.innerHTML = "Please upload the file";
                fileError.style.color = "red";
                return false
        }

        
        
}

// file validation

function fileValidation() {
        var fileInput = document.getElementById('inputfile');
        var fileError = document.getElementById('fileError')

        var filePath = fileInput.value;

        // Allowing file type
        var allowedExtensions =  /(\.jpg|\.jpeg|\.png|\.gif)$/i;

        
        if (!allowedExtensions.exec(filePath)) {
                fileError.innerHTML = "";
                fileError.innerHTML = "Invalid file type. accepted file types jpg/jpeg/PNG only";
                fileError.style.color = "red";
                fileInput.value = '';
                return false;
        }
}
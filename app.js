window.onload = function(){
    
    var loginclosebutton = document.getElementById('loginclosebutton');


loginclosebutton.addEventListener('click', function(){
    var loginarea = document.getElementById('login-area');
    loginarea.style.display = "none";
})


var signupclosebutton = document.getElementById('signupclosebutton');


signupclosebutton.addEventListener('click', function(){
    var signuparea = document.getElementById('signup-area');
    signuparea.style.display = "none";
})



}


function login_form_opener()
{   try{
    var signuparea = document.getElementById('signup-area');
    signuparea.style.display = "none";
}
catch(e)
{

}
    var loginarea = document.getElementById('login-area');
    loginarea.style.display="block";
}


function signup_form_opener()
{
    try{
        var loginarea = document.getElementById('login-area');
        loginarea.style.display = "none";
    }
    catch(e)
    {
        
    }
    var signuparea = document.getElementById('signup-area');
    signuparea.style.display = "block";
}






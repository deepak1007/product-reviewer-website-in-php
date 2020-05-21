

<div id='signup-area' style='position:fixed;' >

<div class="row">
    <div class="col-lg-10 col-12 offset-lg-1 ">
          <div class="site-logo">
              <h3 class='text-center'><small>ReviewIt</small></h3>
              <h4 class='text-center'><small>Sign up</small></h4>
          </div>

          <div class="signup-form mt-3">
              <form id='form'>
                  <input type="text" name="firstname" id="firstname" placeholder='First name' required>
                  
                  <input type="text" name="lastname" id="lastname" placeholder='Last Name' required>
                  <p id='lastname-modal' class='hidee' style='z-index:4;; display:none'></p>
                  <br>

                  <input type="text"  name="userid"  placeholder="username" id="userid" required>
                  <p id='username-modal' class='hidee' style='z-index:4;; display:none'></p><br>
                  <input type="text" name="email" id="email" placeholder='email' required>
                  <p id='email-modal' class='hidee' style='z-index:4;; display:none'></p><br>
                  <input type="password" name="password" id="password" placeholder="password" required>
                  <p id='password-modal' class='hidee' style='z-index:4;; display:none'></p><br>
                  <input type="password" name="passwordcf" id="passwordcf" placeholder="confirm password" required>
                  <p id='confirm-modal' class='hidee' style='z-index:4;; display:none'></p><br>
                  <button type='button' class='btn btn-success px-4 py-2 my-1' onclick='registration()'>Sign Up</button>
              </form>
          </div>

          <div class="extra-links mt-2 mb-3 ">
              <h4 class='text-center'><small>Already have an account? <span class='text-primary'  onclick='login_form_opener()'>Login</span></small></h4>
              <h5 class='text-center mt-3'><small>Forgot password? <span class='text-primary' onclick='forgotpassword()'> Reset Password</span></small></h5>
          </div>

         <div class="signupclosee" >
             <h3 id='signupclosebutton'>X</h3>
         </div>   
    </div>
</div>

</div>
</div>

<script>


function registration()
{    var form = document.getElementById('form');
     var formdata = new FormData();
     formdata.append('firstname', form.firstname.value);
     formdata.append('lastname', form.lastname.value);
     formdata.append('userid', form.userid.value);
     formdata.append("email", form.email.value);
     formdata.append("password", form.password.value);
     formdata.append("passwordcf", form.passwordcf.value);
     $('.hidee').hide();
     try{
         var conn = new XMLHttpRequest();
         conn.onreadystatechange = function(){
               if(conn.readyState == 4)
               { 
                   var response = JSON.parse(conn.responseText);
                    if(response['status'] == 200)
                    {    alert(response['data']);
                       window.location.reload();
                    }
                    else if(response['status']==202)
                    {
                       if(response['data']['email'] != 1)
                       {   
                           var modal = document.getElementById('email-modal');
                           modal.style.display = 'inline';
                           modal.style.color = 'red'
                           modal.innerText = response['data']['email'] ;
                       }
                       if(response['data']['full name'] != 1)
                       {   
                           var modal = document.getElementById('lastname-modal');
                           modal.style.display = 'inline';
                           modal.style.color = 'red'
                           modal.innerText =  response['data']['full name'] ;
                       }
                       if(response['data']['password'] != 1)
                       {   
                           var modal = document.getElementById('password-modal');
                           modal.style.display = 'inline';
                           modal.style.color = 'red'
                           modal.innerText =  response['data']['password'] ;
                       }
                       if(response['data']['confirm'] != 1)
                       {   
                           var modal = document.getElementById('confirm-modal');
                           modal.style.display = 'inline';
                           modal.style.color = 'red'
                           modal.innerText =  response['data']['confirm'];
                           
                       }
                       if(response['data']['userid'] != 1)
                       {   
                           var modal = document.getElementById('username-modal');
                           modal.style.display = 'inline';
                           modal.style.color = 'red'
                           modal.innerText =  response['data']['userid'];
                           
                       }

                    }
                     
                   //var stng = conn.responseText;
                   
               }
         }
        conn.open('POST', 'restapis/regis.php?action=setusercredentials', true);
        conn.send(formdata);

     }
    catch(e)
    {
        alert("something went wrong please try again after sometime");
    }
    }
</script>




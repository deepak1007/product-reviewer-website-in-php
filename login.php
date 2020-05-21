
<div id='login-area'>

    <div class="row">
        <div class="col-lg-10 col-12 offset-lg-1 ">
              <div class="site-logo">
                  <h1 class='text-center'><small>ReviewIt</small></h1>
                  <h2 class='text-center'><small>Login</small></h2>
              </div>

              <div class="login-form mt-5">
                  <form id='loginform'>
                      <input type="text"  name="username" placeholder="username or email " id="useremail"><br>
                      <input type="password" name="loginpassword" id="loginpassword" placeholder="password"><br>
                      <button type='button' class='btn btn-success px-4 py-2 my-1' onclick="login()">Login</button>
                  </form>
              </div>

              <div class="extra-links mt-5 mb-5 ">
                  <h4 class='text-center'><small>Don't have an account? <span class='text-primary'  onclick='signup_form_opener()'>Sign up</span></small></h4>
                  <h5 class='text-center mt-3'><small>Forgot password? <span class='text-primary' onclick='forgotpassword()'> Reset Password</span></small></h5>
              </div>

             <div class="closee" >
                 <h3 id='loginclosebutton'>X</h3>
             </div>   
        </div>
    </div>

</div>
</div>

<script>

    function login()
    {
        var form = document.getElementById('loginform');
        var formdata = new FormData();
        formdata.append("useremail", form.useremail.value);
        formdata.append("loginpassword", form.loginpassword.value);

        var conn = new XMLHttpRequest();
        conn.onreadystatechange = function(){
            if(conn.readyState==4)
            {
                var response = JSON.parse(conn.responseText);
                if(response['data'] == 'successfull')
                {   if(response['type']==0)
                    {location.reload();}
                    else
                    {
                        location.href='admintheme/index.php';
                    }
                }
                else
                {
                    alert(response['data']);

                }
            }
        }

        conn.open("POST", "restapis/regis.php?action=getlogincredentials", 1)
        conn.send(formdata);
    }
</script>
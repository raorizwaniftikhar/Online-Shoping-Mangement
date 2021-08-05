<!--pop up login(require)-->

<!--pop up login-->
       
    <div class="example">
        <ul id="nav">
             <!--<li><a id="button" >Login/Register</a></li> -->
             <li><a href="" >Mens</a>
			 <div>
			 <ul>
			 
			 <li><a href="kurta.php" >Kurta</a></li>
			 <li><a href="mfootwear.php" >Footwear</a></li>
			 <li><a href="kamez.php" >Kamez Shalwar</a></li>
			 </ul>
			 </div>
			 </li>
			  <li><a href="" >Womens</a>
			  <div>
			  <ul>
			  <li><a href="kurti.php" >Kurti</a></li>
			 <li><a href="stiched.php" >Stiched</a></li>
			 <li><a href="unstiched.php" >Unstiched</a></li>
			 
			 
			 <li><a href="footwear.php" >Footwear</a></li>
			 </ul></div></li>
             <li><a href="" >Teens</a>
			 <div><ul>
			 <li><a href="tgirls.php" >Girls</a></li>
			 <li><a href="tboys.php" >Boys</a></li>
			 
			 </ul></div></li> 
			  <li><a href="" >Kids</a>
			  <div><ul>
			 <li><a href="kgirls.php" >Girls</a></li>
			 <li><a href="kboys.php" >Boys</a></li>
			 <li><a href="infants.php" >Infants</a></li>
			 </ul></div></li> 
			   <li><a href="" >Accessories</a><div>
			   <ul>
			 <li><a href="ladiestrouser.php" >Ladies Trousers</a></li>
			 <li><a href="teenstrouser.php" >Teen's Trousers</a></li>
			 <li><a href="waistcoat.php" >Waist Coat</a></li>
			 <li><a href="handbag.php" >Handbag</a></li>
			 </ul></div></li> 
			    <li><a href="" >Wedding </a><div>
			   <ul>
			 <li><a href="sherwani.php" >Sherwani</a></li>
			 <li><a href="bridal.php" >Bridal outfits</a></li>
			 
			 </ul></div></li> 
				  
            
         </ul>
    </div><!--menu bar ends here-->
    <!--<div id="popupContact">
		<a id="popupContactClose">x</a>
		<h1>Login&nbsp;&nbsp;/&nbsp;&nbsp;Sign&nbsp;Up</h1>
        
		<p id="contactArea">
        
            <div id="login-area" >
           		 <h2> Login<h2>
                    <form id="loginfrm" name="loginfrm" action="index.php" method="post" onsubmit="return validate_user()" >
                    <input type="hidden" name="command" />
                            <table cellpadding="5" cellspacing="0">
                                  <tr>
                                  <td ><label>Username:</label></td>
                                  <td><input class="field" type="text"   size="28" onfocus="select();" name="username" style="color:#FFA953;  border-radius:5px;"  /></td>
                                  </tr>
                                
                                  <tr>
                                  <td ><label>Password:</label></td>
                                  <td><input class="field" type="password" size="28"onfocus="select();" name="password" style="color:#FFA953;  border-radius:5px;"  /></td>
                                  </tr>
                                  
                                  <tr>
                                  <td >         </td>
                                  <td><input class="btn"   type="submit"   value="Sign In" style="background:#FFA953; border:1px solid #FFA953; color:#FFFFFF; border-radius:5px; padding:3px 8px;"/></td>
                                  </tr>
                            </table>
                    </form>
            
            </div>
            
            
            
            
            <div id="register-area">
             <h2>Sign Up<h2>
                    <form id="registerfrm" name="registerfrm" action="index.php" method="post" onsubmit="return validate_register()" >
                    	<input type="hidden" name="command" />
                            <table cellpadding="5" cellspacing="0">
                            
                                  <tr>
                                  <td ><label>First Name: <span style="color:#F20000"> *</span></label></td>
                                  <td><input class="field" type="text" name="first_name"  size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" /></td>
                                  </tr>
                                  <tr>
                                  <td ><label>Last Name: <span style="color:#F20000"> *</span></label></td>
                                  <td><input class="field" type="text" name="last_name"  size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" /></td>
                                  </tr>
                                  
                                  <tr>
                                  <td ><label>Username:  <span style="color:#F20000"> *</span></label></td>
                                  <td><input class="field" type="text" name="username"  size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" /></td>
                                  </tr>
                                  
                                   <tr>
                                  <td ><label>Email:  <span style="color:#F20000"> *</span></label></td>
                                  <td><input class="field" type="email" name="email"  multiple="multiple" size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" /></td>
                                  </tr>
                                
                                  <tr>
                                  <td ><label>Password:  <span style="color:#F20000"> *</span></label></td>
                                  <td><input class="field" type="password" name="password"   size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" /></td>
                                  </tr>
                                  
                                   <tr>
                                  <td ><label> Confirm Password:  <span style="color:#F20000"> *</span></label></td>
                                  <td><input class="field" type="password" name="confpassword"  size="28" onfocus="select();" style="color:#FFA953;  border-radius:5px;" /></td>
                                  </tr>
                                  <tr>
                                  <td >         </td>
                                  <td><input class="btn"   type="submit"   value="Sign Up" style="background:#FFA953; border:1px solid #FFA953; color:#FFFFFF; border-radius:5px; padding:3px 8px;" style="color:#FFA953;  border-radius:5px;" /></td>
                                  </tr>
                            </table>
                    </form>
            
            </div>
            
    
            </p>
            
            
        
        
	</div>
	<div id="backgroundPopup"></div> -->
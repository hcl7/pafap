<div id="pafap_panel" style="margin-top:52px;">
<div id="pafap_panel_container">
  <div id="pafap_left_panel">
    <!-- left panel -->
    <p><img src="../images/LOGO_2.png" alt="pafap big logo" width="200" height="200" /></p>
  </div>
  <div itemscope itemtype="http://schema.org/signup" id="pafap_center_panel_signup">
<form id="frmsignup" method="post" action="<?PHP echo $_SERVER['PHP_SELF'];?>">
  <h3>Sign Up</h3>
  <table class="labeltext">
    <tr>
        <td align="right">First Name:</td>
        <td><input type="text" name="txtname" id="txtname" class="pafap_login" width="127" maxlength="20"/></td>
    </tr>
    <tr>
        <td align="right">Last Name:</td>
        <td><input type="text" name="txtlname" id="txtlname" class="pafap_login" width="127" maxlength="20" /></td>
    </tr>
    <tr>
        <td align="right">E-Mail:</td>
        <td><input type="text" name="txtmail" id="txtmail" class="pafap_input" width="157px" MaxLength="50"></asp:TextBox></td>
    </tr>
    <tr>
        <td align="right">Re-enter E-Mail:</td>
        <td><input type="text" name="txtremail" id="txtremail" class="pafap_input" width="157px" MaxLength="50"></asp:TextBox></td>
    </tr>
    <tr>
   	  <td align="right">I am:</td>
        <td><select class="controls" name="sex" id="sex">
          		<option selected="selected">Male</option>
          		<option>Female</option>
      		</select>
            <select class="controls" name="day" id="day">
			<option selected="selected">Day</option>
      		<option>01</option>
      		<option>02</option>
      		<option>03</option>
                  <option>04</option>
                	<option>05</option>
                	<option>06</option>
                	<option>07</option>
                	<option>08</option>
                	<option>09</option>
                	<option>10</option>
                	<option>11</option>
                	<option>12</option>
                	<option>13</option>
                	<option>14</option>
                	<option>15</option>
                	<option>16</option>
                	<option>17</option>
                	<option>18</option>
                	<option>19</option>
                	<option>20</option>
                	<option>21</option>
                	<option>22</option>
                	<option>23</option>
                	<option>24</option>
                	<option>25</option>
                	<option>26</option>
                	<option>27</option>
                	<option>28</option>
                	<option>29</option>
                	<option>30</option>
                	<option>31</option>
            </select>
            <select class="controls" name="month" id="month">
			<option selected="selected">Month</option>
            	    <option>01</option>
			        <option>02</option>
      		        <option>03</option>
                    <option>04</option>
                	<option>05</option>
                	<option>06</option>
                	<option>07</option>
                	<option>08</option>
                	<option>09</option>
                	<option>10</option>
                	<option>11</option>
                	<option>12</option>
            </select>
            <select class="controls" name="year" id="year">
			<option selected="selected">Year</option>
            <option>1950</option>
			<option>1951</option>
			<option>1952</option>
			<option>1953</option>
			<option>1954</option>
			<option>1955</option>
			<option>1956</option>
			<option>1957</option>
			<option>1958</option>
			<option>1959</option>
			<option>1960</option>
			<option>1961</option>
			<option>1962</option>
			<option>1963</option>
			<option>1964</option>
			<option>1965</option>
			<option>1966</option>
			<option>1967</option>
			<option>1968</option>
			<option>1969</option>
			<option>1970</option>
			<option>1971</option>
			<option>1972</option>
			<option>1973</option>
			<option>1974</option>
			<option>1975</option>
			<option>1976</option>
			<option>1977</option>
			<option>1978</option>
			<option>1979</option>
			<option>1980</option>
			<option>1981</option>
			<option>1982</option>
			<option>1983</option>
			<option>1984</option>
			<option>1985</option>
			<option>1986</option>
			<option>1987</option>
			<option>1988</option>
			<option>1989</option>
			<option>1990</option>
			<option>1991</option>
			<option>1992</option>
			<option>1993</option>
			<option>1994</option>
			<option>1995</option>
			<option>1996</option>
			<option>1997</option>
			<option>1998</option>
			<option>1999</option>
			<option>2000</option>
            <option>2001</option>
			<option>2002</option>
			<option>2003</option>
			<option>2004</option>
			<option>2005</option>
			<option>2006</option>
			<option>2007</option>
			<option>2008</option>
			<option>2009</option>
			<option>2010</option>
			<option>2011</option>
			<option>2012</option>
			<option>2013</option>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right">Password:</td>
        <td><input type="password" name="txtpass" id="txtpass" class="pafap_login" width="100px" TextMode="Password" MaxLength="17"></td>
    </tr>
    <tr>
        <td align="center">
            <button name="signup" id="signup" class="action blue"><span class="label">Sign Up</span></button>
        </td>
    </tr>
  </table>
<?php
error_reporting(0);
if(!isset($_SESSION))
{
  session_start();
}

if(isset($_POST['signup']))
{
  include ('pafap_classes/init.php');
  include ('pafap_classes/sign_up_class.php');
  include ('pafap_classes/templates_pafap_class.php');
  $tmpl = new pafap_templates;
  $signup = new pafap_SignUp();
  if($signup->process())
  {
    $tmpl->show_message($signup->show_errors(), 'pafap_success');
  }
  else
  {
    $tmpl->show_message($signup->show_errors(), 'pafap_error');
  }

}
$stoken = $_SESSION['signuptoken'] = md5(uniqid(mt_rand(), true));
?>
<input type="hidden" name="signuptoken" value="<?php echo $stoken; ?>" />
</form>
  </div>
  <!--center-->

<div id="pafap_right_signup_panel">
    <p>Social Network based on discussions by <strong>categories</strong> that are activated in the menu <strong>Profile</strong> in which can also upload images.</p>
    <p><strong>Similarities</strong> based on the types of categories and depends on the completion of the Profile menu.</p>
    <p><strong>You can talk about what you want and with the right persons for this.</strong></p>
    <br />
    <p>Copatible with <strong>FireFox 7.0</strong> and high, <strong>Google Crome</strong> and <strong>Opera</strong></p>
</div>
</div>
</div>

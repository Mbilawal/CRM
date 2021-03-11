<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('authentication/includes/head.php'); ?>
<body class="login_admin"<?php if(is_rtl()){ echo ' dir="rtl"'; } ?>>
 <div class="container">
  <div class="row">
   <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 authentication-form-wrapper">
    <div class="company-logo">
      <?php get_company_logo(); ?>
    </div>
    <div class="mtop40 authentication-form">
      <h1>Login as Franchise</h1>
      <div class="row">
  </div>
      <form action="https://crm.dryvarfoods.com/admin/authentication/login_merchant" method="post" accept-charset="utf-8">
                  <div class="form-group">
        <label for="email" class="control-label">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" autofocus="1">
      </div>
      <div class="form-group">
        <label for="password" class="control-label">Password</label>
        <input type="password" id="password" name="password" class="form-control"></div>
                <div class="checkbox">
          <label for="remember">
           <input type="checkbox" id="remember" name="remember"> Remember me         </label>
       </div>
       <div class="form-group">
       <input type="hidden" name="franchise" id="franchise" value="franchise" >
        <button type="submit" class="btn btn-info btn-block">Login</button>
      </div>
      <!--<div class="form-group">
        <a href="https://crm.dryvarfoods.com/admin/authentication/forgot_password">Forgot Password?</a>
      </div>-->

            </form>    </div>
  </div>
</div>
</div>
</body>
</html>

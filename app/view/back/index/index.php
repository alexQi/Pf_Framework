<div class="wrapper no-navigation preload">
	<div class="sign-in-wrapper">
		<div class="sign-in-inner">
			<div class="login-brand text-center">
				<i class="fa fa-database m-right-xs"></i><?php echo $this->Perfect->config['systemInfo']['system_name']; ?><strong class="text-skin">Login</strong>
			</div>
			<form id="login-form" method="post">
				<div class="form-group m-bottom-md">
					<label for="LoginForm_username" class="required">USERNAME</label>
					<input class="form-control" name="username" id="LoginForm_username" type="text">					
					<div class="errorMessage" id="LoginForm_username_em_" style="display:none"></div>				
				</div>
				<div class="form-group">
					<label for="LoginForm_password" class="required">PASSWORD</label>					
					<input class="form-control" name="password" id="LoginForm_password" type="password">					
					<div class="errorMessage" id="LoginForm_password_em_" style="display:none"></div>
				</div>

				<div class="m-top-md p-top-sm">
					<input class="btn btn-success" type="submit" name="yt0" value="Login">				
				</div>
			</form>
		</div>
	</div>
</div>
<a href="" id="scroll-to-top" class="hidden-print">
	<i class="icon-chevron-up"></i>
</a>
<?php
include 'config/config.php';
if (! empty ( $_SESSION ['uid'] ) && ! empty ( $_SESSION ['username'] )) {
	header ( "Location:./members.php" );
	exit ();
}
?>
<!doctype html>
<html lang="en" ng-app="scutechApp">
<head>
<meta charset="utf-8">
<title>数据部周报系统</title>
<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="lib/angular/angular.js"></script>
<script src="js/app.js"></script>
</head>
<body ng-controller="ListCtrl">

	<div class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">数据部周报系统</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">周报列表</a></li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
	<div class="container">
		<div class="panel panel-default ng-scope">
			<div class="panel-heading">登录</div>
			<div class="panel-body">
				<div class="panel-body">
					<form class="form-horizontal ng-pristine ng-valid" role="form">
						<div class="form-group">
							<label class="col-sm-offset-2 col-sm-2 control-label">用户名:</label>

							<div class="col-sm-3">
								<input type="text" class="form-control ng-pristine ng-valid"
									placeholder="" ng-model="formData.username">
							</div>


						</div>
						<div class="form-group">
							<label class="col-sm-offset-2 col-sm-2 control-label">密码:</label>

							<div class="col-sm-3">
								<input type="text" class="form-control ng-pristine ng-valid"
									placeholder="" ng-model="formData.password">
							</div>

						</div>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-6">
								<button type="button" class="btn btn-default" ng-click="login()">登录</button>
								<button type="button" class="btn btn-default"
									ng-click="forgetpass()">忘记密码</button>

							</div>
							<div class="col-sm-4"></div>

						</div>
					</form>
				</div>
			</div>
		</div>

	</div>

</body>
</html>
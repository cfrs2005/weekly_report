<!doctype html>
<html lang="en" ng-app="scutechApp">
<head>
<meta charset="utf-8">
<title>Angular Scutech</title>
<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css">
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
					<li class=""><a href="#">周报列表</a></li>
					<li class="active"><a href="#">添加员工</a></li>

				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
	<div class="container">
		<div class="panel panel-default ng-scope">
			<div class="panel-heading">员工列表</div>
			<div class="panel-body">

				<form class="form-horizontal ng-pristine ng-valid" role="form">
					<div class="form-group">
						<label class="col-sm-2 control-label">用户名</label>

						<div class="col-sm-4">
							<input type="text" class="form-control ng-pristine ng-valid"
								placeholder="" ng-model="editingEmployee.name">
						</div>


					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">密码</label>

						<div class="col-sm-4">
							<input type="text" class="form-control ng-pristine ng-valid"
								placeholder="" ng-model="editingEmployee.name">
						</div>


					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">邮箱地址</label>

						<div class="col-sm-4">
							<input type="text" class="form-control ng-pristine ng-valid"
								placeholder="" ng-model="editingEmployee.name">
						</div>


					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">上级</label>

						<div class="col-sm-4">
							<input type="text" class="form-control ng-pristine ng-valid"
								placeholder="" ng-model="editingEmployee.name">
						</div>


					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-1" ng-hide="editing"></div>
						<div class="col-sm-offset-2 col-sm-4" ng-hide="editing">
							<button type="button" class="btn btn-default" ng-click="create()">保存</button>

						</div>

					</div>
				</form>
			</div>
		</div>

	</div>
</body>
</html>
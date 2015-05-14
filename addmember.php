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
			 					<li class="active"><a href="#">周报列表</a></li>
			 				</ul>
			 			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
	<div class="container">
		<div class="panel panel-default ng-scope">
			<div class="panel-heading">员工列表</div>
			<div class="panel-body">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>员工号</th>
							<th>姓名</th>
							<th>职务</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="product in products">
							<td>{{ product.id }}</td>
							<td>{{ product.username }}</td>
							<td>{{ product.job }}</td>
							<td><a href="#">本周</a> / <a href="#">上周</a> / <a href="#">所有</a>
								/ <a href="#">发送邮件</a></td>
						</tr>
					</tbody>
				</table>

				<div class="panel panel-default ng-scope">
					<div class="panel-heading">添加周报 <font color="red">(本次编辑周报时间为<?php echo date('Y-m-d H:i:s');?>)</font></div>
					<div class="panel-body">
						<form class="form-horizontal ng-pristine ng-valid" role="form">
							<div class="form-group">
								<label class="col-sm-1 control-label">任务名</label>

								<div class="col-sm-3">
									<input type="text" class="form-control ng-pristine ng-valid"
										placeholder="" ng-model="editingEmployee.name">
								</div>

								<label class="col-sm-1 control-label">状态</label>
								<div class="col-sm-1">
									<select class="form-control">
										<option>完成</option>
										<option>延期</option>
									</select>
								</div>
								<label class="col-sm-1 control-label">描述</label>
								<div class="col-sm-4">
									<input type="text" class="form-control ng-pristine ng-valid"
										placeholder="" ng-model="editingEmployee.name">
								</div>

							</div>


							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-4" ng-hide="editing">
									<button type="button" class="btn btn-default"
										ng-click="create()">新增上周</button>
									<button type="button" class="btn btn-default"
										ng-click="modify()" ng-disabled="!selectedEmployee"
										disabled="disabled">新增本周</button>
									<button type="button" class="btn btn-default"
										ng-click="remove()" ng-disabled="!selectedEmployee"
										disabled="disabled">新增下周</button>
								</div>
								<div class="col-sm-offset-2 col-sm-4" ng-hide="editing">
									<button type="button" class="btn btn-default"
										ng-click="create()">保存</button>
											
								</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>
</body>
</html>
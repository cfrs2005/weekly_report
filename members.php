<?php require_once 'config/config.php';?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>数据部周报系统</title>
<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css">
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>

<script src="lib/angular/angular.js"></script>
<script src="js/app.js"></script>

</head>
<body>

	<div class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">数据部周报系统</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">周报列表</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION['username'];?>
							<span class="caret"></span> </a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">登出</a></li>
							<li><a href="#">修改密码</a></li>
						</ul></li>


				</ul>

			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
	<div class="container" ng-app="scutechApp" ng-controller="ListCtrl">
		<div class="panel panel-danger ng-scope">
			<div class="panel-heading">
				<h3 class="panel-title">周报列表</h3>
			</div>

			<div class="panel-body">
				<button class="btn btn-primary">添加周报</button>
				<br /> <br />

				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>周报时间:</th>
							<th>状态:</th>
							<th>操作:</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="product in products">
							<td>{{ product.week }}</td>
							<td>{{ product.status }}</td>
							<td><a href="#">修改</a> / <a href="#">删除</a> / <a href="#">发送</a></td>
						</tr>
					</tbody>
				</table>

				<div class="panel panel-default ng-scope">
					<div class="panel-heading">周报操作:</div>
					<div class="panel-body">
						<form class="form-horizontal ng-pristine ng-valid" role="form">
							<div class="form-group">
								<label class="col-sm-4 control-label">周报时间:</label>

								<div class="col-sm-3">
									<select class="form-control" ng-model="formData.weeklynum">
										<?php
										$weeks = Contaier::last_five_week_time ();
										foreach ( $weeks as $week ) {
											?>
											<option value="<?php echo $week['weeklynum']?>"><?php echo "第".$week['weeklynum']."周(".$week['monday']." / ".$week['sunday'].")";?></option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">周报内容:</label>
								<div class="col-sm-8">

									<textarea class="form-control" rows="10" placeholder="周报内容"
										ng-model="formData.content"></textarea>
								</div>

							</div>



							<div class="form-group">
								<label class="col-sm-4 control-label"></label>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary"
										ng-click="save(0)">提交</button>
									<button type="button" class="btn btn-danger" ng-click="save(1)">保存草稿</button>
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
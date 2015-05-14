var scutechApp = angular.module('scutechApp', []);

scutechApp.controller('ListCtrl', function($scope, $http) {
	$scope.products = [ {
		'week' : '2015-07-01 / 2015-07-07',
		'status' : '已经发送',
	}, {
		'week' : '2015-07-08 / 2015-07-14',
		'status' : '已经发送',
	}, {
		'week' : '2015-07-15 / 2015-07-21',
		'status' : '已经发送',
	}, {
		'week' : '2015-07-22 / 2015-07-28',
		'status' : '已经发送',
	}, {
		'week' : '2015-07-29 / 2015-08-07',
		'status' : '已经发送',
	}, {
		'week' : '2015-08-08 / 2015-08-14',
		'status' : '已经发送',
	} ];
	$scope.login = function() {
		alert('login time');
	}

	$scope.formData = {};

	$scope.login = function() {
		$http({
			method : 'POST',
			url : './curd.php?action=login',
			data : $.param($scope.formData),
			headers : {
				'Content-Type' : 'application/x-www-form-urlencoded'
			}
		}).success(function(result) {
			if (result.code == 0) {
				alert('登录成功');
			} else {
				alert(result.msg);
			}
			console.log(result);
		});
	}

	$scope.forgetpass = function() {
		alert('i am forget my password.this case i forgetton do it');
	}
});

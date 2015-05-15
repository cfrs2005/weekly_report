var scutechApp = angular.module('scutechApp', []);

scutechApp.controller('ListCtrl', function($scope, $http, $location, $window) {
	// $locationProvider.html5Mode(true);
	// $location.path('./members.php');

	// $rootScope.$apply();
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
				$window.location.href = 'members.php';
				// $location.path('members.php');
			} else {
				alert(result.msg);
			}
			// console.log(result);
		});
	}

	$scope.save = function(savetype) {
		$http({
			method : 'POST',
			url : './curd.php?action=saveworkly&savetype=' + savetype,
			data : $.param($scope.formData),
			headers : {
				'Content-Type' : 'application/x-www-form-urlencoded'
			}
		}).success(function(result) {
			if (result.code == 0) {
				alert('保存成功');
				$scope.getallweekly();
			} else {
				alert(result.msg);
			}
			// console.log(result);
		});
	}

	$scope.detail = function(e) {
		var weekly_num = $(e.target).data('id');
		$http({
			method : 'POST',
			url : './curd.php?action=getweeklydetail&weekly=' + weekly_num,
			data : $.param($scope.formData),
			headers : {
				'Content-Type' : 'application/x-www-form-urlencoded'
			}
		}).success(function(result) {
			if (result.code == 0) {
				$scope.formData = result.data;
				$scope.formData.weeklynum = {"id":weekly_num};
				$('#weekly_id').attr('disabled', true);

//				$("#weekly_id").addClass("disabled");
				// $scope.$apply(); // 强制通知
				// alert('保存成功');
			} else {
				alert(result.msg);
			}
			// console.log(result);
		});
	}

	$scope.del = function(e) {
		var weekly = $(e.target).data('id');
		$http({
			method : 'POST',
			url : './curd.php?action=dropweekly&weekly=' + weekly,
			data : $.param($scope.formData),
			headers : {
				'Content-Type' : 'application/x-www-form-urlencoded'
			}
		}).success(function(result) {
			if (result.code == 0) {
				alert('保存成功');
				$scope.getallweekly();
			} else {
				alert(result.msg);
			}
			// console.log(result);
		});
	}
	$scope.weeklist = [];
	
	$scope.getdailys = function() {
		$http({
			method : 'POST',
			url : './curd.php?action=getdailys',
			data : $.param($scope.formData),
			headers : {
				'Content-Type' : 'application/x-www-form-urlencoded'
			}
		}).success(function(result) {
			if (result.code == 0) {
				$scope.weeklist = result.data;
			} else {
				alert(result.msg);
			}
		});
	}

	$scope.getallweekly = function() {
		$http.get('./curd.php?action=getmemberweekly').success(
				function(data, status, headers, config) {
					if (data.code == 0) {
						// alert('读取数据成功');
						$scope.weeklylist = data.data;
					}
				}).error(function(data, status, headers, config) {
		});
	}
	$scope.getdailys();
	$scope.getallweekly();
	$scope.forgetpass = function() {
		alert('i am forget my password.this case i forgetton do it');
	}
});

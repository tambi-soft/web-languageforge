'use strict';

angular.module(
		'webtypesetting.projectSetup',
		[ 'jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate',
				'palaso.ui.notice', 'webtypesetting.services' ])

.controller(
		'projectSetupCtrl',
		[
				'$scope',
				'$state',
				'webtypesettingSetupService',
				'webtypesettingEditService',
				'sessionService',
				'modalService',
				'silNoticeService',
				function($scope, $state, webtypesettingSetupApi,
						webtypesettingEditService, sessionService, modal,
						notice) {

					$scope.renderRapuma = function renderRapuma() {

						webtypesettingEditService.render(function(result) {
							if (result.ok) {
								$scope.pdfUrl = result.data.pdfUrl;
							}
						});

					};

				} ]);

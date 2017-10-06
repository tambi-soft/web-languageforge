import * as angular from 'angular';

import { ActivityService } from './api/activity.service';
import { ApiService } from './api/api.service';
import { JsonRpcModule } from './api/json-rpc.service';
import { ProjectService } from './api/project.service';
import { UserService } from './api/user.service';
import { BytesFilter, RelativeTimeFilter } from './filters';
import { LinkService } from './link.service';
import { ModalService } from './modal/modal.service';
import { OfflineCacheService } from './offline-cache.service';
import { SessionService } from './session.service';
import { UtilityService } from './utility.service';

export const CoreModule = angular
  .module('coreModule', [JsonRpcModule])
  .service('projectService', ProjectService)
  .service('userService', UserService)
  .service('activityService', ActivityService)
  .service('apiService', ApiService)
  .service('sessionService', SessionService)
  .service('modalService', ['$uibModal', ModalService])
  .service('offlineCache', ['$window', '$q', OfflineCacheService])
  .service('linkService', LinkService)
  .service('utilService', UtilityService)
  .filter('bytes', BytesFilter)
  .filter('relativetime', RelativeTimeFilter)
  .name;
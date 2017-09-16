import 'angular';
import 'angular-ui-bootstrap';
import 'angular-route';
import 'angular-sortable-view';
import 'angular-zxcvbn';
import 'angular-translate';
import 'angular-translate-loader-static-files';
import 'angular-truncate-2';
import 'angular-ui-router';
import 'angular-ui-validate';

import 'ng-file-upload/dist/ng-file-upload-all.js';
import 'soundmanager2';

import './polyfills.browser';

// this is imported here to ensure JS files can use it
import './apps/changepassword/change-password-app.module';
import './apps/projects/projects-app.module';
import './apps/siteadmin/site-admin-app.module';
import './apps/usermanagement/user-management-app.module';
import './apps/userprofile/user-profile-app.module';
import './core/core.module';
import './shared/pui-utils.module';

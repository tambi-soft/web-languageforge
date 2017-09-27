import * as angular from 'angular';

import './login.scss';

export const LoginAppModule = angular
  .module('login', ['ui.bootstrap'])
  .controller('LoginCtrl', () => {})
  .name;

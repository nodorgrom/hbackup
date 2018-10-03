<?php 
/*
  Маршруты
*/

return array(
  'auth/login' => 'auth/login',
  'auth/register' => 'auth/register',
  'auth/confirming' => 'auth/confirming',
  'hosts/([0-9]+)' => 'hosts/view/$1',
  'hosts/edit/([0-9]+)' => 'hosts/edit/$1',
  'hosts/tools/edit' => 'hosts/toolsEdit',
  'hosts/tools' => 'hosts/tools',
  'hosts/add' => 'hosts/add',
  'hosts' => 'hosts/list'
);
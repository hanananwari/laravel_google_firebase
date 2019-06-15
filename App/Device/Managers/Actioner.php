<?php

namespace Solumax\GoogleFirebase\App\Device\Managers;

use Solumax\PhpHelper\App\ManagerBase as Manager;

use Solumax\GoogleFirebase\App\Device\DeviceModel;

 class Actioner extends Manager {
     
     protected $device;
     
     public function __construct(DeviceModel $device) {
         $this->device = $device;
     }
     public function __call($name, $arguments) {
         
         return $this->managerCaller($name, $arguments, $this->device, __NAMESPACE__, 'Actioners', 'action');
     }
 }

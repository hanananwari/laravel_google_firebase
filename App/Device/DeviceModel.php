<?php

namespace Solumax\GoogleFirebase\App\Device;

use Solumax\PhpHelper\App\BaseModel as Model;

class DeviceModel extends Model {

    protected $table = 'devices';
    protected $guarded = ['created_at', 'updated_at'];

    public function assign() {
        return new Managers\Assigner($this);
    }

    public function action() {
        return new Managers\Actioner($this);
    }

    public function validate() {
        return new Managers\Validator($this);
    }

    public function queryBuilder() {
        return new Managers\QueryBuilder($this);
    }

    public function topic() {
        return new Managers\Topic($this);
    }
}

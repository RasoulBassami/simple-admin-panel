<?php

namespace App\Traits;

use \Hekmatinasser\Verta\Facades\Verta;

trait  PersianDate
{
    public function PersianCreatedAt($format = "%d %B %Y")
    {
        return Verta::instance($this->created_at)->format($format);
    }

    public function PersianUpdatedAt($format = "%d %B %Y")
    {
        return Verta::instance($this->updated_at)->format($format);
    }

    public function PersianDeletedAt($format = "%d %B %Y")
    {
        return Verta::instance($this->deleted_at)->format($format);
    }
}

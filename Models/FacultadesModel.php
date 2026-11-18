<?php

class FacultadesModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "facultad";
    }
}

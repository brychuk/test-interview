<?php

namespace Survey\IndexBundle\Services;
use Survey\IndexBundle\Entity;

class UserSaverService
{

    protected $repository;

    public function __construct( $repository )
    {
        $this->repository = $repository;
    }

    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    public function getRepository()
    {
        return $this->repository ;
    }

}

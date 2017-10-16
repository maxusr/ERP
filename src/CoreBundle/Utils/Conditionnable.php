<?php
namespace CoreBundle\Utils;

interface Conditionnable {
    
    public function getAge();

    public function getName();

    public function getSexe();

    public function getRegion();

    public function getCompetence();

    public function getProfile();

    public function getDomaines();

    public function conditionOf();
}

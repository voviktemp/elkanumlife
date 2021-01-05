<?php


namespace  Entity\Interfaces;


use Entity\Profile;

interface RenderProfile
{
    static public function renderProfile(Profile $profile, string $file_name);
}
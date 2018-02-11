<?php

function create($class, $arguments = [])
{
    return factory($class)->create($arguments);
}

function make($class, $arguments = [])
{
    return factory($class)->make($arguments);
}
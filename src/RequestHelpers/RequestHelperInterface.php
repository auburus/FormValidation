<?php

namespace FormValidation\RequestHelpers;

interface RequestHelperInterface
{
    public function getQueryParams();

    /**
     * Should get the params as a normal request,
     * or if they are json encoded.
     */
    public function getBodyParams();

    public function getAllParams();
}

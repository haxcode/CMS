<?php

require("../vendor/autoload.php");
$openapi = \OpenApi\scan('../src');
//header('Content-Type: application/x-yaml');
$openapi->saveAs('../docs/api_docs/cms_swagger.json');

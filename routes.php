<?php

namespace Cartappio\Routes;

use SplitPHP\Request;
use SplitPHP\WebService;

class Products extends WebService
{
  public function init()
  {
    $this->setAntiXsrfValidation(false);

    //////////////
    // PRODUCTS //
    //////////////
    $this->addEndpoint('POST', '/v1/product', function ($params) {
      $record = $this->getService('products/product')->create($params);

      return $this->response
        ->withStatus(201)
        ->withData($record);
    });

    $this->addEndpoint('GET', '/v1/product/?key?', function ($key) {
      $filters = ['ds_key' => $key];
      $record = $this->getService('products/product')->get($filters);

      if (empty($record))
        return $this->response->withStatus(404);

      return $this->response
        ->withStatus(200)
        ->withData($record);
    });

    $this->addEndpoint('GET', '/v1/product', function ($params) {
      $records = $this->getService('products/product')->list($params);

      return $this->response
        ->withStatus(200)
        ->withData($records);
    });

    $this->addEndpoint('DELETE', '/v1/product/?key?', function ($key) {
      $filters = ['ds_key' => $key];
      $rowsAffected = $this->getService('products/product')->remove($filters);

      if ($rowsAffected < 1)
        return $this->response->withStatus(404);

      return $this->response->withStatus(204);
    });

    $this->addEndpoint('PUT', '/v1/product/?key?', function ($key, Request $req) {
      $payload = $req->getBody();
      $filters = ['ds_key' => $key];
      $rowsAffected = $this->getService('products/product')->upd($filters, $payload);

      if ($rowsAffected < 1)
        return $this->response->withStatus(404);

      return $this->response->withStatus(204);
    });

    ////////////////
    // CATEGORIES //
    ////////////////
    $this->addEndpoint('POST', '/v1/category', function ($params) {
      $record = $this->getService('products/category')->create($params);

      return $this->response
        ->withStatus(201)
        ->withData($record);
    });

    $this->addEndpoint('GET', '/v1/category/?key?', function ($key) {
      $filters = ['ds_key' => $key];
      $record = $this->getService('products/category')->get($filters);

      if (empty($record))
        return $this->response->withStatus(404);

      return $this->response
        ->withStatus(200)
        ->withData($record);
    });

    $this->addEndpoint('GET', '/v1/category', function ($params) {
      $records = $this->getService('products/category')->list($params);

      return $this->response
        ->withStatus(200)
        ->withData($records);
    });

    $this->addEndpoint('DELETE', '/v1/category/?key?', function ($key) {
      $filters = ['ds_key' => $key];
      $rowsAffected = $this->getService('products/category')->remove($filters);

      if ($rowsAffected < 1)
        return $this->response->withStatus(404);

      return $this->response->withStatus(204);
    });

    $this->addEndpoint('PUT', '/v1/category/?key?', function ($key, Request $req) {
      $payload = $req->getBody();
      $filters = ['ds_key' => $key];
      $rowsAffected = $this->getService('products/category')->upd($filters, $payload);

      if ($rowsAffected < 1)
        return $this->response->withStatus(404);

      return $this->response->withStatus(204);
    });
  }
}

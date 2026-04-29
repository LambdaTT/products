<?php

namespace Cartappio\Services;

use SplitPHP\Service;

class Category extends Service
{
  private const TABLE = "CTP_CATEGORY";

  public function create($data)
  {
    // Data whitelist:
    $data = $this->getService('utils/misc')->dataWhiteList(
      $data,
      [
        'ds_title',
        'tx_description',
        'ds_icon'
      ]
    );


    // Fill automatically generated fields:
    $data['ds_key'] = 'ctp-' . uniqid();
    $data['id_iam_user_created'] = $this->getService('iam/session')->getLoggedUser()?->id_iam_user;

    return $this->getDao(self::TABLE)->insert($data);
  }

  public function list($params = [])
  {
    return $this->getDao(self::TABLE)
      ->bindParams($params)
      ->find();
  }

  public function get($params = [])
  {
    return $this->getDao(self::TABLE)
      ->bindParams($params)
      ->first();
  }

  public function remove($params = [])
  {
    $cat = $this->get($params);
    if (!empty($cat) && !empty($cat->id_fmn_file_ico)) {
      $icoFile = $this->getService('filemanager/file')->get(['id_fmn_file' => $cat->id_fmn_file_ico]);
      if (!empty($icoFile)) $this->getService('filemanager/file')->remove(['id_fmn_file' => $cat->id_fmn_file_ico]);
    }

    return $this->getDao(self::TABLE)
      ->bindParams($params)
      ->delete();
  }

  public function upd($filters = [], $data = [])
  {
    $cat = $this->get($filters);

    // Data whitelist:
    $data = $this->getService('utils/misc')->dataWhiteList(
      $data,
      [
        'ds_title',
        'tx_description',
        'ds_icon'
      ]
    );

    // Fill automatically generated fields:
    $data['id_iam_user_updated'] = $this->getService('iam/session')->getLoggedUser()?->id_iam_user;
    $data['dt_updated'] = date('Y-m-d H:i:s');


    return $this->getDao(self::TABLE)
      ->bindParams($filters)
      ->update($data);
  }
}

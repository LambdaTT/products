<?php

namespace Cartappio\Services;

use SplitPHP\Service;

class Product extends Service
{
  private const TABLE = "PRD_PRODUCT";

  public function create($data)
  {
    // Data whitelist:
    $data = $this->getService('utils/misc')->dataWhiteList(
      $data,
      [
        'ds_name',
        'tx_description',
        'vl_price',
        'do_active',
        'do_requires_preparation',
        'do_order_progress',
        'id_prd_category'
      ]
    );

    // Treat Picture img file upload:
    if (!empty($_FILES['picture'])) {
      $pictureFile = $this->getService('filemanager/file')
        ->add($_FILES['picture']['name'], $_FILES['picture']['tmp_name'], 'Y');
      if (!empty($pictureFile))
        $data['id_fmn_file_picture'] = $pictureFile->id_fmn_file;
    }

    // Fill automatically generated fields:
    $data['ds_key'] = 'ctp-' . uniqid();
    $data['id_iam_user_created'] = $this->getService('iam/session')->getLoggedUser()?->id_iam_user;

    return $this->getDao(self::TABLE)->insert($data);
  }

  public function list($params = [])
  {
    return $this->getDao(self::TABLE)
      ->bindParams($params)
      ->find("products/product/read");
  }

  public function get($params = [])
  {
    return $this->getDao(self::TABLE)
      ->bindParams($params)
      ->first("products/product/read");
  }

  public function remove($params = [])
  {
    $prd = $this->get($params);
    if (!empty($prd) && !empty($prd->id_fmn_file_picture)) {
      $pictureFile = $this->getService('filemanager/file')->get(['id_fmn_file' => $prd->id_fmn_file_picture]);
      if (!empty($pictureFile)) $this->getService('filemanager/file')->remove(['id_fmn_file' => $prd->id_fmn_file_picture]);
    }

    return $this->getDao(self::TABLE)
      ->bindParams($params)
      ->delete();
  }

  public function upd($filters = [], $data = [])
  {
    $prd = $this->get($filters);

    // Data whitelist:
    $data = $this->getService('utils/misc')->dataWhiteList(
      $data,
      [
        'ds_name',
        'tx_description',
        'vl_price',
        'do_active',
        'do_requires_preparation',
        'do_order_progress',
        'id_prd_category'
      ]
    );

    // Fill automatically generated fields:
    $data['id_iam_user_updated'] = $this->getService('iam/session')->getLoggedUser()?->id_iam_user;
    $data['dt_updated'] = date('Y-m-d H:i:s');

    // Treats Picture img file upload:
    if (!empty($data['erase_picture'])) {
      if (!empty($prd->id_fmn_file_picture)) {
        $pictureFile = $this->getService('filemanager/file')->get(['id_fmn_file' => $prd->id_fmn_file_picture]);
        if (!empty($pictureFile)) $this->getService('filemanager/file')->remove(['id_fmn_file' => $prd->id_fmn_file_picture]);

        $data['id_fmn_file_picture'] = null;
      }

      unset($data['erase_picture']);
    } elseif (!empty($_FILES['picture'])) {
      if (!empty($prd->id_fmn_file_picture)) {
        $pictureFile = $this->getService('filemanager/file')->get(['id_fmn_file' => $prd->id_fmn_file_picture]);
        if (!empty($pictureFile)) $this->getService('filemanager/file')->remove(['id_fmn_file' => $prd->id_fmn_file_picture]);
        unset($pictureFile);
      }

      $pictureFile = $this->getService('filemanager/file')
        ->add($_FILES['picture']['name'], $_FILES['picture']['tmp_name'], 'Y');
      if (!empty($pictureFile))
        $data['id_fmn_file_picture'] = $pictureFile->id_fmn_file;
    }

    return $this->getDao(self::TABLE)
      ->bindParams($filters)
      ->update($data);
  }
}

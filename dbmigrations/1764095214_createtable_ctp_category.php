<?php

namespace Application\Migrations;

use SplitPHP\DbManager\Migration;
use SplitPHP\Database\DbVocab;

class CreatetableCtpCategory extends Migration
{
  public function apply()
  {
    $this->Table('PRD_CATEGORY')

      // Fields
      ->id('id_prd_category')
      ->string('ds_key', 17)
      ->datetime('dt_created')->setDefaultValue(DbVocab::SQL_CURTIMESTAMP())
      ->datetime('dt_updated')->nullable()->setDefaultValue(null)
      ->int('id_iam_user_created')->nullable()->setDefaultValue(null)
      ->int('id_iam_user_updated')->nullable()->setDefaultValue(null)
      ->string('ds_title', 100)
      ->text('tx_description')
      ->string('ds_icon', 255)

      // Indexes
      ->Index('KEY', DbVocab::IDX_UNIQUE)->onColumn('ds_key')

    ;
  }
}

<?php

namespace Application\Migrations;

use SplitPHP\DbManager\Migration;
use SplitPHP\Database\DbVocab;

class AddcolumncategoryinCtpProduct extends Migration
{
  public function apply()
  {
    $this->Table('CTP_PRODUCT')
      ->fk('id_ctp_category')->nullable()->setDefaultValue(null)

      ->Foreign('id_ctp_category')
      ->references('id_ctp_category')
      ->atTable('CTP_CATEGORY')
      ->onUpdate(DbVocab::FKACTION_CASCADE)
      ->onDelete(DbVocab::FKACTION_SETNULL)

    ;
  }
}

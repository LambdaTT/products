<?php

namespace Application\Migrations;

use SplitPHP\DbManager\Migration;
use SplitPHP\Database\DbVocab;

class AddcolumncategoryinCtpProduct extends Migration
{
  public function apply()
  {
    $this->Table('PRD_PRODUCT')
      ->fk('id_prd_category')->nullable()->setDefaultValue(null)

      ->Foreign('id_prd_category')
      ->references('id_prd_category')
      ->atTable('PRD_CATEGORY')
      ->onUpdate(DbVocab::FKACTION_CASCADE)
      ->onDelete(DbVocab::FKACTION_SETNULL)

    ;
  }
}

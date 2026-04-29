<?php

namespace Application\Migrations;

use SplitPHP\DbManager\Migration;
use SplitPHP\Database\DbVocab;

class CreatetableCtpProduct extends Migration
{
  public function apply()
  {
    $this->Table('CTP_PRODUCT')
      // Fields
      ->id('id_ctp_product')
      ->string('ds_key', 17)
      ->datetime('dt_created')->setDefaultValue(DbVocab::SQL_CURTIMESTAMP())
      ->datetime('dt_updated')->nullable()->setDefaultValue(null)
      ->int('id_iam_user_created')->nullable()->setDefaultValue(null)
      ->int('id_iam_user_updated')->nullable()->setDefaultValue(null)
      ->fk('id_fmn_file_picture')->nullable()->setDefaultValue(null)
      ->string('ds_name', 100)
      ->float('vl_price')
      ->string('do_active', 1)->setDefaultValue('Y') // Y = yes, N = no
      ->string('do_requires_preparation', 1)->setDefaultValue('N') // Y = yes, N = no
      ->text('tx_description')->nullable()->setDefaultValue(null)
      ->string('do_order_progress', 1)->nullable()->setDefaultValue(null)

      // Foreign Keys:
      ->Foreign('id_fmn_file_picture')
      ->references('id_fmn_file')
      ->atTable('FMN_FILE')
      ->onUpdate(DbVocab::FKACTION_CASCADE)
      ->onDelete(DbVocab::FKACTION_SETNULL)

      // Indexes
      ->Index('KEY', DbVocab::IDX_UNIQUE)->onColumn('ds_key')
    ;
  }
}

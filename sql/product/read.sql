SELECT
    prd.*,
    fle.ds_url as ds_picture_url
  FROM `CTP_PRODUCT` prd
  LEFT JOIN `FMN_FILE` fle ON (fle.id_fmn_file = prd.id_fmn_file_picture)
<?php

namespace Drupal\ra_drupal;

use Emerap\Ra\Base\Database;

class RaDrupalDatabase extends Database {

  /**
   * {@inheritdoc}
   */
  public function create($table, $fields = array()) {
    $record = \Drupal::database()->insert($table)
      ->fields(array_keys($fields), array_values($fields))
      ->execute();

    return $record;
  }

  /**
   * {@inheritdoc}
   */
  public function read($table, $fields = array()) {
    $record = \Drupal::database()->select($table, 't')
      ->fields('t');

    foreach ($fields as $key => $val) {
      $record = $record->condition('t.' . $key, $val);
    }

    if ($req = $record->execute()->fetchAssoc()) {
      return $req;
    }

    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function update($table, $field, $value, $fields = array()) {
    return \Drupal::database()->update($table)
      ->fields($fields)
      ->condition($field, $value)
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function delete($table, $field, $value) {
    return $record = \Drupal::database()->delete($table)
      ->condition($field, $value)
      ->execute();
  }

}

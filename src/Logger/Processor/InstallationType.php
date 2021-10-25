<?php

namespace Drupal\fac_logger\Logger\Processor;

/**
 * Class installation_type processor.
 */
class InstallationType {

  /**
   * Implements invoke.
   *
   * @param array $record
   *   The record.
   *
   * @return array
   *   The result.
   */
  public function __invoke(array $record) {
    $record['extra']['installation_type'] = \Drupal::state()->get('installation_type', 'unknown');
   
    if ($installation_name = \Drupal::state()->get('installation_name')) {
      $record['extra']['installation_name'] = $installation_name;
    }
    
    if ($phab_config_name = \Drupal::state()->get('phab_config_name')) {
      $record['extra']['phab_config_name'] = $phab_config_name;
    }

    return $record;
  }

}

<?php

namespace Drupal\fac_logger\Logger\Processor;

use Monolog\LogRecord;

/**
 * Class installation_type processor.
 */
class InstallationType {

  /**
   * Implements invoke.
   *
   * @param array|LogRecord $record
   *   The record.
   *
   * @return array|LogRecord
   *   The result.
   */
  public function __invoke(array|LogRecord $record) {
    if ($record instanceof \Monolog\LogRecord) {
      $record = $record->toArray();
    }

    // Remove any args from a possible backtrace:
    if (isset($record['context']['backtrace']) && is_array($record['context']['backtrace'])) {
      foreach (array_keys($record['context']['backtrace']) as $ndx) {
        unset($record['context']['backtrace'][$ndx]['args']);
        unset($record['context']['backtrace'][$ndx]['object']);
      }
    }

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

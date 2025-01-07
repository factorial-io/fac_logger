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
    // LogRecord doesn't have unset method.
    // we can't use is_array because LogRecord consider an array in php.
    if (!$record instanceof LogRecord) {
      $this->removeBacktraceDetails($record);
    }
    else {
      $record_array = $record->toArray();
      if (isset($record_array['context'])) {
        $this->removeBacktraceDetails($record_array);
        $record = $record->with(context: $record_array['context']);
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

  /**
   * Removes arguments and objects from the backtrace if present.
   *
   * @param array $record
   *   The record array.
   */
  private function removeBacktraceDetails(array &$record)
  {
    if (isset($record['context']['backtrace']) && is_array($record['context']['backtrace'])) {
      foreach (array_keys($record['context']['backtrace']) as $ndx) {
        unset($record['context']['backtrace'][$ndx]['args']);
        unset($record['context']['backtrace'][$ndx]['object']);
      }
    }
  }

}

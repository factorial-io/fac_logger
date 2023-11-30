# installation

1. install via `composer require factorial-io/fac_logger`
2. Add the following lines to `sites/default/services.yml`

        monolog.channel_handlers:
          default: ['gelf']
        monolog.processors: ['installation_type', 'message_placeholder', 'current_user', 'request_uri', 'ip', 'referer', 'memory_usage']

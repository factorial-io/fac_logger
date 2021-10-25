# installation

1. add the repo to your `composer.json`
2. 
        {
            "type": "vcs",
            "url": "https://github.com/factorial-io/fac_logger"
        },
        
3. install via `composer install factorial-io/fac_logger`
4. Add the following lines to `sites/default/services.yml`

        monolog.channel_handlers:
          default: ['gelf']
        monolog.processors: ['installation_type', 'message_placeholder', 'current_user', 'request_uri', 'ip', 'referer', 'memory_usage']

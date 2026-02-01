# Webapi

## Usage

**Console**

```
➜ bin/console
Webapi 1.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  completion                        Dump the shell completion script
  help                              Display help for a command
  list                              List commands
 dbal
  dbal:run-sql                      Executes arbitrary SQL directly from the command line.
 debug
  debug:messenger                   List messages you can dispatch using the message buses
 doctrine
  doctrine:fixtures:load            Load data fixtures to your database
 messenger
  messenger:consume                 Consume messages
  messenger:failed:remove           Remove given messages from the failure transport
  messenger:failed:retry            Retry one or more messages from the failure transport
  messenger:failed:show             Show one or more messages from the failure transport
  messenger:setup-transports        Prepare the required infrastructure for the transport
  messenger:stats                   Show the message count for one or more transports
 migrations
  migrations:current                [current] Outputs the current version
  migrations:diff                   [diff] Generate a migration by comparing your current database to your mapping information.
  migrations:dump-schema            [dump-schema] Dump the schema for your database to a migration.
  migrations:execute                [execute] Execute one or more migration versions up or down manually.
  migrations:generate               [generate] Generate a blank migration class.
  migrations:latest                 [latest] Outputs the latest version
  migrations:list                   [list-migrations] Display a list of all available migrations and their status.
  migrations:migrate                [migrate] Execute a migration to a specified version or the latest available version.
  migrations:rollup                 [rollup] Rollup migrations by deleting all tracked versions and insert the one version that exists.
  migrations:status                 [status] View the status of a set of migrations.
  migrations:sync-metadata-storage  [sync-metadata-storage] Ensures that the metadata storage is at the latest version.
  migrations:up-to-date             [up-to-date] Tells you if your schema is up-to-date.
  migrations:version                [version] Manually add and delete migration versions from the version table.
 orm
  orm:clear-cache:metadata          Clear all metadata cache of the various cache drivers
  orm:generate-proxies              [orm:generate:proxies] Generates proxy classes for entity classes
  orm:info                          Show basic information about all mapped entities
  orm:mapping:describe              Display information about mapped objects
  orm:run-dql                       Executes arbitrary DQL directly from the command line
  orm:schema-tool:create            Processes the schema and either create it directly on EntityManager Storage Connection or generate the SQL output
  orm:schema-tool:drop              Drop the complete database schema of EntityManager Storage Connection or generate the corresponding SQL output
  orm:schema-tool:update            Executes (or dumps) the SQL needed to update the database schema to match the current mapping metadata
  orm:validate-schema               Validate the mapping files
```


## Development

**Make**

```
➜ make
Usage:
  make <target>

Targets:
  clean                Clear project folders
  cs                   Check PHP code style
  csf                  Fix PHP code style
  db-diff              Run migrations
  db-fixtures-dev      Run development fixtures
  db-fixtures-prod     Run production fixtures
  db-migrate           Run migrations
  db-proxy             Generate proxies
  dev                  Run PHP development server for API
  init                 Init project for the first time
  install-php          Install PHP dependencies
  install              Install all dependencies
  mcp-inspect          Run MCP inspector
  mcp-stdio            Run MCP inspector for stdio server
  phpstan              Check static analysis
  setup                Create and setup project skeleton
  test-app             Run PHP phpunit with App suitcase
  test-coverage-html   Generate PHP phpunit html code coverage
  test-coverage-text   Generate PHP phpunit text code coverage
  test                 Run PHP phpunit tests
  warmup               Warm project (called during starting container)
```

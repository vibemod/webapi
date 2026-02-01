# Agents Configuration

This file configures Claude. Read and follow the rules in `.cursor/rules/` before generating code or providing guidance.

## Rule Files

| File | Description |
|---|---|
| `api.mdc` | REST API patterns, controllers, request/response structure |
| `api-tests.mdc` | API endpoint testing patterns |
| `app.mdc` | Application-level classes, configuration, conventions |
| `bus.mdc` | Command/Query Bus, CQRS, handler patterns |
| `codestyle.mdc` | Code style, import ordering |
| `date.mdc` | Date/time handling with Carbon |
| `docs.mdc` | Documentation standards |
| `doctrine.mdc` | Entities, repositories, ORM patterns |
| `domain-structure.mdc` | Domain layer directory structure (DDD) |
| `dto.mdc` | Data Transfer Objects, `fromEntity()` factories |
| `engineer.mdc` | General engineering practices |
| `events.mdc` | Domain events and subscribers |
| `exceptions.mdc` | Exception handling patterns |
| `php.mdc` | PHP 8.4 coding standards |
| `services.mdc` | Domain services, dependency injection |
| `testing.mdc` | Unit and integration testing |
| `uuid.mdc` | UUID v7 generation and usage |

Template code lives in `.cursor/code/`. Use it as the reference when scaffolding new entities.

## Instructions

### Process Management

- **NEVER kill any processes** unless explicitly requested by the author.
- **NEVER start development servers** unless explicitly requested by the author.
- Only run commands necessary for the specific task.
- Do not interfere with the existing development environment or running processes.

### Code Generation

- Read the relevant `.cursor/rules/*.mdc` files before writing any code.
- Use `.cursor/code/` templates as the starting point for new entities.
- Follow established naming conventions and directory structure per `domain-structure.mdc`.
- Return DTOs from handlers, never raw entities.
- Do not add PHPDoc comments unless the user explicitly requests them — PHP 8.4 type hints are sufficient.

### Bus Usage

- **CommandBus** — use for mutations (create, update, delete).
- **QueryBus** — use for queries (get, list).
- Every command/query has exactly one handler annotated with `#[AsMessageHandler]`.
- Handlers contain all logic in `__invoke()` — do not split into multiple methods.
- Dispatch domain events after successful mutations.

### Quality Tools

- `make phpstan` — static analysis (never run PHPStan directly).
- `make cs` — check code style (never run code sniffer directly).
- `make csf` — fix code style violations.
- `make test` — run the full test suite.
- Direct `vendor/bin/phpunit <file>` is acceptable only when testing a single file.

### Tech Stack

- **PHP 8.4** with strict types
- **Doctrine ORM** for persistence
- **Symfony Messenger** (`contributte/messenger`) for CQRS
- **FrameX** (`contributte/framex`) for HTTP responses
- **Nette Schema** for request validation
- **Carbon** for date/time
- **UUID v7** for primary keys

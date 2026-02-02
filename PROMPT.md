# PROMPTS

1. Entity + API CRUD + Tests

```
Add a new **{Entity}** entity with full CRUD
- migration,
- domain layer (entity, repository, DTOs, CQRS commands/queries/events)
- API layer (controllers, requests, responses)
- config registration
- E2E tests.

Follow the exact patterns from @src/Domain/User, @src/Api/User, and @tests/E2E/Api/User.
Define the entity fields as a table below.

Run make phpstan, make cs, make test — all must pass.
```

---
description: List recent commits, analyze commit pattern, and commit changes from current context
tags: [git, commit, version-control]
---

When the user invokes the `/git` slash command:

1. **List Recent Commits**: Run `git log --oneline -20` to display the last 20 commit messages
2. **Analyze Commit Pattern**: Review the commit message format used in the repository
   - Pattern: `{Category}: {description}`
   - Examples:
     - `Dashboard: split MDB stats into epg/matched sections and add sitemaps endpoint`
     - `TitlePlan: rename status to match better names`
     - `Filmdex: parse episode, movie, season, tvshow in sitemap`
3. **Commit Changes**: Stage and commit only the changes made in the current chat/context
   - Use `git status --short` to identify modified and new files
   - Stage only files that were changed during the current conversation
   - Generate a commit message following the established pattern: `{Category}: {description}`
   - Determine the appropriate category based on the files changed (e.g., `Epg`, `Tests`, `Model`, etc.)
   - Write a clear, concise description of what was changed

**Example Workflow:**
```bash
# 1. List recent commits to understand pattern
git log --oneline -20

# 2. Check current changes
git status --short

# 3. Stage only files from current context
git add <files-changed-in-this-chat>

# 4. Commit with pattern
git commit -m "{Category}: {description}"
```


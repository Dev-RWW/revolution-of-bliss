# Revolution of Bliss - Hub Engine

## Project Overview
This repository contains the core logic and routing engine for the **Revolution of Bliss** platform. It operates on a **Hub-and-Spoke architecture**, where a central PHP engine serves multiple satellite domains (Spokes) via dynamic path mapping and shared configuration.

## System Architecture (Hub-and-Spoke)
- **The Hub:** The primary engine located in `revolutionofbliss-php`.
- **The Spokes:** Satellite domains (e.g., `aquarianfire.live`, `chitsat.live`) that symlink to the Hub's entry points.
- **Mapping Logic:** Site-specific content and behavior are determined by domain-based routing defined in `global.php`.

## Tech Stack
- **Language:** PHP 8.x
- **Server:** Apache/Linux (InMotion Hosting environment)
- **Version Control:** Git-flow (Strict branching strategy)
- **Dependency Management:** Composer

## Environment Setup
### Prerequisites
- SSH access to the production server.
- PHP 8.1+ and the `mbstring`, `pdo`, and `openssl` extensions.
- Composer installed globally.

### Local Configuration
1. Clone the repository.
2. Ensure file permissions allow the web server to execute `public_html` entry points.
3. Configuration variables are managed via `config/env.php` (not tracked in version control).

## Development Process (Agile/SAFe)
To maintain the integrity of the proprietary IP and the live production environment:

1. **Feature Branches:** All work must be done in `feature/name-of-logic` branches.
2. **Pull Requests:** Merges to `main` require a formal Pull Request on GitHub.
3. **Audit Trail:** Use descriptive commit messages. Every merge to `main` must be tagged with a version number (e.g., `v1.0.1`).

## Deployment
Deployment is handled via a Git `post-receive` hook on the production server. 
- Pushing to the `main` branch triggers an automatic checkout to the live web directory.
- Run `composer install --no-dev` after significant architectural changes.

---
**Owner:** Revolution of Bliss Anchor  
**Contact:** developer@revolutionofbliss.live
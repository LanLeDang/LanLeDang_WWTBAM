# LanLeDang_WWTBAM

Panther Millionaire is a PHP, HTML, and CSS trivia game inspired by **Who Wants to Be a Millionaire**. Two players register accounts, log in, and take turns answering 15 cat-trivia questions. The game includes three difficulty tiers, lifelines, a walk-away option, and a leaderboard that keeps track of scores.

## Team Members
- **Lan Le Dang** — Project Leader, PHP logic, session handling, debugging, GitHub coordination
- **Cristin Khor** — UI design, CSS styling, layout, testing, and integration

## Main Features
- leaderboard using sessions and cookies
- registration and login system
- PHP form processing with validation
- turn-based 2-player gameplay
- responsive design for desktop and mobile

## Topic 02 Features
- 2-player match flow
- 15-question progression
- 3 difficulty tiers: easy, medium, and hard
- lifelines: 50/50, hint, and pass
- walk-away option
- prize and score tracking with sessions

## File Overview
- `index.php` — homepage
- `register.php` — player registration
- `login.php` — 2-player login
- `lobby.php` — match overview before the game starts
- `game.php` — main gameplay page
- `result.php` — shows answer results and turn outcomes
- `leaderboard.php` — leaderboard and saved scores
- `logout.php` — ends the session
- `team.html` — team intro page
- `style.css` — styling and responsive design
- `includes/bootstrap.php` — starts the session and loads required files
- `includes/data.php` — question bank and prize ladder
- `includes/helpers.php` — helper functions for accounts, sessions, leaderboard, and gameplay

## How to Run It
1. Upload the whole project folder to the CODD server.
2. Keep the files in the same folder structure.
3. Open `index.php` in the browser.
4. Register two player accounts.
5. Log in with both accounts to start the game.

## AI Usage Disclosure
AI tools were used to help with brainstorming, code organization, debugging support, comment cleanup, wording for documentation, and explanation of PHP logic. AI assistance was also used to help revise styling ideas and improve clarity in written materials such as the README and project documentation. All code was reviewed, edited, tested, and understood by the team before submission. Final decisions, integration, testing, and project presentation preparation were completed by the team.
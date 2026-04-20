Panther Millionaire
Project Report

Team Members:
Lan Le Dang
Cristin Khor

Project Overview:
Panther Millionaire is a PHP, HTML, and CSS trivia game inspired by Who Wants to Be a Millionaire. It is a 2-player game where both players register accounts, log in, and take turns answering 15 cat-trivia questions. The game uses three difficulty tiers, lifelines, and a walk-away option. PHP sessions and cookies are used to keep track of player progress, scores, and leaderboard results.

Features Built:
Built a 2-player trivia game inspired by Who Wants to Be a Millionaire
Added player registration and login
Added a session-based match flow
Added a cookie-based leaderboard that stores and sorts top scores
Added 15 total questions:
5 easy
5 medium
5 hard

Added lifelines:
50/50
Hint
pass

Added a walk-away option so a player can stop and keep current winnings
Created these pages:

Team Intro page
Homepage
registration page
login page
lobby page
gameplay page
result page
leaderboard page
logout page
Styled the project with CSS
Made the project responsive for both desktop and mobile

Challenges Faced:
Making sure two different players could log in and play in the same match
Keeping the turn order correct
Tracking player progress, winnings, lifelines, and penalties across multiple pages without using a database
Making sure the leaderboard saved scores correctly
Making sure the project matched the Topic 02 requirements:
15 levels
Lifelines
difficulty tiers
turn-based play
walk-away option

Solutions and Lessons Learned:
Used PHP sessions to store both players and the active turn
Used browser-saved account data and helper functions for registration and login
Fixed leaderboard issues by controlling when scores were saved and how they were sorted
Improved our understanding of:
PHP sessions
form validation
multi-page game flow
responsive CSS
Learned the importance of testing, cleanup, and documentation

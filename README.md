# PitchBoard — Startup Idea Pitch Board (PHP + MySQL)

## Quick overview
A mini web-app where students pitch startup ideas, like ideas (Ajax), and comment. Built with PHP (mysqli), MySQL, Bootstrap, jQuery.

## Requirements
- XAMPP (Apache + MySQL)
- PHP 7.4+ (PHP 8 recommended)
- Modern browser

## Installation / Setup (baby steps)
1. **Install XAMPP**
   - Download from https://www.apachefriends.org/ and install.
   - Start **Apache** and **MySQL** from XAMPP Control Panel.

2. **Create project folder**
   - Copy the `pitchboard` folder into XAMPP's `htdocs`:
     - Windows: `C:\xampp\htdocs\pitchboard`
     - macOS (MAMP/XAMPP): `/Applications/XAMPP/htdocs/pitchboard`

3. **Create database**
   - Open `http://localhost/phpmyadmin/`
   - Click SQL and import file `sql/pitchboard.sql` (or paste contents and run).
   - This creates database `pitchboard` and tables `ideas`, `comments`. It also inserts sample data.

4. **Configure DB credentials (if needed)**
   - Open `db_connect.php`. Default is:
     ```php
     $DB_HOST = 'localhost';
     $DB_USER = 'root';
     $DB_PASS = '';
     $DB_NAME = 'pitchboard';
     ```
   - If you use a MySQL password, change `$DB_PASS`.

5. **Open app**
   - Visit: `http://localhost/pitchboard/index.php`

## Files explained
- `index.php` — Home / explore ideas (grid + trending)
- `submit_idea.php` — Submit new idea form
- `view_idea.php` — Idea details + comments
- `like_idea.php` — Ajax endpoint to increment likes
- `add_comment.php` — Ajax endpoint to add a comment
- `db_connect.php` — DB connection (include in pages)
- `assets/css/style.css` — Custom styling (Gen-Z aesthetic)
- `assets/js/main.js` — Ajax event handlers

## Test checklist
- [ ] Start Apache & MySQL in XAMPP.
- [ ] Import `sql/pitchboard.sql`.
- [ ] Visit `index.php`, see seeded ideas.
- [ ] Click like -> number should increase (no reload).
- [ ] Click + Pitch Idea -> submit -> redirected to home & see new idea.
- [ ] View idea -> post comment -> comment appears immediately.

## Troubleshooting
- "Cannot connect to DB": check `db_connect.php` credentials and whether MySQL is running.
- "404": ensure folder path is `htdocs/pitchboard` and you opened `http://localhost/pitchboard/index.php`.
- JS not working: check console for errors; ensure `assets/js/main.js` is loaded (footer includes it).

Enjoy — tweak colors in `assets/css/style.css` to fit your vibe!

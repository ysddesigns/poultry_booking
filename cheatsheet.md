1. "What Methodology did you use?"
Answer: "I used the Agile Incremental Model."

Justification: "I didn't build the whole system at once. I broke it down into iterations:

Iteration 1: Database & Environment setup.

Iteration 2: User Authentication & Dashboard.

Iteration 3: Admin Control Panel.

This allowed me to test and fix bugs in smaller chunks."

2. "How is your system architected?"
Answer: "I used a Modular Architecture focusing on Separation of Concerns."

Justification: "I did not dump all my code into one file.

Database Logic is isolated in config/db.php.

UI Elements (Header/Footer) are separated in the includes/ folder (DRY Principle - Don't Repeat Yourself).

Admin Logic is secured in a separate /admin directory.

This makes the system easier to maintain and scale."

3. "How did you ensure Security?"
Answer: "I implemented security at three layers:"

Database Security: "I used Prepared Statements with PDO to prevent SQL Injection attacks. Input is never concatenated directly into queries."

Password Security: "Passwords are never stored as plain text. I used password_hash() (BCrypt) to encrypt them before storage."

Access Control: "I used Session Management to protect pages. A user cannot access the Dashboard without a valid session, and a regular user cannot access the Admin Panel."

4. "Explain your Database Design."
Answer: "I used a Relational Database Management System (RDBMS) with Third Normal Form (3NF)."

Justification: "I have two distinct entities: Users and Bookings.

Instead of repeating user details in every booking, I used a Foreign Key (user_id) to link them.

This ensures Data Integrity—if a user updates their phone number, it reflects across all their bookings automatically."

Testing Protocol (Sanity Check)
Before handing this over, run through this quick checklist to ensure no "demo fails" happen:

The "Hacker" Test: Try to go to http://localhost/poultry_booking/admin/dashboard.php without logging in.

Expected: You should be bounced back to the Login page.

The "SQL" Test: Try to register with the name O'Reilly.

Expected: It should register successfully without crashing (proving Prepared Statements work).

The "Workflow" Test:

User A books 50 Broilers.

Admin logs in, sees User A's order, and clicks "Approve".

User A logs back in. Does the status say "Approved"?
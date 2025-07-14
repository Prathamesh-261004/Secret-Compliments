Title: Secret Compliments
Description: A platform where users can register, upload photos, and receive anonymous compliments from friends after mutual request acceptance. Includes reactions, comments, admin tools, and reporting system.

🗂️ Key Folders and Files
🔧 Root Directory (/)
index.php – Login page

register.php – User registration with profile photo

home.php – Main dashboard showing posts, users, requests

profile.php – User can edit profile and upload images

user.php – View another user's posts

comment.php – Handle comment submission

react.php – Handle emoji reaction

report.php – Report a comment

logout.php – Logout script

delete_account.php – User or admin account deletion

friend_request.php – Friend request logic (send, accept, reject, unfriend)

🧠 Admin Tools
admin_login.php

dashboard.php – Admin user list with delete option

stats.php – Overall app statistics

reports.php – View reported comments

delete_comment.php – Admin deletes a comment

📂 phpmailer/
Contains:

PHPMailer.php

SMTP.php

Exception.php

Used for OTP or email features (optional but included)

📂 uploads/
Stores all uploaded profile pictures and posts

⚙️ Other Essentials
db.php – MySQL connection

.htaccess – Optional: URL rewriting or error redirection

📌 Database Tables
users(username, email, password, display_name, profile_pic, created_at)

photos(id, user, photo_path, uploaded_at)

comments(id, photo_id, from_user, to_user, comment_text, created_at)

reactions(id, photo_id, user, emoji, reacted_at)

friend_requests(id, sender, receiver, status)

reports(id, comment_id, reporter, reported_at)

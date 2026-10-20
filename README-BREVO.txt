BREVO MAIL FIX (works on Railway Hobby - uses HTTPS, not SMTP)

1. Extract this zip into the ROOT of your Laravel project (next to artisan).
   It adds 1 file and replaces 3 files:
     app/Mail/BrevoTransport.php           (new)
     app/Providers/AppServiceProvider.php  (replaced)
     config/mail.php                       (replaced)
     config/services.php                   (replaced)
   No composer install is needed. Do NOT run "composer require resend/resend-php".

2. Commit and push:
     git add app config
     git commit -m "Add Brevo mail transport"
     git push

3. In Brevo (app.brevo.com):
   a) Create an account (free).
   b) Menu (top right) > SMTP & API > "API Keys" tab > Generate a new API key.
      Use an API key (starts with xkeysib-), NOT the SMTP key.
   c) Senders, Domains & Dedicated IPs > Senders > Add a sender.
      Enter your Gmail address and the 6-digit code Brevo emails you.

4. In Railway > Variables, set:
     MAIL_MAILER="brevo"
     BREVO_API_KEY="xkeysib-xxxxxxxx"
     MAIL_FROM_ADDRESS="<the sender address you verified in Brevo>"
     MAIL_FROM_NAME="Opusio"
   You can delete MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_SCHEME
   and RESEND_API_KEY.

5. Test "Forgot password". Errors are written to storage/logs/laravel.log.

Troubleshooting:
- 401 / "unrecognised IP address": Brevo > Security > Authorised IPs >
  deactivate the IP blocking (Railway IPs are not fixed).
- 400 "sender not valid": MAIL_FROM_ADDRESS is not a verified Brevo sender.
- Mail in spam: expected with a free Gmail sender, because Brevo replaces the
  sender address with its own. A custom domain fixes this later.

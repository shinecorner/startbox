# Confirming Email

### FILES
app/Events/NewUserSignedUp.php
app/Listeners/SendConfirmationEmail.php
app/Mail/ConfirmationEmail.php
app/Models/EmailConfirmation.php
app/Http/Requests/ConfirmEmailRequest.php
app/Http/Requests/ConfirmEmailResendRequest.php
database/migrations/..4_confirm_email_request.php
routes/api_guest.php
tests/continuous/controllers/ConfirmEmailControllerTest.php

### FLOW
**Webapp**
- A user signs up
- The web app holds at the confirm email step
- It can post a request for a new confirmation email to be sent
- It can ping to see if the user has confirmed their email (keep checking until confirmed)

**Backend**
- Event | NewUserSignedUp dispatched
- Listener | SendConfirmationEmail: Creates EmailConfirmation for user
- Email | Links to Webapp: https://webapp-base.com/confirm-email?email=joe.schmoe@gmail.com&token=82pu38234382
- WebApp (New Window) | Calls Backend - POST: api/confirm-email

# API

### Check Email If Confirmed
GET: api/check-email-confirmed
```
Params: {
  email: email,
}
Response: {
  "success": true,
  "data": {
    "email_confirmed": true
  },
  "message": ""
}
```

### Resend Confirmation Email
POST: api/resend-confirm-email
```
Params: {
  email: email,
}
Response: {
  "success": true,
  "data": [],
  "message": ""
}
ErrorResponse: {
  "success": false,
  "error": "Please wait at least 1 minute before requesting another email.",
  "error_code": "validation",
  "data": null
}
```

### Confirm Email From WebApp
POST: api/confirm-email
```
Params: {
  token: string,
  email: email,
}
Response: {
  "success": true,
  "data": [],
  "message": ""
}
ErrorResponse: {
  "success": false,
  "error": "The email address was already confirmed.",
  "error_code": "validation",
  "data": null
}
```


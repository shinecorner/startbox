# Resetting Password

### Web App

**1. Request a password reset / dispatches a reset email**

POST: /api/auth/password/email
```
Params: {
    email: 'jon@test.com',
}
```
```
Response: {
  "success": true,
  "data": [],
  "message": ""
}
```
<br>

**2. Email Is Sent Out & Redirects To Frontend App**

Mail: ResetPasswordEmail
URL: env('WEB_APP_URL') . '/user/reset?email=[EMAIL]&token=[TOKEN]
Example: https://app.dev/user/reset?email=joe@test.com&token=2342jp3ojafas...

<br>

**3. You can validate the token from the frontend App (for validation)**
GET: '/api/auth/password/validate-token'
```
Params: {
    email: jon@test.com,
    token: TOKEN,
}
Response: {
  "success": true,
  "data": [],
  "message": ""
}
```

**3. Submit New Password From Web App**

POST: /api/auth/password/validate-token
```
Params: {
    email: jon@test.com,
    token: TOKEN,
    password: NEWPASSWORD,
    password_confirmation: NEWPASSWORD,
}
```

```
Response: {
  "success": true,
  "data": [USER]
}
Header: {
  "cache-control": "no-cache, private",
  "date": "Fri, 27 Oct 2017 16:08:26 GMT",
  "content-type": "application\/json",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGci...."
}
```
<br>

# Signup | Checking Email

GET: /api/users/email-is-unique
```
Params: {
    email: 'jon@test.com',
}
```
```
Response: {
  "success": true,
  "data": [],
  "message": ""
}
```
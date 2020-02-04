## Guest API

### Checking An Email Is Unique
GET: /api/auth/email-is-valid
```
Params: {
  email: joe@testing.com,
}
Response: {
  "success": true,
  "data": [],
  "message": ""
}
```

### Checking A Username Is Unique
GET: /api/auth/username-is-unique'
```
Params: {
  username: Spaghetti,
}
Response: {
  "success": true,
  "data": [],
  "message": ""
}
```

### Getting Current User
GET: /api/user
```
Params: null
Response: {
  "success": true,
  "data": {
    "first_name": "Dixie",
    "last_name": "Rice",
    "email": "shields.amelia@example.com",
    "username": "qsimonis",
    "instagram_id": null,
    "bio": null,
    "link": null,
    "picture": null,
    "token": "KHMSly6jD89JlxIgCEx6XXlSBNELiB",
    "followers_count": 0,
    "followings_count": 0,
    "posts_count": 0,
    "likes_count": 0
  },
  "message": ""
}
```

### Register w/ Email
POST: /api/auth/register
```
Params: {
  first_name: String,
  last_name: String,
  email: String, Email (unique),
  username: String (unique),
  password: String (min:6)
}
```

```
Response: {
  "success": true,
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6ImE5TWFvNmFuYkxMNm...",
    "user": {
      "first_name": "Annalise",
      "last_name": "Kertzmann",
      "email": "ngaylord@example.org",
      "username": "oberbrunner.erica@example.net",
      "bio": null,
      "link": null,
      "picture": null,
      "token": "TpHrvRntZ4gPjdb5tgZLtpgo6vSbtEI5ecIFJ2NAa7Nn5n0BWv6ftmo3lTdtl3AB",
      "connected_with_instagram": false,
      "followers_count": 0,
      "followings_count": 0,
      "posts_count": 0
    }
  },
  "message": ""
}
```

### Logging In
POST: /api/auth/login
```
```
Params: {
  email: haley.rose@example.com,
  password: something
}
Response: {
  "success": true,
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6Im1TcHppMWNiRHFLbGNsT2sifQ...",
    "user": {
      "first_name": "Alexandre",
      "last_name": "Stoltenberg",
      "email": "israel.renner@example.net",
      "username": "lehner.norberto",
      "instagram": false,
      "bio": null,
      "link": null,
      "picture": null,
      "token": "oH8yHKpYiJ28Zb7kJEGdcszmcte41z",
      "followers_count": 0,
      "followings_count": 0,
      "posts_count": 0,
      "likes_count": 0
    }
  },
  "message": "Logged in"
}
```

### Refreshing Token
POST: api/auth/refresh
```
Headers: ['Authorization' => "Bearer YOURTOKEN"]
Params: null,
Response: {
  "success": true,
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IlhhbGlJdjZTcE93Z2pHdEwifQ..."
  },
  "message": "Refreshed token"
}
```

### Logging Out
POST: api/auth/logout
```
Params: null,
Response: {
  "success": true,
  "data": [],
  "message": "Logged out"
}
```
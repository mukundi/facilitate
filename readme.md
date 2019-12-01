
## Simple project to send an alert to learners who are lagging behind in a module

## API Spec
The preferred JSON object to be returned by the API should be structured as follows:

### User registration (for authentication)
`POST /register`

```source-json
{
  "user": {
    "email": "jane@jane.com",
    "name": "Jane Doe",
    "password": "*******",
  }
}

```

### Authentication
`POST /api/users/login`

```
{
  "user": {
    "email": "jane@jane.com",
    "password": "*******",
  }
}

```

## Get progress  per module
`GET api/v1/modules/:module/progress`

```
[
{
"id":1,
"progress":40,
"email":"jane.doe@doe.com",
"name":"Intro to Computer Science"
},
{
"id":2,
"progress":50,
"email":"john.doe@doe.com",
"name":"Intro to Computer Science"
}
]
```

## Get lagging students in a module
`GET api/v1/modules/:module/lagging`
```
[
{
"id":1,
"progress":40,
"email":"jane.doe@doe.com",
"name":"Intro to Computer Science"
}
```

## Contact lagging students in a module
`GET api/v1/modules/:module/contact-lagging`
```
[
{
"status":successful,
"message":"Email sent successfully"
}
```

# Contact lagging students in all live modules
`GET api/v1/modules/contact-all-lagging`
```
[
{
"status":successful,
"message":"Email sent successfully"
}
```

NOTE: Future iterations should consider queing the mails depending on the number

## Automating
Automation can be achieved by setting up chron jobs to check for new students who are lagging behing. To set up a cron job, add the script below to your server

```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

A one-liner phrase describing this project or app

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/a002ef4aa50a4d029334e8fac94686c7)](https://app.codacy.com/gh/BuildForSDG/Team-153-Product?utm_source=github.com&utm_medium=referral&utm_content=BuildForSDG/Team-153-Product&utm_campaign=Badge_Grade_Settings)
[![Codacy Badge](https://img.shields.io/badge/Code%20Quality-D-red)](https://img.shields.io/badge/Code%20Quality-D-red)

## Api Documentation

To use this api on your local machine,

1.  Rename the `.env.example` to `.env`.
2.  In this file, replace the `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` values with your database name on your local machine, the database username and password.
3.  On your command prompt run `php artisan migrate --seed` to migrate the database tables and seed the reports table with demo data. (ensure you php local server is running).
4.  To create a default admin user run `php artisan make:admin`.
5.  To see the reports made by users visit the endpoint `/api/v1/reports`.

## Endpoints

| Http Verb 	| Path                  	| Controller#action 	| Used for                                             	|
|-----------	|-----------------------	|-------------------	|------------------------------------------------------	|
| GET       	| `/api/v1/reports`       	| reports#list      	| Displays a listing of all reports                    	|
| POST      	| `/api/v1/auth/login`    	| auth#login        	| Authenticates a user                                 	|
| POST      	| `/api/v1/auth/logout`   	| auth#logout       	| Logs out a user out  of the application              	|
| GET       	| `/api/v1/guest/reports` 	| guest#reports     	| Displays a listing of all  reports to the guest users |
| POST       	| `/api/v1/users`           | users#store     	    | Create a new admin user 	                            |

### Base Uri

The api's base uri is `/api/v1/`.

### List

To get a list of all items of a resource (e.g reports), make a GET request to the endpoint `/api/v1/reports/`.  

#### Response  

You should receive a json response with status `200`, a `data` key containing an array of reports and `meta` key containing pagination details.

#### Sample Response

```json
{
  "meta": {
    "current_page": 1,
    "first_page_url": "http://localhost:7070/api/v1/reports?page=1",
    "from": 1,
    "next_page_url": null,
    "path": "http://localhost:7070/api/v1/reports",
    "per_page": 15,
    "prev_page_url": null,
    "to": 10
  },
  "data": [
    {
      "id": 10,
      "title": "Yessenia Manor Accident",
      "note": "The Caterpillar and Alice was more hopeless than ever: she sat down and cried. 'Come, there's half.",
      "status": "pending",
      "location": "19688 Roselyn Radial",
      "visual_image": "https://lorempixel.com/300/300/city/?38172",
      "time_of_report": "2020-05-08T21:22:14.000000Z",
      "status_updated_at": "2020-05-08T21:22:14.000000Z"
    }
   ]
 }
```

### Create

To create a resource, make a POST request to the the endpoint `api/v1/reports`.  
**Response**  
`@TODO`  
**Sample Response**  
`@TODO`

### Read

To read a single resource, make a GET request to the the endpoint `api/v1/reports/{id}`.  
**Response**  
`@TODO`  
**Sample Response**  
`@TODO`

### Update

To update a resource, make a PATCH request to the the endpoint `api/v1/reports/{id}`.  
**Response**  
`@TODO`  
**Sample Response**  
`@TODO`

### Delete

To delete a resource, make a DELETE request to the the endpoint `api/v1/reports/{id}`.  
**Response**  
`@TODO`  
**Sample Response**  
`@TODO`

## Authentication & Authorization

All requests to `/api/v1/reports` requires authorization. You'll need to add an `Authorization: Bearer your_api_token` header to your request else you receive a `401` error code.

### Login

To receive your api token, make a **POST** request to `/api/v1/auth/login` with your registered email and password.

#### Example

```javascript
axios.post('/api/v1/auth/login`, {
    data: {
        email: 'admin@example.com',
        password: password
    }
}).then(res=>{
    let token = res.data.data.api_token;
    // store your api token
});
```

**Expect the following response:**

```json
{
    "message": "login successful",
    "data": {
        "api_token": "MTU5YmdPUGZQNVVNa1hYS1pxSExMVHY5SW1PZnRiNlI2bU55Tk1nVw=="
    }
}
```

**Making subsequent requests:**

```javascript
axios.post('/api/v1/reports`, {
    headers: {
        Authorization: 'Bearer MTU5YmdPUGZQNVVNa1hYS1pxSExMVHY5SW1PZnRiNlI2bU55Tk1nVw=='
    }
}).then(res=>{
    //
});
```

#### Authentication error

Sending invalid credentials when logging in responds with a `422` http error code.

##### Example Responses

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "invalid email or password"
        ]
    }
}
```

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password field is required."
        ]
    }
}
```

#### Access the details of the current logged in user

Make a GET request to `/api/v1/me`

**Sample response**

```json
{
    "data": {
        "id": 1,
        "name": null,
        "email": "admin@example.com",
        "admin_role": "superadmin",
        "created_at": "2020-05-09T01:08:00.000000Z",
        "updated_at": "2020-05-20T13:26:30.000000Z"
    }
}
```

### Logout

To logout, make a post request to `/api/v1/auth/logout` with your api token in Authorization header.

**Sample response**

```json
{
    "message": "logout successful"
}
```

## TESTING

1.  `composer test` to run phpunit tests.
2.  `composer test-f` to run filtered phpunit tests.
3.  `composer php-cs-fixer` for linting.

## About

What is this project about. Ok to enrich here or the section above it with an image. 

Once this repo has been setup on Codacy by the TTL, replace the above badge with the actual one from the Codacy dashboard, and add the code coverage badge as well. This is mandatory

This is a simple php starter repo template for setting up your project. The setup contains

-   Composer: For adding third party dependencies

-   phpunit: For runnung tests

-   php-cs-fixer: For formatting code to match php coding standard

## Why

Talk about what problem this solves, what SDG(s) and SGD targets it addresses and why these are imoirtant

## Usage

How would someone use what you have built, include URLs to the deployed app, service e.t.c when you have it setup

## Setup

Run `composer install` and `composer dump-autoload` to get started.

`index.php` is the entry to the project and source code should go into the `src` folder.

All tests should be written in the test folder.

### Hints

-   Test: `composer run test`
-   Install dependencies: `composer install <dep name>`
-   Lint: `composer run php-cs-fixer`

## Authors

1.  Brian Tum - <https://github.com/BrianTum>
2.  Fred Nyakagwa -
3.  John Mnyika - <https://github.com/JohnMnyika>
4.  Daniel Kimani - <https://github.com/suhade>
5.  Basele Stephen - TTL - <https://github.com/Basele>
6.  Timothy Onyiuke - Mentor - <https://github.com/timolinn>

## Contributing

If this project sounds interesting to you and you'd like to contribute, thank you!
First, you can send a mail to buildforsdg@andela.com to indicate your interest, why you'd like to support and what forms of support you can bring to the table, but here are areas we think we'd need the most help in this project :

1.  area one (e.g this app is about human trafficking and you need feedback on your roadmap and feature list from the private sector / NGOs)
2.  area two (e.g you want people to opt-in and try using your staging app at staging.project-name.com and report any bugs via a form)
3.  area three (e.g here is the zoom link to our end-of sprint webinar, join and provide feedback as a stakeholder if you can)

## Acknowledgements

Did you use someone else’s code?
Do you want to thank someone explicitly?
Did someone’s blog post spark off a wonderful idea or give you a solution to nagging problem?

It's powerful to always give credit.

## LICENSE

MIT


## run
php -S localhost:8080 -t public/
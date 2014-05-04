# Group Funds
Funds related resources of the **Operation Apple API**

## Funds Collection [/funds]
### List all Funds [GET]
+ Response 200 (application/json)

        [
           {
              "id":1,
              "name":"Tech Fund IV",
              "companies":[
                 {
                    "id":100,
                    "name":"Google"
                 },
                 {
                    "id":101,
                    "name":"Apple, Inc."
                 },
                 {
                    "id":102,
                    "name":"Microsoft"
                 }
              ]
           },
           {
              "id":2,
              "name":"Alternative Energy Fund",
              "companies":[
                 {
                    "id":210,
                    "name":"Phoenix Solar AG"
                 },
                 {
                    "id":221,
                    "name":"Renewable Energy Inc."
                 }
              ]
           }
        ]

### Create a Fund [POST]
+ Request (application/json)

        { "name": "VPC Capital Growth Fund" }

+ Response 201 (application/json)

        { "id": 3, "name": "VPC Capital Growth Fund", "companies":[] }

## Fund [/funds/{id}]
A single Fund object with all its details

+ Parameters
    + id (required, number, `2`) ... Numeric `id` of the Fund.

### Retrieve a single Fund [GET]
+ Response 200 (application/json)

    + Header

            X-My-Header: The Value

    + Body

            { "id": 2, "name": "Alternative Energy Fund" }

### Update Fund [PUT]
+ Request (application/json)

        { "name": "Renewable Energy Fund" }

+ Response 200 (application/json)

    + Header

            X-My-Header: The Value

    + Body

            {
              "id":2,
              "name":"Renewable Energy Fund",
              "companies":[
                 {
                    "id":210,
                    "name":"Phoenix Solar AG"
                 },
                 {
                    "id":221,
                    "name":"Renewable Energy Inc."
                 }
              ]
            }

### Remove a Fund [DELETE]
+ Response 204

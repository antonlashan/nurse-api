---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://api.icm.lk/docs/collection.json)

<!-- END_INFO -->

#Admin
<!-- START_0ec26795c9024df15412a7168f2860e7 -->
## User list.

> Example request:

```bash
curl -X GET -G "/v1/admin/users" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/users");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 20,
            "total": 5
        },
        "list": [
            {
                "user_detail_first_name": "Admin",
                "user_detail_last_name": "",
                "user_detail_nic": "",
                "user_detail_gender": "male",
                "id": 1,
                "email": "admin@nurse.com",
                "mobile_no": "1234567890",
                "role": "admin",
                "created_at": "2019-07-10 13:14:12",
                "updated_at": "2019-07-18 09:46:08"
            },
            {
                "user_detail_first_name": "Sean",
                "user_detail_last_name": "Marshall",
                "user_detail_nic": "",
                "user_detail_gender": "male",
                "id": 2,
                "email": "client@nurse.com",
                "mobile_no": "1234567891",
                "role": "client",
                "created_at": "2019-07-10 13:14:12",
                "updated_at": "2019-07-16 11:41:48"
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/admin/users`


<!-- END_0ec26795c9024df15412a7168f2860e7 -->

<!-- START_dc4fcf514c4df98c66515b9d1f7f47f1 -->
## User get profile.

> Example request:

```bash
curl -X GET -G "/v1/admin/users/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/users/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "first_name": "Lashan",
        "last_name": "Fernando",
        "nic": "198516003220",
        "gender": "male",
        "dob": "1985-06-08",
        "birth_district_id": 2,
        "highest_edu_qualification": "Bsc",
        "current_work_place": "Negombo",
        "registration_no": "123356778",
        "created_at": "2019-07-02 09:37:20",
        "updated_at": "2019-07-02 11:32:54",
        "user_qualifications": {
            "a_level": [
                {
                    "id": 28,
                    "name": "Maths",
                    "grade": "A",
                    "type": "a_level"
                },
                {
                    "id": 29,
                    "name": "Physics",
                    "grade": "B",
                    "type": "a_level"
                },
                {
                    "id": 30,
                    "name": "Chemistry",
                    "grade": "C",
                    "type": "a_level"
                }
            ],
            "o_level": [
                {
                    "id": 31,
                    "name": "Sinhala",
                    "grade": "A",
                    "type": "o_level"
                },
                {
                    "id": 32,
                    "name": "Maths",
                    "grade": "A",
                    "type": "o_level"
                },
                {
                    "id": 33,
                    "name": "Science",
                    "grade": "B",
                    "type": "o_level"
                },
                {
                    "id": 34,
                    "name": "English",
                    "grade": "C",
                    "type": "o_level"
                }
            ],
            "professional": [
                {
                    "id": 35,
                    "name": "SCJP",
                    "grade": "pass",
                    "type": "professional"
                },
                {
                    "id": 36,
                    "name": "IELTS",
                    "grade": "pass",
                    "type": "professional"
                }
            ],
            "vtc": [
                {
                    "id": 37,
                    "name": "VTC exam 1",
                    "grade": "pass",
                    "type": "vtc"
                },
                {
                    "id": 38,
                    "name": "VTC exam 2",
                    "grade": "pass",
                    "type": "vtc"
                }
            ]
        }
    }
}
```

### HTTP Request
`GET /v1/admin/users/{id}`


<!-- END_dc4fcf514c4df98c66515b9d1f7f47f1 -->

<!-- START_2248abc9f8f5bb1f23dea3d82883b799 -->
## User delete.

> Example request:

```bash
curl -X DELETE "/v1/admin/users/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/users/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/admin/users/{id}`


<!-- END_2248abc9f8f5bb1f23dea3d82883b799 -->

<!-- START_a3f30efc3a2cdda0fcddae64e8ed4e19 -->
## User change password.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/admin/users/update-pwd" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"password_current":"ullam","password":"eum","password_confirmation":"commodi"}'

```
```javascript
const url = new URL("/v1/admin/users/update-pwd");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "password_current": "ullam",
    "password": "eum",
    "password_confirmation": "commodi"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Password updated successfully.",
    "data": null
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Current password not matched.",
    "data": null
}
```

### HTTP Request
`PUT /v1/admin/users/update-pwd`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    password_current | string |  required  | Current password.
    password | string |  required  | New password.
    password_confirmation | string |  required  | Confirmation password.

<!-- END_a3f30efc3a2cdda0fcddae64e8ed4e19 -->

<!-- START_cf1945fb27a8730750dec8e607ec0709 -->
## Company list.

> Example request:

```bash
curl -X GET -G "/v1/admin/companies" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/companies");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": [
        {
            "id": 1,
            "name": "company 1",
            "logo": "http:\/\/api.icm.lk\/images\/company\/1561291227.jpg",
            "banner": "http:\/\/api.icm.lk\/images\/company\/2561291227.jpg",
            "address": "addresss",
            "email": "sample@gmail.com",
            "phone": "23434343",
            "created_at": "2019-06-23 12:00:27",
            "updated_at": "2019-06-23 12:00:27"
        },
        {
            "id": 2,
            "name": "Lit solutions",
            "logo": "http:\/\/api.icm.lk\/images\/company\/1561291480.jpg",
            "banner": "http:\/\/api.icm.lk\/images\/company\/2561291480.jpg",
            "address": "Cecilia Chapman\n711-2880 Nulla St.",
            "email": "sample@gmail.com",
            "phone": "(257) 563-7401",
            "created_at": "2019-06-23 12:04:40",
            "updated_at": "2019-06-23 12:04:40"
        }
    ]
}
```

### HTTP Request
`GET /v1/admin/companies`


<!-- END_cf1945fb27a8730750dec8e607ec0709 -->

<!-- START_655e2db0c3c3cab6f22e59fd27489afd -->
## Company get record.

> Example request:

```bash
curl -X GET -G "/v1/admin/companies/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/companies/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 2,
        "name": "roserbery",
        "logo": "http:\/\/api.icm.lk\/images\/company\/1561359160.jpg",
        "banner": "http:\/\/api.icm.lk\/images\/company\/2561359160.jpg",
        "address": "21, Rosersbergsvägen 34",
        "phone": "+46761001562",
        "email": "antonlashan@gmail.com",
        "created_at": "2019-06-24 06:52:40",
        "updated_at": "2019-06-24 06:52:40"
    }
}
```

### HTTP Request
`GET /v1/admin/companies/{id}`


<!-- END_655e2db0c3c3cab6f22e59fd27489afd -->

<!-- START_d38a13ed23d2811f2bddfbcefa81f772 -->
## Company create.

> Example request:

```bash
curl -X POST "/v1/admin/companies" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"name":"quos","address":"earum","phone":"ab","logo":"sunt","banner":"in","email":"modi"}'

```
```javascript
const url = new URL("/v1/admin/companies");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "quos",
    "address": "earum",
    "phone": "ab",
    "logo": "sunt",
    "banner": "in",
    "email": "modi"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Created successfully!",
    "data": {
        "name": "Lit solutions",
        "address": "Cecilia Chapman\n711-2880 Nulla St.",
        "phone": "(257) 563-7401",
        "email": "sample@gmail.com",
        "logo": "http:\/\/api.icm.lk\/images\/company\/1561291480.jpg",
        "banner": "http:\/\/api.icm.lk\/images\/company\/3361291480.jpg",
        "updated_at": "2019-06-23 12:04:40",
        "created_at": "2019-06-23 12:04:40",
        "id": 2
    }
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Validation error",
    "data": {
        "image": [
            "The image field is required."
        ]
    }
}
```

### HTTP Request
`POST /v1/admin/companies`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Name.
    address | string |  required  | Address.
    phone | string |  required  | Phone.
    logo | file |  required  | Image.
    banner | file |  required  | Image.
    email | string |  required  | Image.

<!-- END_d38a13ed23d2811f2bddfbcefa81f772 -->

<!-- START_b2251241d254eb4792eb049943a48e45 -->
## Company update.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/admin/companies/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"name":"molestiae","address":"ea","phone":"qui","logo":"impedit","banner":"suscipit","email":"enim"}'

```
```javascript
const url = new URL("/v1/admin/companies/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "molestiae",
    "address": "ea",
    "phone": "qui",
    "logo": "impedit",
    "banner": "suscipit",
    "email": "enim"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Updated successfully!",
    "data": null
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Validation error",
    "data": {
        "phone": [
            "The phone field is required."
        ]
    }
}
```

### HTTP Request
`PUT /v1/admin/companies/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Name.
    address | string |  required  | Address.
    phone | string |  required  | Phone.
    logo | file |  optional  | optional Image.
    banner | file |  optional  | optional Image.
    email | string |  required  | Image.

<!-- END_b2251241d254eb4792eb049943a48e45 -->

<!-- START_82b1a7c76dcb14b061380dc9dc5117fa -->
## Company delete.

> Example request:

```bash
curl -X DELETE "/v1/admin/companies/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/companies/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/admin/companies/{id}`


<!-- END_82b1a7c76dcb14b061380dc9dc5117fa -->

<!-- START_f9de553952a5e1e2323db26adf2910a5 -->
## CompanyPost list.

> Example request:

```bash
curl -X GET -G "/v1/admin/company-posts" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/company-posts");

    let params = {
            "page": "explicabo",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 20,
            "total": 2
        },
        "list": [
            {
                "company_name": "Asiri Hospital Holdings Pvt Ltd",
                "company_address": "Colombo 5",
                "id": 1,
                "company_id": 1,
                "position": "Nurse (Female\/Male) - Colombo 5",
                "description": "description",
                "created_at": "2019-07-10 13:14:12",
                "updated_at": "2019-07-10 13:14:12"
            },
            {
                "company_name": "Wellfort Management Pvt Ltd",
                "company_address": "Colombo",
                "id": 2,
                "company_id": 2,
                "position": "Female Executive - Nugegoda",
                "description": "Executive - Operations",
                "created_at": "2019-07-10 13:14:12",
                "updated_at": "2019-07-10 13:14:12"
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/admin/company-posts`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    page |  optional  | Page id.

<!-- END_f9de553952a5e1e2323db26adf2910a5 -->

<!-- START_62e8a21a22010925572c8b13d0701d17 -->
## CompanyPost get record.

> Example request:

```bash
curl -X GET -G "/v1/admin/company-posts/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/company-posts/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "company_id": "1",
        "position": "test",
        "description": "test",
        "updated_at": "2019-06-24 07:19:23",
        "created_at": "2019-06-24 07:19:23"
    }
}
```

### HTTP Request
`GET /v1/admin/company-posts/{id}`


<!-- END_62e8a21a22010925572c8b13d0701d17 -->

<!-- START_88399c26866f09f75611240f61e8bc84 -->
## CompanyPost create.

> Example request:

```bash
curl -X POST "/v1/admin/company-posts" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"company_id":3,"position":"incidunt","description":"ut"}'

```
```javascript
const url = new URL("/v1/admin/company-posts");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "company_id": 3,
    "position": "incidunt",
    "description": "ut"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Created successfully!",
    "data": {
        "company_id": "1",
        "position": "test",
        "description": "test",
        "updated_at": "2019-06-24 07:19:23",
        "created_at": "2019-06-24 07:19:23"
    }
}
```

### HTTP Request
`POST /v1/admin/company-posts`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    company_id | integer |  required  | Company ID.
    position | string |  required  | Position label.
    description | text |  required  | Description.

<!-- END_88399c26866f09f75611240f61e8bc84 -->

<!-- START_862ef0a0f702739be215a4615b13d465 -->
## CompanyPost update.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/admin/company-posts/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"company_id":14,"position":"aut","description":"quis"}'

```
```javascript
const url = new URL("/v1/admin/company-posts/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "company_id": 14,
    "position": "aut",
    "description": "quis"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Updated successfully!",
    "data": null
}
```

### HTTP Request
`PUT /v1/admin/company-posts/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    company_id | integer |  required  | Company ID.
    position | string |  required  | Position label.
    description | text |  required  | Description.

<!-- END_862ef0a0f702739be215a4615b13d465 -->

<!-- START_22b453d14ff90a3f1ead2a52c93c8553 -->
## CompanyPost delete.

> Example request:

```bash
curl -X DELETE "/v1/admin/company-posts/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/company-posts/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/admin/company-posts/{id}`


<!-- END_22b453d14ff90a3f1ead2a52c93c8553 -->

<!-- START_fd0e108518c7cb476608d19e525aadae -->
## CompanyPostApplicantController list.

> Example request:

```bash
curl -X GET -G "/v1/admin/company-posts/1/applicants" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/company-posts/1/applicants");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": [
        {
            "id": 3,
            "user_id": 3,
            "status": "reject",
            "first_name": "John",
            "last_name": "Edmunds",
            "email": "john.edmunds@nurse.com",
            "mobile_no": "+94775186152",
            "status_lbl": "Rejected"
        },
        {
            "id": 5,
            "user_id": 5,
            "status": "reject",
            "first_name": "Rebecca",
            "last_name": "Hunter",
            "email": "rebecca.hunter@nurse.com",
            "mobile_no": "+94775186150",
            "status_lbl": "Rejected"
        }
    ]
}
```

### HTTP Request
`GET /v1/admin/company-posts/{id}/applicants`


<!-- END_fd0e108518c7cb476608d19e525aadae -->

<!-- START_00b2e065cbadb932ec70d37f5e9e6ddb -->
## CompanyPostApplicantController send message.

> Example request:

```bash
curl -X POST "/v1/admin/company-posts/1/applicants/send-msg" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/company-posts/1/applicants/send-msg");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /v1/admin/company-posts/{id}/applicants/send-msg`


<!-- END_00b2e065cbadb932ec70d37f5e9e6ddb -->

<!-- START_d625c97e0b6fe7815eb8ecd4ecf862e9 -->
## Advertisement list.

> Example request:

```bash
curl -X GET -G "/v1/admin/advertisements" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/advertisements");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": [
        {
            "id": 1,
            "name": "company 1",
            "image": "http:\/\/api.icm.lk\/images\/advertisement\/1561291227.jpg",
            "created_at": "2019-06-23 12:00:27",
            "updated_at": "2019-06-23 12:00:27"
        },
        {
            "id": 2,
            "name": "Lit solutions",
            "image": "http:\/\/api.icm.lk\/images\/advertisement\/1561291480.jpg",
            "created_at": "2019-06-23 12:04:40",
            "updated_at": "2019-06-23 12:04:40"
        }
    ]
}
```

### HTTP Request
`GET /v1/admin/advertisements`


<!-- END_d625c97e0b6fe7815eb8ecd4ecf862e9 -->

<!-- START_c3a177567ab43cdb440e904c320e5f29 -->
## Advertisement get record.

> Example request:

```bash
curl -X GET -G "/v1/admin/advertisements/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/advertisements/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 2,
        "name": "roserbery",
        "image": "http:\/\/api.icm.lk\/images\/advertisement\/1561291480.jpg",
        "created_at": "2019-06-24 06:52:40",
        "updated_at": "2019-06-24 06:52:40"
    }
}
```

### HTTP Request
`GET /v1/admin/advertisements/{id}`


<!-- END_c3a177567ab43cdb440e904c320e5f29 -->

<!-- START_8f88fe4b6731e6a7984aba23112efb16 -->
## Advertisement create.

> Example request:

```bash
curl -X POST "/v1/admin/advertisements" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"name":"voluptatibus","image":"eum"}'

```
```javascript
const url = new URL("/v1/admin/advertisements");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "voluptatibus",
    "image": "eum"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Created successfully!",
    "data": {
        "name": "Lit solutions",
        "image": "http:\/\/api.icm.lk\/images\/advertisement\/1561291480.jpg",
        "updated_at": "2019-06-23 12:04:40",
        "created_at": "2019-06-23 12:04:40",
        "id": 2
    }
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Validation error",
    "data": {
        "image": [
            "The image field is required."
        ]
    }
}
```

### HTTP Request
`POST /v1/admin/advertisements`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | optional Name.
    image | file |  required  | Image.

<!-- END_8f88fe4b6731e6a7984aba23112efb16 -->

<!-- START_84ebfb508feed88ed5c9ba1db544e904 -->
## Advertisement update.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/admin/advertisements/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"name":"sint","image":"in"}'

```
```javascript
const url = new URL("/v1/admin/advertisements/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "sint",
    "image": "in"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Updated successfully!",
    "data": null
}
```

### HTTP Request
`PUT /v1/admin/advertisements/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | optional Name.
    image | file |  optional  | optional Image.

<!-- END_84ebfb508feed88ed5c9ba1db544e904 -->

<!-- START_1d1219e789ca6d7c5a809c391fb070ed -->
## Advertisement delete.

> Example request:

```bash
curl -X DELETE "/v1/admin/advertisements/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/advertisements/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/admin/advertisements/{id}`


<!-- END_1d1219e789ca6d7c5a809c391fb070ed -->

<!-- START_9abf8cc4e04509725496ac19db87da43 -->
## CompanyPostBookmark list.

> Example request:

```bash
curl -X GET -G "/v1/admin/company-post-bookmarks" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/company-post-bookmarks");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 20,
            "total": 2
        },
        "list": [
            {
                "id": 1,
                "user_id": 2,
                "first_name": "Sean",
                "last_name": "Marshall",
                "position": "Nurse (Female\/Male) - Colombo 5",
                "company_name": "Asiri Hospital Holdings Pvt Ltd"
            },
            {
                "id": 2,
                "user_id": 2,
                "first_name": "Sean",
                "last_name": "Marshall",
                "position": "Female Executive - Nugegoda",
                "company_name": "Wellfort Management Pvt Ltd"
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/admin/company-post-bookmarks`


<!-- END_9abf8cc4e04509725496ac19db87da43 -->

<!-- START_589b458abad0cc8dfed692e8e5ba8b22 -->
## CompanyPostApplication list.

> Example request:

```bash
curl -X GET -G "/v1/admin/company-post-applications" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/company-post-applications");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 20,
            "total": 5
        },
        "list": [
            {
                "id": 1,
                "user_id": 2,
                "status": "pending",
                "first_name": "Sean",
                "last_name": "Marshall",
                "position": "Nurse (Female\/Male) - Colombo 5",
                "company_name": "Asiri Hospital Holdings Pvt Ltd"
            },
            {
                "id": 2,
                "user_id": 3,
                "status": "pending",
                "first_name": "John",
                "last_name": "Edmunds",
                "position": "Female Executive - Nugegoda",
                "company_name": "Wellfort Management Pvt Ltd"
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/admin/company-post-applications`


<!-- END_589b458abad0cc8dfed692e8e5ba8b22 -->

<!-- START_47bbd694517925e152280a81e35fdd84 -->
## CompanyPostApplication update.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/admin/company-post-applications/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"status":"corrupti"}'

```
```javascript
const url = new URL("/v1/admin/company-post-applications/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "status": "corrupti"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successfully updated.",
    "data": null
}
```

### HTTP Request
`PUT /v1/admin/company-post-applications/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    status | string |  required  | 'pending' or 'accept' or 'reject'.

<!-- END_47bbd694517925e152280a81e35fdd84 -->

<!-- START_a8364f84d782a7a6659b0bf7bdaefd50 -->
## News list.

> Example request:

```bash
curl -X GET -G "/v1/admin/news" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/news");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 10,
            "total": 2
        },
        "list": [
            {
                "id": 1,
                "title": "Hemasiri, Pujith further remanded",
                "desc_1": "<p>Former Defence Secretary Hemasiri Fernando and IGP Pujith Jayasundara, who were arrested by the CID at the Colombo National Hospital yesterday, were further remanded until July 9 by Colombo Chief Magistrate Lanka Jayaratne.<\/p>",
                "desc_2": "<p>Former Defence Secretary Hemasiri Fernando and IGP Pujith Jayasundara, who were arrested by the CID at the Colombo National Hospital yesterday, were further remanded until July 9 by Colombo Chief Magistrate Lanka Jayaratne. (Shehan Chamika Silva)<\/p>",
                "image": "http:\/\/api.icm.lk\/images\/news\/333333.jpg",
                "is_featured": false,
                "created_at": "2019-07-03 13:32:33",
                "updated_at": "2019-07-03 13:59:37"
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/admin/news`


<!-- END_a8364f84d782a7a6659b0bf7bdaefd50 -->

<!-- START_f160533450ff28329b55e21353474519 -->
## News get record.

> Example request:

```bash
curl -X GET -G "/v1/admin/news/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/news/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful!",
    "data": {
        "title": "Leaving for UN missions",
        "desc_1": "<p>A new contingent of 61 Army personnel including 11officers under the phase six of the UN Mission of South Sudan (UNMISS),&nbsp;<\/p>",
        "desc_2": "<p>left this morning for South Sudan to serve in the SRIMED Level 2 Hospital in Bor, South Sudan.<strong> Pix by Army Media<\/strong><\/p>",
        "is_featured": false,
        "image": "http:\/\/api.icm.lk\/images\/news\/15621633705d1cb8aaa831d.jpg",
        "updated_at": "2019-07-03 14:16:10",
        "created_at": "2019-07-03 14:16:10",
        "id": 3
    }
}
```

### HTTP Request
`GET /v1/admin/news/{id}`


<!-- END_f160533450ff28329b55e21353474519 -->

<!-- START_194f4b645aa8bedae57b2d52055b118e -->
## News create.

> Example request:

```bash
curl -X POST "/v1/admin/news" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"image":"tenetur","title":"dignissimos","desc_1":"aut","desc_2":"officia","banner":"sunt","is_featured":true}'

```
```javascript
const url = new URL("/v1/admin/news");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "image": "tenetur",
    "title": "dignissimos",
    "desc_1": "aut",
    "desc_2": "officia",
    "banner": "sunt",
    "is_featured": true
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Created successfully!",
    "data": {
        "title": "Leaving for UN missions",
        "desc_1": "<p>A new contingent of 61 Army personnel including 11officers under the phase six of the UN Mission of South Sudan (UNMISS),&nbsp;<\/p>",
        "desc_2": "<p>left this morning for South Sudan to serve in the SRIMED Level 2 Hospital in Bor, South Sudan.<strong> Pix by Army Media<\/strong><\/p>",
        "is_featured": false,
        "image": "http:\/\/api.icm.lk\/images\/news\/15621633705d1cb8aaa831d.jpg",
        "updated_at": "2019-07-03 14:16:10",
        "created_at": "2019-07-03 14:16:10",
        "id": 3
    }
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Validation error",
    "data": {
        "image": [
            "The image field is required."
        ]
    }
}
```

### HTTP Request
`POST /v1/admin/news`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    image | file |  required  | Image.
    title | string |  required  | Title.
    desc_1 | string |  required  | Description 1.
    desc_2 | string |  optional  | Description 2.
    banner | file |  required  | Image.
    is_featured | boolean |  required  | Featured.

<!-- END_194f4b645aa8bedae57b2d52055b118e -->

<!-- START_e7bc894f4be6d316384ccd9909cde859 -->
## News update.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/admin/news/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"image":"rerum","title":"qui","desc_1":"voluptas","desc_2":"ut","banner":"molestiae","is_featured":true}'

```
```javascript
const url = new URL("/v1/admin/news/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "image": "rerum",
    "title": "qui",
    "desc_1": "voluptas",
    "desc_2": "ut",
    "banner": "molestiae",
    "is_featured": true
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Updated successfully!",
    "data": true
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Validation error",
    "data": {
        "phone": [
            "The phone field is required."
        ]
    }
}
```

### HTTP Request
`PUT /v1/admin/news/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    image | file |  optional  | optional Image.
    title | string |  required  | Title.
    desc_1 | string |  required  | Description 1.
    desc_2 | string |  optional  | Description 2.
    banner | file |  required  | Image.
    is_featured | boolean |  required  | Featured.

<!-- END_e7bc894f4be6d316384ccd9909cde859 -->

<!-- START_f4352f87baea16a69f22679c2c5f68e8 -->
## News delete.

> Example request:

```bash
curl -X DELETE "/v1/admin/news/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/news/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/admin/news/{id}`


<!-- END_f4352f87baea16a69f22679c2c5f68e8 -->

<!-- START_9e3411f722871fce5aaceea7fb3edfb8 -->
## PostCategory list.

> Example request:

```bash
curl -X GET -G "/v1/admin/post-categories" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/post-categories");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": [
        {
            "id": 1,
            "name": "Cat 3",
            "created_at": "2019-07-04 13:40:19",
            "updated_at": "2019-07-04 13:43:56"
        },
        {
            "id": 2,
            "name": "Cate 2",
            "created_at": "2019-07-04 13:47:33",
            "updated_at": "2019-07-04 13:47:33"
        }
    ]
}
```

### HTTP Request
`GET /v1/admin/post-categories`


<!-- END_9e3411f722871fce5aaceea7fb3edfb8 -->

<!-- START_bf94e6d0a70a32dcc6a1002361c589b6 -->
## PostCategory get record.

> Example request:

```bash
curl -X GET -G "/v1/admin/post-categories/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/post-categories/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 1,
        "name": "Cat 3",
        "created_at": "2019-07-04 13:40:19",
        "updated_at": "2019-07-04 13:43:56"
    }
}
```

### HTTP Request
`GET /v1/admin/post-categories/{id}`


<!-- END_bf94e6d0a70a32dcc6a1002361c589b6 -->

<!-- START_260a95948451267ba8f673321352ab56 -->
## PostCategory create.

> Example request:

```bash
curl -X POST "/v1/admin/post-categories" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"name":"quam"}'

```
```javascript
const url = new URL("/v1/admin/post-categories");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "quam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Created successfully!",
    "data": {
        "name": "Cate 2",
        "updated_at": "2019-07-04 13:47:33",
        "created_at": "2019-07-04 13:47:33",
        "id": 2
    }
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Validation error",
    "data": {
        "image": [
            "The image field is required."
        ]
    }
}
```

### HTTP Request
`POST /v1/admin/post-categories`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | optional Name.

<!-- END_260a95948451267ba8f673321352ab56 -->

<!-- START_4a5e081cedb1c741d2324b4023304a5c -->
## PostCategory update.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/admin/post-categories/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"name":"explicabo"}'

```
```javascript
const url = new URL("/v1/admin/post-categories/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "explicabo"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Updated successfully!",
    "data": {
        "id": 1,
        "name": "Cat 3",
        "created_at": "2019-07-04 13:40:19",
        "updated_at": "2019-07-04 13:43:56"
    }
}
```

### HTTP Request
`PUT /v1/admin/post-categories/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | optional Name.

<!-- END_4a5e081cedb1c741d2324b4023304a5c -->

<!-- START_cd2ccdb1b3ec5eaa77a3bb4d2372b57e -->
## PostCategory delete.

> Example request:

```bash
curl -X DELETE "/v1/admin/post-categories/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/post-categories/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/admin/post-categories/{id}`


<!-- END_cd2ccdb1b3ec5eaa77a3bb4d2372b57e -->

<!-- START_03833cb3e39293ed7d0cc29054304a6c -->
## Post list.

> Example request:

```bash
curl -X GET -G "/v1/admin/posts" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/posts");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 20,
            "total": 2
        },
        "list": [
            {
                "categories": "Category 1, Category 2, Category 3",
                "id": 1,
                "title": "What is Lorem Ipsum?",
                "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                "image": "http:\/\/api.icm.lk\/images\/post\/777777.jpg",
                "likes": 0,
                "created_at": "2019-07-10 13:14:12",
                "updated_at": "2019-07-10 13:14:12"
            },
            {
                "categories": "Category 2, Category 3",
                "id": 2,
                "title": "Why do we use it?",
                "description": "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).",
                "image": "http:\/\/api.icm.lk\/images\/post\/888888.jpg",
                "likes": 0,
                "created_at": "2019-07-10 13:14:12",
                "updated_at": "2019-07-10 13:14:12"
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/admin/posts`


<!-- END_03833cb3e39293ed7d0cc29054304a6c -->

<!-- START_8e70bcefa23845c66c0b54e83418572d -->
## Post get record.

> Example request:

```bash
curl -X GET -G "/v1/admin/posts/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/posts/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 1,
        "title": "AA bb eee",
        "description": "<p>dd<\/p>",
        "image": "http:\/\/api.icm.lk\/images\/post\/15622527715d1e15e3d045d.jpg",
        "likes": 0,
        "category_id": 1,
        "created_at": "2019-07-04 15:06:11",
        "updated_at": "2019-07-04 15:12:29",
        "categories": [
            {
                "id": 2,
                "name": "Category 2",
                "created_at": "2019-08-17 23:04:28",
                "updated_at": "2019-08-17 23:04:28"
            },
            {
                "id": 4,
                "name": "Category 4",
                "created_at": "2019-08-17 23:04:28",
                "updated_at": "2019-08-17 23:04:28"
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/admin/posts/{id}`


<!-- END_8e70bcefa23845c66c0b54e83418572d -->

<!-- START_0d45bc18f1b9c67e061c25bfb0998f39 -->
## Post create.

> Example request:

```bash
curl -X POST "/v1/admin/posts" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"image":"fugit","title":"beatae","description":"eos","category_id":"rem"}'

```
```javascript
const url = new URL("/v1/admin/posts");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "image": "fugit",
    "title": "beatae",
    "description": "eos",
    "category_id": "rem"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Created successfully!",
    "data": {
        "title": "2nd post",
        "description": "<p>test<\/p>",
        "image": "http:\/\/api.icm.lk\/images\/post\/15622536325d1e1940c17d3.jpg",
        "updated_at": "2019-07-04 15:20:32",
        "created_at": "2019-07-04 15:20:32",
        "id": 2
    }
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Validation error",
    "data": {
        "image": [
            "The image field is required."
        ]
    }
}
```

### HTTP Request
`POST /v1/admin/posts`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    image | file |  required  | Image.
    title | string |  required  | Title.
    description | string |  optional  | optional Description.
    category_id | string |  required  | Category ID.

<!-- END_0d45bc18f1b9c67e061c25bfb0998f39 -->

<!-- START_7701ec0dbc5596b62f6f0a471b100935 -->
## Post update.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/admin/posts/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"image":"recusandae","title":"deserunt","description":"similique","category_id":"neque"}'

```
```javascript
const url = new URL("/v1/admin/posts/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "image": "recusandae",
    "title": "deserunt",
    "description": "similique",
    "category_id": "neque"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Updated successfully!",
    "data": true
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Validation error",
    "data": {
        "title": [
            "The title field is required."
        ]
    }
}
```

### HTTP Request
`PUT /v1/admin/posts/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    image | file |  optional  | optional Image.
    title | string |  required  | Title.
    description | string |  optional  | optional Description.
    category_id | string |  required  | Category ID.

<!-- END_7701ec0dbc5596b62f6f0a471b100935 -->

<!-- START_cc501e2c0429da2faf513ed6bba06a46 -->
## Post delete.

> Example request:

```bash
curl -X DELETE "/v1/admin/posts/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/posts/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/admin/posts/{id}`


<!-- END_cc501e2c0429da2faf513ed6bba06a46 -->

<!-- START_8bdf23d4bb2d6589e5531b8a00ed937e -->
## PostComment list.

> Example request:

```bash
curl -X GET -G "/v1/admin/posts/1/post-comments" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/posts/1/post-comments");

    let params = {
            "pid": "deleniti",
            "page": "20",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 10,
            "total": 4
        },
        "list": [
            {
                "id": 6,
                "post_id": 1,
                "comment": "test",
                "created_at": "2019-07-05 11:54:18",
                "updated_at": "2019-07-05 11:54:18",
                "post_replies": [],
                "user_detail": {
                    "first_name": "Client",
                    "last_name": "",
                    "gender": "male",
                    "prof_pic": null
                }
            },
            {
                "id": 3,
                "post_id": 1,
                "comment": "test",
                "created_at": "2019-07-05 11:45:53",
                "updated_at": "2019-07-05 11:45:53",
                "post_replies": [
                    {
                        "id": 1,
                        "post_comment_id": 3,
                        "comment": "reply 1",
                        "created_at": "2019-07-05 13:41:51",
                        "updated_at": "2019-07-05 13:41:51",
                        "user_detail": {
                            "first_name": "Client",
                            "last_name": "",
                            "gender": "male",
                            "prof_pic": null
                        }
                    },
                    {
                        "id": 3,
                        "post_comment_id": 3,
                        "comment": "reply 3",
                        "created_at": "2019-07-05 13:42:04",
                        "updated_at": "2019-07-05 13:42:04",
                        "user_detail": {
                            "first_name": "Admin",
                            "last_name": "",
                            "gender": "male",
                            "prof_pic": null
                        }
                    }
                ],
                "user_detail": {
                    "first_name": "Client",
                    "last_name": "",
                    "gender": "male",
                    "prof_pic": null
                }
            },
            {
                "id": 2,
                "post_id": 1,
                "comment": "test",
                "created_at": "2019-07-05 11:45:52",
                "updated_at": "2019-07-05 11:45:52",
                "post_replies": [],
                "user_detail": {
                    "first_name": "Admin",
                    "last_name": "",
                    "gender": "male",
                    "prof_pic": null
                }
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/admin/posts/{pid}/post-comments`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    pid |  required  | Post ID.
    page |  optional  | Page number.

<!-- END_8bdf23d4bb2d6589e5531b8a00ed937e -->

<!-- START_0ee154ec47780dff74375496f6d4a392 -->
## PostComment delete comment.

> Example request:

```bash
curl -X DELETE "/v1/admin/posts/1/post-comments/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/posts/1/post-comments/1");

    let params = {
            "pid": "laborum",
            "id": "omnis",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/admin/posts/{pid}/post-comments/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    pid |  required  | Post ID.
    id |  required  | Comment ID.

<!-- END_0ee154ec47780dff74375496f6d4a392 -->

<!-- START_5d1a34fe68922f44b417596144db7bc5 -->
## PostCommentReply delete reply.

> Example request:

```bash
curl -X DELETE "/v1/admin/post-comments/1/reply/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/post-comments/1/reply/1");

    let params = {
            "cid": "deleniti",
            "id": "quibusdam",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/admin/post-comments/{cid}/reply/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    cid |  required  | Post comment ID.
    id |  required  | Reply ID.

<!-- END_5d1a34fe68922f44b417596144db7bc5 -->

<!-- START_c1a6978ce8faee03c25510cf7a805a8c -->
## DashboardImage list.

> Example request:

```bash
curl -X GET -G "/v1/admin/dashboard-images" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/dashboard-images");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": [
        {
            "id": 1,
            "name": "company 1",
            "image": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/dashboard\/232323.jpg",
            "created_at": "2019-06-23 12:00:27",
            "updated_at": "2019-06-23 12:00:27"
        }
    ]
}
```

### HTTP Request
`GET /v1/admin/dashboard-images`


<!-- END_c1a6978ce8faee03c25510cf7a805a8c -->

<!-- START_5a6f2dd0e4127e94ac51ee5e87231991 -->
## DashboardImage get record.

> Example request:

```bash
curl -X GET -G "/v1/admin/dashboard-images/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/dashboard-images/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 2,
        "name": "roserbery",
        "image": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/dashboard\/232323.jpg",
        "created_at": "2019-06-24 06:52:40",
        "updated_at": "2019-06-24 06:52:40"
    }
}
```

### HTTP Request
`GET /v1/admin/dashboard-images/{id}`


<!-- END_5a6f2dd0e4127e94ac51ee5e87231991 -->

<!-- START_4b62f4fc895379e9d6c72305b3847850 -->
## DashboardImage create.

> Example request:

```bash
curl -X POST "/v1/admin/dashboard-images" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"name":"harum","image":"quisquam"}'

```
```javascript
const url = new URL("/v1/admin/dashboard-images");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "harum",
    "image": "quisquam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Created successfully!",
    "data": {
        "name": "Lit solutions",
        "image": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/dashboard\/232323.jpg",
        "updated_at": "2019-06-23 12:04:40",
        "created_at": "2019-06-23 12:04:40",
        "id": 2
    }
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Validation error",
    "data": {
        "image": [
            "The image field is required."
        ]
    }
}
```

### HTTP Request
`POST /v1/admin/dashboard-images`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | optional Name.
    image | file |  required  | Image.

<!-- END_4b62f4fc895379e9d6c72305b3847850 -->

<!-- START_43c2962d911a3e6952eac85727e9bf99 -->
## DashboardImage update.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/admin/dashboard-images/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"name":"sint","image":"saepe"}'

```
```javascript
const url = new URL("/v1/admin/dashboard-images/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "sint",
    "image": "saepe"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Updated successfully!",
    "data": null
}
```

### HTTP Request
`PUT /v1/admin/dashboard-images/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | optional Name.
    image | file |  optional  | optional Image.

<!-- END_43c2962d911a3e6952eac85727e9bf99 -->

<!-- START_902df23ac277f0c7e1950900a7358a37 -->
## Advertisement delete.

> Example request:

```bash
curl -X DELETE "/v1/admin/dashboard-images/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/dashboard-images/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/admin/dashboard-images/{id}`


<!-- END_902df23ac277f0c7e1950900a7358a37 -->

#Auth
<!-- START_d5afbe1129f6f5eccd5235d9317b30bf -->
## User deauthenticate.

> Example request:

```bash
curl -X POST "/v1/auth/logout" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/auth/logout");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /v1/auth/logout`


<!-- END_d5afbe1129f6f5eccd5235d9317b30bf -->

<!-- START_034fac6053a11b7a6389fd8da063c649 -->
## Admin user Authenticate.

> Example request:

```bash
curl -X POST "/v1/admin/auth/login" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"email":"ducimus","password":"accusantium"}'

```
```javascript
const url = new URL("/v1/admin/auth/login");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "email": "ducimus",
    "password": "accusantium"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Token retrieved successfully",
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"
    }
}
```
> Example response (400):

```json
{
    "success": false,
    "message": "Email does not exist.",
    "data": null
}
```

### HTTP Request
`POST /v1/admin/auth/login`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | email |  required  | Email address
    password | string |  required  | Password

<!-- END_034fac6053a11b7a6389fd8da063c649 -->

<!-- START_f02cc32415e1ef55624d4f4af4308640 -->
## Admin user deauthenticate.

> Example request:

```bash
curl -X POST "/v1/admin/auth/logout" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/admin/auth/logout");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /v1/admin/auth/logout`


<!-- END_f02cc32415e1ef55624d4f4af4308640 -->

<!-- START_9518d65b70d30a13b915a5a8df184fd5 -->
## User Authenticate.

> Example request:

```bash
curl -X POST "/v1/auth/login" \
    -H "Content-Type: application/json" \
    -d '{"email":"libero","password":"tempore","oauth_provider":"laudantium","oauth_uid":"quis","type":"maiores","device_id":"nihil"}'

```
```javascript
const url = new URL("/v1/auth/login");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "email": "libero",
    "password": "tempore",
    "oauth_provider": "laudantium",
    "oauth_uid": "quis",
    "type": "maiores",
    "device_id": "nihil"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Token retrieved successfully",
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9",
        "dashboard_img": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/dashboard\/232323.jpg"
    }
}
```
> Example response (400):

```json
{
    "success": false,
    "message": "Email does not exist.",
    "data": null
}
```

### HTTP Request
`POST /v1/auth/login`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | email |  required  | Email address
    password | string |  required  | Password
    oauth_provider | string |  required  | '' or facebook or google.
    oauth_uid | string |  required  | Auth ID.
    type | string |  required  | Platform (ios or android).
    device_id | string |  required  | Device ID.

<!-- END_9518d65b70d30a13b915a5a8df184fd5 -->

#Client
<!-- START_605cdc53e7c36bc756aa4518148c2dc0 -->
## User register.

**mobile_no** should according to E.164 international format
Ex: +94775186150 (0775186150, 775186150 are wrong)

Here if **oauth_provider** and **oauth_uid** is set, **password** not required
otherwise **password** is required.

Dob format `1990-12-13`.

Gender is an enum which has only `male` or `female`

> Example request:

```bash
curl -X POST "/v1/user" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"first_name":"ad","mobile_no":"maxime","email":"natus","password":"dignissimos","oauth_provider":"quae","oauth_uid":"enim","dob":"recusandae","gender":"voluptatem","referral_point":20,"referral_no":"quaerat"}'

```
```javascript
const url = new URL("/v1/user");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "first_name": "ad",
    "mobile_no": "maxime",
    "email": "natus",
    "password": "dignissimos",
    "oauth_provider": "quae",
    "oauth_uid": "enim",
    "dob": "recusandae",
    "gender": "voluptatem",
    "referral_point": 20,
    "referral_no": "quaerat"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Registered successfully!",
    "data": [
        {
            "id": 33,
            "email": "antonlashan12@gmail.com",
            "mobile_no": "94775186150",
            "sms_ref_id": "f437c171-2d08-48c8-a4a2-xxxxxxxx",
            "created_at": "2019-07-24 11:15:06",
            "updated_at": "2019-07-24 11:15:06",
            "user_detail": {
                "first_name": "Anton",
                "last_name": "",
                "nic": "",
                "gender": "male",
                "dob": "2010-01-01",
                "birth_district_id": null,
                "highest_edu_qualification": "",
                "current_work_place": "",
                "registration_no": "",
                "prof_pic": null,
                "referral_point": 2,
                "referral_no": "",
                "created_at": "2019-07-24 11:15:06",
                "updated_at": "2019-07-24 11:15:06"
            }
        }
    ]
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Validation error",
    "data": {
        "mobile_no": [
            "The mobile no has already been taken."
        ],
        "email": [
            "The email has already been taken."
        ]
    }
}
```

### HTTP Request
`POST /v1/user`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    first_name | string |  required  | First name.
    mobile_no | string |  required  | Mobile number.
    email | string |  required  | Email.
    password | string |  required  | Password.
    oauth_provider | string |  required  | '' or facebook or google.
    oauth_uid | string |  required  | Auth ID.
    dob | string |  required  | birthday.
    gender | enum |  required  | male or female.
    referral_point | integer |  optional  | required.
    referral_no | string |  optional  | max 20.

<!-- END_605cdc53e7c36bc756aa4518148c2dc0 -->

<!-- START_215bc6fb4f0fbada720bf87360b1837b -->
## User verify OTP by phone number.

> Example request:

```bash
curl -X POST "/v1/user/verify-otp" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"code":"officia","sms_ref_id":"et"}'

```
```javascript
const url = new URL("/v1/user/verify-otp");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "code": "officia",
    "sms_ref_id": "et"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "referenceId": "f6eaefa0-ae1c-11e9-a959-dd0d4e395bb7",
        "code": "36449",
        "statusCode": "1000",
        "description": "verification success"
    }
}
```
> Example response (400):

```json
{
    "success": false,
    "message": "verification failed",
    "data": null
}
```

### HTTP Request
`POST /v1/user/verify-otp`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    code | string |  required  | OTP code from sms.
    sms_ref_id | string |  required  | SMS reference id.

<!-- END_215bc6fb4f0fbada720bf87360b1837b -->

<!-- START_671848d3e06a2be26edad582f844b082 -->
## User resend OTP.

> Example request:

```bash
curl -X POST "/v1/user/resend-otp" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"email":"ducimus"}'

```
```javascript
const url = new URL("/v1/user/resend-otp");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "email": "ducimus"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 5,
        "email": "rebecca.hunter@nurse.com",
        "mobile_no": "94775186150",
        "sms_ref_id": "6337fca0-ae24-11e9-96e2-19a992bdbfe1",
        "created_at": "2019-07-24 14:30:52",
        "updated_at": "2019-07-24 15:04:52"
    }
}
```

### HTTP Request
`POST /v1/user/resend-otp`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | Email address.

<!-- END_671848d3e06a2be26edad582f844b082 -->

<!-- START_083c72cd47bf3c408ba98fd9a74cb50d -->
## ForgotPwd send OTP.

> Example request:

```bash
curl -X POST "/v1/forgot-pwd/send-otp" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"email":"in"}'

```
```javascript
const url = new URL("/v1/forgot-pwd/send-otp");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "email": "in"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 5,
        "email": "rebecca.hunter@nurse.com",
        "mobile_no": "94775186150",
        "sms_ref_id": "6337fca0-ae24-11e9-96e2-19a992bdbfe1",
        "created_at": "2019-07-24 14:30:52",
        "updated_at": "2019-07-24 15:04:52"
    }
}
```

### HTTP Request
`POST /v1/forgot-pwd/send-otp`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | Email address.

<!-- END_083c72cd47bf3c408ba98fd9a74cb50d -->

<!-- START_99ee525230dda210236053d0765dc95d -->
## ForgotPwd verify OTP by phone number.

> Example request:

```bash
curl -X POST "/v1/forgot-pwd/verify-otp" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"code":"consequatur","sms_ref_id":"ut"}'

```
```javascript
const url = new URL("/v1/forgot-pwd/verify-otp");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "code": "consequatur",
    "sms_ref_id": "ut"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "referenceId": "f6eaefa0-ae1c-11e9-a959-dd0d4e395bb7",
        "code": "36449",
        "statusCode": "1000",
        "description": "verification success"
    }
}
```
> Example response (400):

```json
{
    "success": false,
    "message": "verification failed",
    "data": null
}
```

### HTTP Request
`POST /v1/forgot-pwd/verify-otp`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    code | string |  required  | OTP code from sms.
    sms_ref_id | string |  required  | SMS reference id.

<!-- END_99ee525230dda210236053d0765dc95d -->

<!-- START_d637c4256b94bb9f30bf6041ccbb4959 -->
## ForgotPwd resend OTP.

> Example request:

```bash
curl -X POST "/v1/forgot-pwd/resend-otp" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"email":"dolor"}'

```
```javascript
const url = new URL("/v1/forgot-pwd/resend-otp");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "email": "dolor"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 5,
        "email": "rebecca.hunter@nurse.com",
        "mobile_no": "94775186150",
        "sms_ref_id": "6337fca0-ae24-11e9-96e2-19a992bdbfe1",
        "created_at": "2019-07-24 14:30:52",
        "updated_at": "2019-07-24 15:04:52"
    }
}
```

### HTTP Request
`POST /v1/forgot-pwd/resend-otp`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | Email address.

<!-- END_d637c4256b94bb9f30bf6041ccbb4959 -->

<!-- START_3b699d2e8f7bca73f29a864954864cbf -->
## ForgotPwd change password.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/forgot-pwd" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"sms_ref_id":"aliquam","password":"ipsam","password_confirmation":"nesciunt"}'

```
```javascript
const url = new URL("/v1/forgot-pwd");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "sms_ref_id": "aliquam",
    "password": "ipsam",
    "password_confirmation": "nesciunt"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Password updated successfully.",
    "data": null
}
```

### HTTP Request
`PUT /v1/forgot-pwd`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    sms_ref_id | string |  required  | SMS reference id.
    password | string |  required  | New password.
    password_confirmation | string |  required  | Confirmation password.

<!-- END_3b699d2e8f7bca73f29a864954864cbf -->

<!-- START_93ff612cdccc5678e337d899e1d7893d -->
## District list.

> Example request:

```bash
curl -X GET -G "/v1/test-list" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/test-list");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": [
        {
            "id": 1,
            "name": "Ampara"
        },
        {
            "id": 2,
            "name": "Anuradhapura"
        }
    ]
}
```

### HTTP Request
`GET /v1/test-list`


<!-- END_93ff612cdccc5678e337d899e1d7893d -->

<!-- START_1b801ba61d5963e8a15c6b77a410fbcb -->
## District list.

> Example request:

```bash
curl -X GET -G "/v1/districts" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/districts");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": [
        {
            "id": 1,
            "name": "Ampara"
        },
        {
            "id": 2,
            "name": "Anuradhapura"
        }
    ]
}
```

### HTTP Request
`GET /v1/districts`


<!-- END_1b801ba61d5963e8a15c6b77a410fbcb -->

<!-- START_d49e542ee26f278830a796a93751f343 -->
## CompanyPost list.

> Example request:

```bash
curl -X GET -G "/v1/company-posts" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/company-posts");

    let params = {
            "page": "sequi",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 20,
            "total": 15
        },
        "list": [
            {
                "id": 15,
                "company_id": 4,
                "position": "Room Assistant - Trincomalee",
                "description": "<p>⇒⇒⇒ අප තරු පන්තියේ හෝටලය සදහා පහත සේවකයින් බදවා ගනු ලැබේ..<\/p><p># තනතුර ;<br>➫ Room Boy&nbsp;<br># අවශ්‍ය සුදුසුකම් ;<\/p><p>➫ වයස අවු, 18 - 35 අතර බඳවා ගනු ලැබේ.<br>➫ අ.පො.ස (සා \/පෙළ ) සමත් විය යුතුය.<br>➫ ක්‍රියාශීලි අයෙක් විය යුතුය .<br>➫ සාමාන්‍ය ඉංග්‍රීසි දැනුම අනිවාර්ය වේ.<\/p><p>➫ ආහාර, නවාතැන් පහසුකම් නොමිලේ.<br>➫ වැටුප රු.35,000 වැඩි&nbsp;<br>➫ ETF\/ EPF ඇතුළු දිරි දීමනා රැසක්.<\/p><p>☞ ඉහත සුදුසුකම් සපුරාලු ඔබ , අදම අපගේ පහත අංකයට අමතන්න.<\/p><p>&nbsp;<\/p><p><br>&nbsp;<\/p>",
                "created_at": "2019-07-13 10:34:32",
                "updated_at": "2019-07-13 10:34:32",
                "applied_status": null,
                "has_bookmarked": false,
                "company": {
                    "id": 4,
                    "name": "Medical center at Mount Lavinia",
                    "logo": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/company\/15636318485d3320e89ad55.jpg",
                    "banner": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/company\/15635268375d3186b53f18e.jpg",
                    "address": "Galle Road, Mt. Lavinia, Sri Lanka",
                    "phone": "123456231",
                    "email": "mount@parmacy.com",
                    "created_at": "2019-07-13 10:23:08",
                    "updated_at": "2019-07-20 14:10:48"
                }
            },
            {
                "id": 14,
                "company_id": 2,
                "position": "HR Executive - Gampaha",
                "description": "<p># POSITION: HR Executive<br># REQUIREMENTS:<br>• HR Professional qualification from a recognized Institute.&nbsp;<br>• Age below 25 - 30 years.&nbsp;<br>• Computer literacy.<br>• A minimum of 1-2 years’ work experience in HR field.&nbsp;<br>• Excellent Communication Skills.<br>• A pleasing personality with hands on experience on recruitment, a positive attitude, high on initiative, proactive thinking and the ability on multi-tasking&nbsp;<br>Attractive remuneration package on par with other fringe benefits.<br># HOW TO APPLY:<br>Please send your resume stating the position applied on the subject line of e-mail with details of two non- related referees within 14 days of this advertisement<br>If you feel you are the right individual for the above position, then apply via \"Apply for this job\" of this advert with your RESUME.<\/p><p>&nbsp;<\/p><p>See less<\/p>",
                "created_at": "2019-07-13 10:34:02",
                "updated_at": "2019-07-13 10:34:02",
                "applied_status": null,
                "has_bookmarked": false,
                "company": {
                    "id": 2,
                    "name": "Wellfort Management Pvt Ltd",
                    "logo": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/company\/15643103865d3d7b726e5bd.jpg",
                    "banner": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/company\/111111.jpg",
                    "address": "Colombo",
                    "phone": "0777222963",
                    "email": "test@wellfort.com",
                    "created_at": "2019-07-10 23:44:12",
                    "updated_at": "2019-07-28 10:39:46"
                }
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/company-posts`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    page |  optional  | Page id.

<!-- END_d49e542ee26f278830a796a93751f343 -->

<!-- START_794fbadf4d45cfe9cbc32dad7bb77370 -->
## CompanyPost get record.

> Example request:

```bash
curl -X GET -G "/v1/company-posts/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/company-posts/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 1,
        "company_id": 1,
        "position": "Nurse (Female\/Male) - Colombo 5",
        "description": "Description",
        "created_at": "2019-06-27 17:14:10",
        "updated_at": "2019-06-27 17:14:10",
        "applied_status": "pending",
        "has_bookmarked": true,
        "company": {
            "id": 1,
            "name": "Asiri Hospital Holdings Pvt Ltd",
            "image": "http:\/\/api.icm.lk\/images\/company\/111111.jpg",
            "address": "Colombo 5",
            "phone": "2575637401",
            "email": "test@chapman.com",
            "created_at": "2019-06-27 17:14:10",
            "updated_at": "2019-06-27 17:14:10"
        }
    }
}
```

### HTTP Request
`GET /v1/company-posts/{id}`


<!-- END_794fbadf4d45cfe9cbc32dad7bb77370 -->

<!-- START_01269655806ce0b2d5b51531963be953 -->
## Advertisement list.

> Example request:

```bash
curl -X GET -G "/v1/advertisements" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/advertisements");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": [
        {
            "id": 2,
            "name": "Image 2",
            "image": "http:\/\/api.icm.lk\/images\/advertisement\/1561291227.jpg",
            "created_at": "2019-06-23 12:00:27",
            "updated_at": "2019-06-23 12:00:27"
        },
        {
            "id": 1,
            "name": "Image 1",
            "image": "http:\/\/api.icm.lk\/images\/advertisement\/1561291480.jpg",
            "created_at": "2019-06-23 12:04:40",
            "updated_at": "2019-06-23 12:04:40"
        },
        {
            "id": 3,
            "name": "Image 3",
            "image": "http:\/\/api.icm.lk\/images\/advertisement\/1561291485.jpg",
            "created_at": "2019-06-23 12:04:40",
            "updated_at": "2019-06-23 12:04:40"
        }
    ]
}
```

### HTTP Request
`GET /v1/advertisements`


<!-- END_01269655806ce0b2d5b51531963be953 -->

<!-- START_fc30b1f5a8def4c60b020bf4ada2c8f5 -->
## CompanyPostBookmark list.

> Example request:

```bash
curl -X GET -G "/v1/company-post-bookmarks" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/company-post-bookmarks");

    let params = {
            "page": "animi",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 10,
            "total": 1
        },
        "list": [
            {
                "id": 5,
                "company_post_id": 3,
                "company_post": {
                    "id": 3,
                    "company_id": 5,
                    "position": "test",
                    "description": "test2",
                    "created_at": "2019-06-24 07:19:23",
                    "updated_at": "2019-06-25 18:52:01",
                    "company": {
                        "id": 1,
                        "name": "Asiri Hospital Holdings Pvt Ltd",
                        "logo": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/company\/111111.jpg",
                        "banner": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/company\/15641511165d3b0d4c1c7de.jpeg",
                        "address": "Colombo 5",
                        "phone": "2575637401",
                        "email": "test@chapman.com",
                        "created_at": "2019-07-10 23:44:12",
                        "updated_at": "2019-07-26 14:25:16"
                    }
                }
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/company-post-bookmarks`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    page |  optional  | Page id.

<!-- END_fc30b1f5a8def4c60b020bf4ada2c8f5 -->

<!-- START_21cd3a58f6770ff981f392b75e7c754a -->
## CompanyPostBookmark bookmark.

> Example request:

```bash
curl -X POST "/v1/company-post-bookmarks" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"company_post_id":2}'

```
```javascript
const url = new URL("/v1/company-post-bookmarks");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "company_post_id": 2
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Created successfully!",
    "data": {
        "id": 5,
        "company_post_id": 3
    }
}
```

### HTTP Request
`POST /v1/company-post-bookmarks`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    company_post_id | integer |  required  | Company post ID.

<!-- END_21cd3a58f6770ff981f392b75e7c754a -->

<!-- START_cb552588550e4cb3915a14502387ada0 -->
## CompanyPostApplication list.

> Example request:

```bash
curl -X GET -G "/v1/company-post-applications" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/company-post-applications");

    let params = {
            "page": "quia",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 10,
            "total": 1
        },
        "list": [
            {
                "id": 5,
                "company_post_id": 3,
                "status": "pending",
                "company_post": {
                    "id": 3,
                    "company_id": 5,
                    "position": "test",
                    "description": "test2",
                    "created_at": "2019-06-24 07:19:23",
                    "updated_at": "2019-06-25 18:52:01",
                    "company": {
                        "id": 1,
                        "name": "Asiri Hospital Holdings Pvt Ltd",
                        "logo": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/company\/111111.jpg",
                        "banner": "http:\/\/api.icm.lk\/thumb\/w2000\/images\/company\/15641511165d3b0d4c1c7de.jpeg",
                        "address": "Colombo 5",
                        "phone": "2575637401",
                        "email": "test@chapman.com",
                        "created_at": "2019-07-10 23:44:12",
                        "updated_at": "2019-07-26 14:25:16"
                    }
                }
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/company-post-applications`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    page |  optional  | Page id.

<!-- END_cb552588550e4cb3915a14502387ada0 -->

<!-- START_e43ec49da327be5e3ffd49cefa2ed09d -->
## CompanyPostApplication apply.

> Example request:

```bash
curl -X POST "/v1/company-post-applications/apply" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"company_post_id":8}'

```
```javascript
const url = new URL("/v1/company-post-applications/apply");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "company_post_id": 8
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "You can apply for this post.",
    "data": true
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "User already applied.",
    "data": null
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Please complete your profile.",
    "data": null
}
```

### HTTP Request
`POST /v1/company-post-applications/apply`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    company_post_id | integer |  required  | Company post ID.

<!-- END_e43ec49da327be5e3ffd49cefa2ed09d -->

<!-- START_a504da341e27b030b50a82541471b45a -->
## CompanyPostApplication confirm.

> Example request:

```bash
curl -X POST "/v1/company-post-applications/confirm" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"company_post_id":6}'

```
```javascript
const url = new URL("/v1/company-post-applications/confirm");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "company_post_id": 6
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Created successfully!",
    "data": {
        "company_post_id": "2",
        "updated_at": "2019-06-27 16:51:21",
        "created_at": "2019-06-27 16:51:21",
        "id": 1
    }
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "User already applied.",
    "data": null
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Please complete your profile.",
    "data": null
}
```

### HTTP Request
`POST /v1/company-post-applications/confirm`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    company_post_id | integer |  required  | Company post ID.

<!-- END_a504da341e27b030b50a82541471b45a -->

<!-- START_4191347324a0c063ce6ffd56dc118fb6 -->
## User get profile.

> Example request:

```bash
curl -X GET -G "/v1/user" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/user");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "first_name": "Lashan",
        "last_name": "Fernando",
        "nic": "198516003220",
        "gender": "male",
        "dob": "1985-06-08",
        "birth_district_id": 15,
        "highest_edu_qualification": "Bsc",
        "current_work_place": "Negombo",
        "registration_no": "123356778",
        "prof_pic": "http:\/\/api.icm.lk\/images\/user\/1561291480.jpg",
        "professional": "",
        "vtc": "",
        "referral_point": 2,
        "referral_point_lbl": "Social media",
        "referral_no": "",
        "created_at": "2019-07-02 09:37:20",
        "updated_at": "2019-07-02 11:32:54",
        "user_qualifications": {
            "a_level": [
                {
                    "id": 28,
                    "name": "Maths",
                    "grade": "A",
                    "type": "a_level"
                },
                {
                    "id": 29,
                    "name": "Physics",
                    "grade": "B",
                    "type": "a_level"
                },
                {
                    "id": 30,
                    "name": "Chemistry",
                    "grade": "C",
                    "type": "a_level"
                }
            ],
            "o_level": [
                {
                    "id": 31,
                    "name": "Sinhala",
                    "grade": "A",
                    "type": "o_level"
                },
                {
                    "id": 32,
                    "name": "Maths",
                    "grade": "A",
                    "type": "o_level"
                },
                {
                    "id": 33,
                    "name": "Science",
                    "grade": "B",
                    "type": "o_level"
                },
                {
                    "id": 34,
                    "name": "English",
                    "grade": "C",
                    "type": "o_level"
                }
            ]
        },
        "user": {
            "id": 3,
            "email": "john.edmunds@nurse.com",
            "mobile_no": "1234567892",
            "sms_ref_id": "",
            "created_at": "2019-08-17 10:54:05",
            "updated_at": "2019-08-17 11:02:21"
        },
        "district": {
            "id": 15,
            "name": "Mannar"
        }
    }
}
```

### HTTP Request
`GET /v1/user`


<!-- END_4191347324a0c063ce6ffd56dc118fb6 -->

<!-- START_548eb5fce4d40bdfa62163a8426cdc8e -->
## User profile update.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/user" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"first_name":"ex","last_name":"vel","nic":"et","dob":"voluptates","gender":"iste","birth_district_id":6,"highest_edu_qualification":"itaque","current_work_place":"id","a_level":[],"o_level":[],"professional":"repellendus","vtc":"accusantium","_method":"eos"}'

```
```javascript
const url = new URL("/v1/user");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "first_name": "ex",
    "last_name": "vel",
    "nic": "et",
    "dob": "voluptates",
    "gender": "iste",
    "birth_district_id": 6,
    "highest_edu_qualification": "itaque",
    "current_work_place": "id",
    "a_level": [],
    "o_level": [],
    "professional": "repellendus",
    "vtc": "accusantium",
    "_method": "eos"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Profile updated successfully.",
    "data": null
}
```

### HTTP Request
`PUT /v1/user`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    first_name | string |  required  | First name.
    last_name | string |  optional  | Last name.
    nic | string |  required  | NIC.
    dob | string |  required  | DOB(1985-01-01).
    gender | enum |  required  | male or female.
    birth_district_id | integer |  required  | District ID.
    highest_edu_qualification | string |  required  | Highest education qualification.
    current_work_place | string |  optional  | Current work place.
    a_level | array |  required  | A level results [{"name": "Sinhala", "grade": "A"}, {"name": "CHEM", "grade": "B"}].
    o_level | array |  required  | O level results [{"name": "Maths", "grade": "A"}].
    professional | string |  optional  | Professional exam results.
    vtc | string |  optional  | VTC exam results.
    _method | string |  required  | _method=PUT.

<!-- END_548eb5fce4d40bdfa62163a8426cdc8e -->

<!-- START_327017b7d3bd54e2dc74eeedba8607be -->
## User update profile pic.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/user/profile-pic" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"prof_pic":"voluptatibus","_method":"nostrum"}'

```
```javascript
const url = new URL("/v1/user/profile-pic");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "prof_pic": "voluptatibus",
    "_method": "nostrum"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Uploaded successfully!",
    "data": {
        "first_name": "Client",
        "last_name": "",
        "nic": "",
        "gender": "male",
        "dob": "1985-01-02",
        "birth_district_id": null,
        "highest_edu_qualification": "",
        "current_work_place": "",
        "registration_no": "",
        "prof_pic": "http:\/\/api.icm.lk\/images\/user\/15621426975d1c67e9da92a.png",
        "created_at": "2019-07-03 08:19:36",
        "updated_at": "2019-07-03 08:31:37"
    }
}
```

### HTTP Request
`PUT /v1/user/profile-pic`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    prof_pic | file |  required  | Profile image.
    _method | string |  required  | _method=PUT.

<!-- END_327017b7d3bd54e2dc74eeedba8607be -->

<!-- START_836df5ac8944b91ec5aa4805a5f98e16 -->
## User change password.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/user/update-pwd" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"password_current":"omnis","password":"beatae","password_confirmation":"enim"}'

```
```javascript
const url = new URL("/v1/user/update-pwd");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "password_current": "omnis",
    "password": "beatae",
    "password_confirmation": "enim"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Password updated successfully.",
    "data": null
}
```
> Example response (422):

```json
{
    "success": false,
    "message": "Current password not matched.",
    "data": null
}
```

### HTTP Request
`PUT /v1/user/update-pwd`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    password_current | string |  required  | Current password.
    password | string |  required  | New password.
    password_confirmation | string |  required  | Confirmation password.

<!-- END_836df5ac8944b91ec5aa4805a5f98e16 -->

<!-- START_5f63c2ed6017ee7e43dfae2744bad67d -->
## User get referral points.

> Example request:

```bash
curl -X GET -G "/v1/user/referral-points" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/user/referral-points");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": [
        {
            "id": 1,
            "label": "Agent"
        },
        {
            "id": 2,
            "label": "Social Media"
        },
        {
            "id": 3,
            "label": "Campaign"
        },
        {
            "id": 4,
            "label": "News Paper"
        },
        {
            "id": 5,
            "label": "Other"
        }
    ]
}
```

### HTTP Request
`GET /v1/user/referral-points`


<!-- END_5f63c2ed6017ee7e43dfae2744bad67d -->

<!-- START_f3f045236adc44491bbc2ded30db5c82 -->
## News list.

> Example request:

```bash
curl -X GET -G "/v1/news" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/news");

    let params = {
            "page": "rerum",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 20,
            "total": 2
        },
        "list": [
            {
                "id": 1,
                "title": "Hemasiri, Pujith further remanded",
                "desc_1": "<p>Former Defence Secretary Hemasiri Fernando and IGP Pujith Jayasundara, who were arrested by the CID at the Colombo National Hospital yesterday, were further remanded until July 9 by Colombo Chief Magistrate Lanka Jayaratne.<\/p>",
                "desc_2": "<p>Former Defence Secretary Hemasiri Fernando and IGP Pujith Jayasundara, who were arrested by the CID at the Colombo National Hospital yesterday, were further remanded until July 9 by Colombo Chief Magistrate Lanka Jayaratne. (Shehan Chamika Silva)<\/p>",
                "image": "http:\/\/api.icm.lk\/images\/news\/333333.jpg",
                "is_featured": false,
                "created_at": "2019-07-03 13:32:33",
                "updated_at": "2019-07-03 13:59:37"
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/news`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    page |  optional  | Page id.

<!-- END_f3f045236adc44491bbc2ded30db5c82 -->

<!-- START_9ba03ffcd779eef328818901723135ad -->
## News get featured news.

> Example request:

```bash
curl -X GET -G "/v1/news/featured-news" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/news/featured-news");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful!",
    "data": {
        "title": "Leaving for UN missions",
        "desc_1": "<p>A new contingent of 61 Army personnel including 11officers under the phase six of the UN Mission of South Sudan (UNMISS),&nbsp;<\/p>",
        "desc_2": "<p>left this morning for South Sudan to serve in the SRIMED Level 2 Hospital in Bor, South Sudan.<strong> Pix by Army Media<\/strong><\/p>",
        "is_featured": true,
        "image": "http:\/\/api.icm.lk\/images\/news\/15621633705d1cb8aaa831d.jpg",
        "updated_at": "2019-07-03 14:16:10",
        "created_at": "2019-07-03 14:16:10",
        "id": 3
    }
}
```

### HTTP Request
`GET /v1/news/featured-news`


<!-- END_9ba03ffcd779eef328818901723135ad -->

<!-- START_bc971799932058fb11b93c43ed0598de -->
## PostCategory list.

> Example request:

```bash
curl -X GET -G "/v1/post-categories" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/post-categories");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": [
        {
            "id": 1,
            "name": "Cat 3",
            "created_at": "2019-07-04 13:40:19",
            "updated_at": "2019-07-04 13:43:56"
        },
        {
            "id": 2,
            "name": "Cate 2",
            "created_at": "2019-07-04 13:47:33",
            "updated_at": "2019-07-04 13:47:33"
        }
    ]
}
```

### HTTP Request
`GET /v1/post-categories`


<!-- END_bc971799932058fb11b93c43ed0598de -->

<!-- START_2209ecf6aba23bb5213e50c5064981ff -->
## Post list.

> Example request:

```bash
curl -X GET -G "/v1/posts" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/posts");

    let params = {
            "category_id": "est",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 20,
            "total": 1
        },
        "list": [
            {
                "id": 1,
                "title": "AA bb eee",
                "description": "<p>dd<\/p>",
                "image": "http:\/\/api.icm.lk\/images\/post\/15622527715d1e15e3d045d.jpg",
                "likes": 2,
                "category_id": 1,
                "created_at": "2019-07-04 15:06:11",
                "updated_at": "2019-07-04 15:12:29",
                "has_liked": true,
                "categories": [
                    {
                        "id": 2,
                        "name": "Category 2",
                        "created_at": "2019-08-17 23:04:28",
                        "updated_at": "2019-08-17 23:04:28"
                    },
                    {
                        "id": 5,
                        "name": "Category 5",
                        "created_at": "2019-08-17 23:04:28",
                        "updated_at": "2019-08-17 23:04:28"
                    }
                ]
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/posts`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    category_id |  optional  | Category ID.

<!-- END_2209ecf6aba23bb5213e50c5064981ff -->

<!-- START_dc4af656ff7577d936584f4332a92811 -->
## Post get record.

> Example request:

```bash
curl -X GET -G "/v1/posts/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/posts/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 1,
        "title": "AA bb eee",
        "description": "<p>dd<\/p>",
        "image": "http:\/\/api.icm.lk\/images\/post\/15622527715d1e15e3d045d.jpg",
        "likes": 0,
        "category_id": 1,
        "created_at": "2019-07-04 15:06:11",
        "updated_at": "2019-07-04 15:12:29",
        "has_liked": true,
        "categories": [
            {
                "id": 2,
                "name": "Category 2",
                "created_at": "2019-08-17 23:04:28",
                "updated_at": "2019-08-17 23:04:28"
            },
            {
                "id": 5,
                "name": "Category 5",
                "created_at": "2019-08-17 23:04:28",
                "updated_at": "2019-08-17 23:04:28"
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/posts/{id}`


<!-- END_dc4af656ff7577d936584f4332a92811 -->

<!-- START_b382955f2f4b169cc3f468b44b032333 -->
## Post hit like.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/posts/1/like" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/posts/1/like");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 1,
        "likes": 2
    }
}
```

### HTTP Request
`PUT /v1/posts/{id}/like`


<!-- END_b382955f2f4b169cc3f468b44b032333 -->

<!-- START_80629e71e9ce0b71edefafa95dbdbe99 -->
## Post hit dislike.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/posts/1/dislike" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/posts/1/dislike");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 1,
        "likes": 0
    }
}
```

### HTTP Request
`PUT /v1/posts/{id}/dislike`


<!-- END_80629e71e9ce0b71edefafa95dbdbe99 -->

<!-- START_f4cacb6cc3dd297ac3b5afc115328960 -->
## PostComment list.

> Example request:

```bash
curl -X GET -G "/v1/posts/1/post-comments" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/posts/1/post-comments");

    let params = {
            "pid": "iure",
            "page": "6",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 1,
            "current_page": 1,
            "per_page": 10,
            "total": 4
        },
        "list": [
            {
                "id": 6,
                "post_id": 1,
                "comment": "test",
                "created_at": "2019-07-05 11:54:18",
                "updated_at": "2019-07-05 11:54:18",
                "can_edit": true,
                "post_replies": [],
                "user_detail": {
                    "first_name": "Client",
                    "last_name": "",
                    "gender": "male",
                    "prof_pic": null
                }
            },
            {
                "id": 3,
                "post_id": 1,
                "comment": "test",
                "created_at": "2019-07-05 11:45:53",
                "updated_at": "2019-07-05 11:45:53",
                "can_edit": true,
                "post_replies": [
                    {
                        "id": 1,
                        "post_comment_id": 3,
                        "comment": "reply 1",
                        "created_at": "2019-07-05 13:41:51",
                        "updated_at": "2019-07-05 13:41:51",
                        "can_edit": true,
                        "user_detail": {
                            "first_name": "Client",
                            "last_name": "",
                            "gender": "male",
                            "prof_pic": null
                        }
                    },
                    {
                        "id": 3,
                        "post_comment_id": 3,
                        "comment": "reply 3",
                        "created_at": "2019-07-05 13:42:04",
                        "updated_at": "2019-07-05 13:42:04",
                        "can_edit": false,
                        "user_detail": {
                            "first_name": "Admin",
                            "last_name": "",
                            "gender": "male",
                            "prof_pic": null
                        }
                    }
                ],
                "user_detail": {
                    "first_name": "Client",
                    "last_name": "",
                    "gender": "male",
                    "prof_pic": null
                }
            },
            {
                "id": 2,
                "post_id": 1,
                "comment": "test",
                "created_at": "2019-07-05 11:45:52",
                "updated_at": "2019-07-05 11:45:52",
                "can_edit": false,
                "post_replies": [],
                "user_detail": {
                    "first_name": "Admin",
                    "last_name": "",
                    "gender": "male",
                    "prof_pic": null
                }
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/posts/{pid}/post-comments`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    pid |  required  | Post ID.
    page |  optional  | Page number.

<!-- END_f4cacb6cc3dd297ac3b5afc115328960 -->

<!-- START_b67c552fec92fc0cec84bf5d7c195fea -->
## PostComment add comment.

> Example request:

```bash
curl -X POST "/v1/posts/1/post-comments" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"comment":"est"}'

```
```javascript
const url = new URL("/v1/posts/1/post-comments");

    let params = {
            "pid": "et",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "comment": "est"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "post_id": 1,
        "comment": "test",
        "updated_at": "2019-07-05 11:46:24",
        "created_at": "2019-07-05 11:46:24",
        "id": 5
    }
}
```

### HTTP Request
`POST /v1/posts/{pid}/post-comments`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    comment | string |  required  | Comment.
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    pid |  required  | Post ID.

<!-- END_b67c552fec92fc0cec84bf5d7c195fea -->

<!-- START_1ddf9463d71a1caee316bb5f43206a43 -->
## PostComment update comment.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/posts/1/post-comments/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"comment":"iste","_method":"sit"}'

```
```javascript
const url = new URL("/v1/posts/1/post-comments/1");

    let params = {
            "pid": "nostrum",
            "id": "vel",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "comment": "iste",
    "_method": "sit"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "post_id": 1,
        "comment": "test",
        "updated_at": "2019-07-05 11:46:24",
        "created_at": "2019-07-05 11:46:24",
        "id": 5
    }
}
```

### HTTP Request
`PUT /v1/posts/{pid}/post-comments/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    comment | string |  required  | Comment.
    _method | string |  required  | _method=PUT.
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    pid |  required  | Post ID.
    id |  required  | Comment ID.

<!-- END_1ddf9463d71a1caee316bb5f43206a43 -->

<!-- START_b555f2579901402684d73ae7cf59da4a -->
## PostComment delete comment.

> Example request:

```bash
curl -X DELETE "/v1/posts/1/post-comments/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/posts/1/post-comments/1");

    let params = {
            "pid": "cumque",
            "id": "ut",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/posts/{pid}/post-comments/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    pid |  required  | Post ID.
    id |  required  | Comment ID.

<!-- END_b555f2579901402684d73ae7cf59da4a -->

<!-- START_fe2d9edc3185f2e991497956fe755650 -->
## PostCommentReply add reply comment.

> Example request:

```bash
curl -X POST "/v1/post-comments/1/reply" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"comment":"voluptatem"}'

```
```javascript
const url = new URL("/v1/post-comments/1/reply");

    let params = {
            "cid": "vitae",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "comment": "voluptatem"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "post_comment_id": 3,
        "comment": "reply 5",
        "updated_at": "2019-07-05 13:46:31",
        "created_at": "2019-07-05 13:46:31",
        "id": 4
    }
}
```

### HTTP Request
`POST /v1/post-comments/{cid}/reply`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    comment | string |  required  | Reply comment.
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    cid |  required  | Comment ID.

<!-- END_fe2d9edc3185f2e991497956fe755650 -->

<!-- START_d0544cdb042d3862686724950d5d3a08 -->
## PostCommentReply update reply.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/post-comments/1/reply/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"comment":"quo","_method":"adipisci"}'

```
```javascript
const url = new URL("/v1/post-comments/1/reply/1");

    let params = {
            "cid": "perferendis",
            "id": "vel",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "comment": "quo",
    "_method": "adipisci"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "id": 2,
        "post_comment_id": 3,
        "comment": "reply 3 edit",
        "created_at": "2019-07-05 13:41:56",
        "updated_at": "2019-07-05 13:43:03"
    }
}
```

### HTTP Request
`PUT /v1/post-comments/{cid}/reply/{id}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    comment | string |  required  | Reply comment.
    _method | string |  required  | _method=PUT.
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    cid |  required  | Post comment ID.
    id |  required  | Reply ID.

<!-- END_d0544cdb042d3862686724950d5d3a08 -->

<!-- START_1dbe98ff3ab0bfbbccae6fc0de5bba57 -->
## PostCommentReply delete reply.

> Example request:

```bash
curl -X DELETE "/v1/post-comments/1/reply/1" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/post-comments/1/reply/1");

    let params = {
            "cid": "est",
            "id": "vitae",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": null
}
```

### HTTP Request
`DELETE /v1/post-comments/{cid}/reply/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    cid |  required  | Post comment ID.
    id |  required  | Reply ID.

<!-- END_1dbe98ff3ab0bfbbccae6fc0de5bba57 -->

<!-- START_ea085ad0b163cdb581766cef27656644 -->
## Notification list.

> Example request:

```bash
curl -X GET -G "/v1/notifications" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/notifications");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": {
        "paginator": {
            "pages": 2,
            "current_page": 1,
            "per_page": 20,
            "total": 28
        },
        "list": [
            {
                "id": 38,
                "type": "create_new_post",
                "type_id": 34,
                "parameters": {
                    "post_id": 34
                },
                "title": "Job post",
                "body": "We found your perfect match at company Apply Now!",
                "unread": 1,
                "created_at": "2019-09-05 20:26:54",
                "updated_at": "2019-09-05 20:26:54"
            },
            {
                "id": 37,
                "type": "create_new_post",
                "type_id": 33,
                "parameters": {
                    "post_id": 33
                },
                "title": "Job post",
                "body": "We found your perfect match at company Apply Now!",
                "unread": 1,
                "created_at": "2019-09-05 20:26:46",
                "updated_at": "2019-09-05 20:26:46"
            }
        ]
    }
}
```

### HTTP Request
`GET /v1/notifications`


<!-- END_ea085ad0b163cdb581766cef27656644 -->

<!-- START_6609b27a8534c63247769f32ad889ef1 -->
## Notification unread count.

> Example request:

```bash
curl -X GET -G "/v1/notifications/unread-count" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/notifications/unread-count");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": 4
}
```

### HTTP Request
`GET /v1/notifications/unread-count`


<!-- END_6609b27a8534c63247769f32ad889ef1 -->

<!-- START_7f2d22acc8cf40df35fbbfff9c027fcb -->
## Notification read.

Even this is a **PUT** request you have to send this as a **POST** request
because of `lumen` doesn't support form data via **PUT** request

So we have to pass additional field with **POST** request.

`_method=PUT` and rest of the following fields

> Example request:

```bash
curl -X PUT "/v1/notifications/read" \
    -H "Authorization: Bearer {token}"
```
```javascript
const url = new URL("/v1/notifications/read");

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "message": "Successful",
    "data": 4
}
```

### HTTP Request
`PUT /v1/notifications/read`


<!-- END_7f2d22acc8cf40df35fbbfff9c027fcb -->



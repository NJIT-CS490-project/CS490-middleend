#CS490-middleend

__Base URL__
`http://osl84.njit.edu/~ejp9/CS490-middleend/`

## API

### Search

#### `GET search.php`

##### Sorting

| param   | type                            | description                 | required | default |
|---------|---------------------------------|-----------------------------|----------|---------|
| count   | Number                          | Number of events to return  | false    | 10      |
| offset  | Number                          | Number to offset results by | false    | 0       |
| order   | (asc, desc)                     | Order to return events in   | false    | asc     |
| sorting | (title, create, due, favorites) | Property to sort events by  | false    | title   |


##### Filtering

| param     | type     | description                                                |
|-----------|----------|------------------------------------------------------------|
| search    | String   | Title or description must contain this string              |
| startDate | Date     | Earliest date an event may be scheduled to happen          |
| endDate   | Date     | Latest date an event may be schedule to happen             |
| startTime | Time     | Earliest time an event may be running                      |
| endTime   | Time     | Latest time an event may be running                        |
| building  | Building | Building an event must occur in                            |
| room      | String   | Room must contain this as a substring                      |
| favorited | Boolean  | If true, only include events favorited by this user        |
| mine      | Boolean  | If true, only include events created by the searching user |
| onlyNJIT  | Boolean  | If true, only include events from NJIT system              |
| onlyUser  | Boolean  | If true, only include events created by users              |

##### Returns

```
{
  "events": [...], // Event objects, may be empty
  "done": // If true, no more events are available after this specific set of query parameters for a higher offset
}
```


### Login

#### `POST login.php`

```json
{
  "username": "alice",
  "password": "password"
}
```

### Register

#### `POST register.php`

```json
{
  "username": "alice",
  "password": "password"
}
```

### Create

#### `POST create.php`

```json
{
  "title": "Event Title",
  "description": "This is a description of the event",
  "date": "1970-01-01",
  "startTime": "7:45",
  "endTime": "17:45",
  "location": "123 Banana St."
}
```

### Delete

#### `DELETE delete.php`

| param | type   | description               | required | default |
|-------|--------|---------------------------|----------|---------|
| id    | Number | ID of the event to delete | true     |         |

### Logout

#### `PUT logout.php`

| param | type   | description               | required | default |
|-------|--------|---------------------------|----------|---------|

### self

#### `GET self.php`

| param  | type   | description                 | required | default |
|--------|--------|-----------------------------|----------|---------|

### Locations

#### `GET locations.php`

| param  | type   | description                 | required | default |
|--------|--------|-----------------------------|----------|---------|

### Modify Events 

#### `POST modify.php`

```json
{
  "description": "This is a description of the event",
  "startTime": "7:45",
  "endTime": "17:45",
  "location": "123 Banana St."
}
```

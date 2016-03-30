#CS490-middleend

__Base URL__
`http://osl84.njit.edu/~ejp9/CS490-middleend/`

## API

### Search

#### `GET search.php`

| param  | type   | description                 | required | default |
|--------|--------|-----------------------------|----------|---------|
| string | String | String to search for        | true     |         |
| count  | Number | Number of events to return  | false    | 10      |
| offset | Number | Number to offset results by | false    | 0       |

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

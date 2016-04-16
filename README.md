# Simple Highscore Server

## Setup

### Clone repository
```
cd /var/www  # whereever you want
git clone https://github.com/jannisfink/highscore.git

cd highscore
```

### Create configuration file
Copy the sample configuration file.

```
cp highscore.sample.ini highscore.ini
```

Open it and adjust it's values for your needs.

### Redirect every request to the index.php
You can find the `index.php` in the base directory. Every incoming request has to be handled by this file.
The `.htaccess` should do this job already for apache, `web.config` for IIS. The `nginx.sample` contains a
minimum configuration sample for the nginx webserver.

## Usage

###  API
Access the top 10 scores via `example.com/highscores`. To create a new highscore, just make an HTTP PUT-Request
to `example.com/highscore`. The request body must contain a JSON-object with three parameters:

```javascript
{
  'name': 'player name',
  'score': 'player score',
  'token' : 'token from config file'
}
```

The answer is a JSON-object, too, containing at least a key `success` indicating the successful creation of the new
highscore object. If the creation was successfull, the answer will include the newly created highscore object accessable
via the `score` key:

```javascript
{
  'score': {
    'name': 'player name',
    'score': 102,
    'datePlayed': {
      'date": '2016-04-16 09:52:43.000000',
      'timezone_type': 3,
      'timezone': 'Europe/Berlin'
    }
  },
  'success': true
}
```

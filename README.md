# Levart BE Test

services for assessment test in Levart

# ERD & Flowchart
https://drive.google.com/file/d/1uUjCwKRNhKfkCU9s4ebSVUYrtul8ZvaQ/view?usp=sharing

## Run Locally

1. Clone the project or extract from zip

```bash
  git clone https://github.com/widz11/fb92a729f395330a91ff22eb5c967d40.git levart-be-test
```

2. Go to the project directory

```bash
  cd levart-be-test
```

3. Setup env for database, etc

```bash
  cp env-example .env
```

4. Install dependencies

```bash
  composer install
```

5. Run migration

```bash
    composer run migration:run
```

6. Start the server

```bash
  composer run server:start
```

7. Go to api

```bash
  curl http://localhost:8000
```

8. Run cron

```bash
  php cron/cron.php
```
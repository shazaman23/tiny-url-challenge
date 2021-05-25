# Setup Your Development Environment

1. Install Docker if not already installed. [Download Docker](https://docs.docker.com/engine/install/)

2. Install Docker Compose if not already installed [Download Docker Compose](https://docs.docker.com/compose/install/)

    - **IMPORTANT**
        - If you are using Docker Desktop on Windows or Mac, you get both Docker and Docker Compose at once.
        - If using Docker Desktop on Windows, you will need to enable file sharing to integrate with your development environment. Go to Docker Desktop Settings > Resources > FILE SHARING and add the folder where the tiny-url-challenge project exists to file sharing.

3. Clone the project code to your computer from [GitHub](https://github.com/shazaman23/tiny-url-challenge) if you have access. Otherwise, unzip the project code you were given and navigate into the project root.

4. Deploy docker containers (*~10mins*)

    ```
    docker-compose up -d
    ```

    (This command can take a while the first time it runs)

5. Follow the logs to see when the container finishes starting up 
    ```
    docker-compose logs -f app
    ```

    (The startup process can take a while the first time it runs)

---

# Using Your Testing Environment

To interact with the local website that is running visit http://localhost:8000
- Make sure your docker cluster is running by running `docker-compose ps`. If the containers aren't running you won't be able to get to the local site. If they're down, just bring them back up with `docker-compose up -d`
- **Warning:** Every time you redeploy the app locally the database will be reset. Data will not persist. To change this behavior, edit the docker-entrypoint and comment out the `php artisan migrate:fresh` command.

---

# Challenges I Faced
- I ran into a couple interesting hiccups with the build process and docker-compose. For example:
    - I had to change the php libraries that are installed since this runs off of PHP 8.0
    - For some reason, `php artisan key:generate` command was not actually editing the .env file when docker-entrypoint.sh ran. It would edit the .env fine if I shelled into the container and ran it manually, but not during the entrypoint. I tried a couple different approaches and then gave up and just used sed to edit the file manually. It probably had something to do with differing permissions or context of the build process.
- My original model design didn't type cast the ID and so the `id` field in each model was returning 0 since it expected an auto-generating int instead of a string.
- Creating a seed field that was auto-incrementing caused conflicts with the existing primary key of `id` until I rewrote the migration to add the seed field after the fact.
- Struggled a bit getting the validation errors to render properly (I was passing the withErrors helper JSON instead of an array).

---

# Design Decisions
- I went with a custom Dockerfile and docker-compose because I have built other Laravel apps in this way before and (considering the docker-compose approach was a bonus) I wanted to use an approach I'd be familiar with.
- I'm going to generate a unique ID for each full URL. In order to avoid ID collisions, I'm going to append a unique number to the front of each URL before hashing. This will be a unique ID tracked in the database.
- For form validation I decided to go for the built-in `url` validation rule instead of `active_url`. I chose to do this because I found examples of other people running into problems with false positives when using `active_url`. (Instead of properly validating that the url provided resolves to a website properly, it tries to validate particular DNS records are returned when digging on the domain).
- I added the routes for creating new urls and listing existing urls to the api route page since those deal with TinyUrl CRUD operations. The route that handles existing tiny URL redirection was put in the web routes since it will be interacted with directly by a user.
- I decdied not to go too in depth with styles. This challenge felt more functionality focused instead of style focused, so I'm focusing my design on utility over appearance.
- I decided to add bootstrap cause it makes it easy to throw a clean form up and has helper classes for things like form validation error display. (It will also probably come in handy with NSFW modal stuff later.)

---

# Future Improvements

- I would try to optimize the startup process further so that there's not such a large gap between when the build finishes and when the service is usable (if possible).
- I'm aware that Laravel has now come out with tools to auto-generate a docker-compose file. With more time, I'd do more digging into official Laravel build processes and see if it's just easier to use their process or if there are things about their process that I could use to improve my own.
- I would implement a login process and implement some rate limiting based off of user id per day to prevent irresponsible use of the service and overload on resources.
- Something I would do with a little more time would be to create a custom validation rule for the url provided that tests that the url will resolve to a website with a proper success code (like 2xx) instead of just testing that the provided value looks like a URL.
- I would consider implementing API Token Authentication for create and delete calls against the TinyUrl API.
- I might add routes for deleting or updating an existing tiny URL. 
- I would make the views more mobile friendly.
- After adding user login, I would add a view where a user could quickly view all the tiny URLs they have created so far.
- I would add to the new URL success view the Tiny URL and the destination it is set to hit (something like on the top 100 page where it shows `tiny_url` --> `full_url`)
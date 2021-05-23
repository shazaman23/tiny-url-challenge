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

---

# Challenges I Faced
- I ran into a couple interesting hiccups with the build process and docker-compose. For example:
    - I had to change the php libraries that are installed since this runs off of PHP 8.0
    - For some reason, `php artisan key:generate` command was not actually editing the .env file when docker-entrypoint.sh ran. It would edit the .env fine if I shelled into the container and ran it manually, but not during the entrypoint. I tried a couple different approaches and then gave up and just used sed to edit the file manually. It probably had something to do with differing permissions or context of the build process.

---

# Design Decisions
- I went with a custom Dockerfile and docker-compose because I have built other Laravel apps in this way before and (considering the docker-compose approach was a bonus) I wanted to use an approach I'd be familiar with.
- I'm going to generate a unique ID for each full URL. In order to avoid ID collisions, I'm going to append a unique number to the front of each URL before hashing. This will be a unique ID tracked in the database.

---

# Future Improvements

- I'm aware that Laravel has now come out with tools to auto-generate a docker-compose file. With more time, I'd do more digging into official Laravel build processes and see if it's just easier to use their process or if there are things about their process that I could use to improve my own.
- I would implement a login process and implement some rate limiting based off of user id per day to prevent irresponsible use of the service and overload on resources.
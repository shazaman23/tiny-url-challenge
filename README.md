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
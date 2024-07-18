Admin credentials:
username: admin
password: rakee

Important Notes:
When the project is first run, index.php is the first file that should be executed, as it is the initializer of the project, and whenever a user goes to index.php, some parts of the project will revert back to its initial state.

Our page implements our so called "page guards" that redirects the user to the previous page, once he tries to access a page he does not have access to via URL.
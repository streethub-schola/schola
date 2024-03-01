# schola

Schola is a school management portal built to reform the Educational Management space

## Contributions

First make sure to clone the repo to your local machine.
For guide on how to setup your environment for development, please read this [guide](https://opensource.guide/how-to-contribute/). You have to fork this repo.

## Setup steps
- Install Git [here](https://git-scm.com/) if you do not already have it
- Create a Folder on your machine
- Navigate into the folder
- Right click on the folder you created and select 
```bash
Git Bash Here
```
The above will open the Git terminal window

- Run the command 
```bash
git clone https://github.com/streethub-schola/schola.git
```
and hit the enter key

- Then navigate to the branch you will be contributing to using this command

  ```bash
  git branch branch_name
  ```
- After the creation of your branch, to switch to your new branch, then you can do:

  ```bash
  git checkout branch_name
  ```
We currently have 3 branches, (main, portal_frontend and kachi_frontend).

- All our completed and vetted jobs will be residing in the portal_frontend branch, so before you start working, do the following to see what others have done so you do not repeat what someone else is working on:

  ```bash
  git pull origin portal_frontend
  ```

- Once you commence working on any task, please ensure to move it to 'in progress' on the project page
- After making all your changes, add and commit your changes by running:

```bash
git add -A

git commit -m 'your commit message comes here'

git push origin <name your branch>
```

- Then go back to github and create a pull request to the branch 'portal_frontend'

- To ensure that we all learn through this experience, please always reach out to the maintainers when you have issuues.
  

### Backend API documentation

CLASSES
1) Get a Class
url: https://schola-2.myf2.net/api/classapi/getclass.php

method: GET

frontend input: class_id (string / mandatory)

api rersponse:
json data of class if found or not

2) Get All Classes
url: https://schola-2.myf2.net/api/classapi/getclasses.php

method: GET

frontend input: nil

api rersponse:
json data of class if found or not

3) Create a Class
#url: https://schola-2.myf2.net/api/classapi/createclass.php

method: POST

frontend input:
- class_name: e.g JSS or SSS or Primary etc (string / mandatory)

api rersponse:
json data of class if found or not

4) Update a Class
#url: https://schola-2.myf2.net/api/classapi/updateclass.php

method: PATCH or PUT

frontend input:
- class_id: (number or number string / mandatory)
- class_name: e.g JSS or SSS or Primary etc (string / optional)

api rersponse:
json data of class if found or not

5) Delete a Class
#url: https://schola-2.myf2.net/api/classapi/deleteclass.php

method: DELETE

frontend input:
- class_id: (number or number string / mandatory)

api rersponse:
json data of TRUE OR FALSE

6) Search for a Class
URL: https://schola-2.myf2.net/api/classapi/searchclass.php
method: GET

frontend input
a. searchstring (string / mandatory) : the item you are searching for
b. searchcolumn (string / mandatory): the column on the classes table you ant to search in

api rersponse:
json data of class if found or not

### Class api ends here
------------------------------------------------------


### ASSIGNMENT api begins here
------------------------------------------------------

1) Get a assignment
url: https://schola-2.myf2.net/api/assignmentapi/getassignment.php

method: GET

frontend input: assignment_id (string / mandatory)

api rersponse:
json data of assignment if found or not

2) Get All assignmentes
url: https://schola-2.myf2.net/api/assignmentapi/getassignmentes.php

method: GET

frontend input: nil

api rersponse:
json data of assignment if found or not

3) Create a assignment
#url: https://schola-2.myf2.net/api/assignmentapi/createassignment.php

method: POST

frontend input:
- class_id : (integer / mandatory)
- subject_id : (integer / mandatory)
- term_id : (integer / mandatory)
- session_id : (integer / mandatory)
- staff_id : (integer / mandatory)
- assignment: the assignment (string / mandatory)

api rersponse:
json data of assignment if found or not

4) Update a assignment
#url: https://schola-2.myf2.net/api/assignmentapi/updateassignment.php

method: PATCH or PUT

frontend input:
- assignment_id: (number or number string / mandatory)
- class_id : (integer / mandatory)
- subject_id : (integer / mandatory)
- term_id : (integer / mandatory)
- session_id : (integer / mandatory)
- staff_id : (integer / mandatory)

api rersponse:
json data of assignment if found or not

5) Delete a assignment
#url: https://schola-2.myf2.net/api/assignmentapi/deleteassignment.php

method: DELETE

frontend input:
- assignment_id: (number or number string / mandatory)

api rersponse:
json data of TRUE OR FALSE

6) Search for a assignment
URL: https://schola-2.myf2.net/api/assignmentapi/searchassignment.php
method: GET

frontend input
a. searchstring (string / mandatory) : the item you are searching for
b. searchcolumn (string / mandatory): the column on the assignmentes table you ant to search in

api rersponse:
json data of assignment if found or not

### assignment api ends here
------------------------------------------------------


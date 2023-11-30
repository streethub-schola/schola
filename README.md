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
  


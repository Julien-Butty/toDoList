## Before getting started

> ToDoList is a collaborative app. Your contributions are welcome !

# How to contribute

> If you'd like to contribute, a good place to start is by searching through the [issues][issues] and [pull requests][pull-requests] to see if someone else had a similar idea or question.

If you don't see your idea listed, and you think it fits into the goals of the project, you should:

* **Minor Contribution _(e.g., typo fix)_:** Open a pull request
* **Major Contribution _(e.g., new feature)_:** Start by opening an issue first. That way, other people can weigh in on the discussion and planning before you do any work.

To start making a contribution:

1. `fork` the project repository by clicking the **fork** button on GitHub.![fork](https://help.github.com/assets/images/help/repository/fork_button.jpg) 

1. `clone` your forked repository (_noob tip: the actual command you type in is everything after the $_):

   ```shell
   $ git clone https://github.com/<YOUR-USERNAME>/toDoList
   ```

1. Add a new remote that points to the original project so you can sync project changes with your local copy:

   ```shell
   $ git remote add upstream https://github.com/Julien-Butty/toDoList
   ```

1. Pull upstream changes into your local repositories `dev` branch:

   ```shell
   $ git checkout dev
   $ git pull upstream dev && git push origin dev
   ```

1. Create a new branch from the `dev` branch:
![branch](https://help.github.com/assets/images/help/branch/branch-selection-dropdown.png)

   **IMPORTANT:** Make sure you are on the `dev` branch first.

   ```shell
   $ git checkout -b <YOUR-NEW-BRANCH>
   ```

1. Make your contribution to the project code.

1. Write or adapt tests as needed.

1. Add or change documentation as needed.

1. After commiting changes, push your branch to your fork on Github, the remote `origin`:

   **IMPORTANT:** Your commit message should be in present tense and should describe what the commit, when applied, does to the code - not what you did to the code.

   ```shell
   $ git push -u origin <YOUR-NEW-BRANCH>
   ```

1. From your forked GitHub repository, open a pull request in the branch containing your contributions. Target the project's `dev` branch for the pull request.

1. At this point, your contribution has been submitted for review. Please be patient while your contribution is being reviewed as this can take some time. Meanwhile, if there are questions or comments on your contribution, please respond and/or update with future commits.

1. Once the pull request is approved and merged, you can pull the changes from `upstream` to your local repository and delete your extra branch(es).

1. Don't forget to read the Coding conventions below.

Happy contributing!

[issues]: https://github.com/Julien-Butty/toDoList/issues
[pull-requests]: https://github.com/Julien-Butty/toDoList/pulls


## Coding conventions

> Code should be optimized for readability. 

In order to sanitize coding standards, please follow these code styles :
* [Symfony Coding Standard](https://github.com/airbnb/javascript).
* [Clean Code Standard](https://github.com/jupeter/clean-code-php).
* [PSR](https://www.php-fig.org/psr/).
* [Symfony Best Practice](https://symfony.com/doc/3.4/best_practices/index.html)


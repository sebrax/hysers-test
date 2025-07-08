# To run UI
The UI was done using Inertia with Vue.js so you need to run the `php artisan serve` and also `npm run dev`

The last step on test that you return a Laravel default `view` so it needs to change to use Inertia's Testing methods. The workaround was to check if there was a running test and serve a default view for tests and the Inertia one as default.

----------------------

Objective:

Back-end Assessment: [ ] Make all tests pass, applying the best practices of Laravel and SOLID and clean arch

Front-end Assessment: [ ] Implement a front-end using Inertia.js, Vue3 and TailwindCss for contact CRUD

* Plus: Feel free to implement improvements and more features as you wish, such as sending an email to the contact when that contact is deleted from the system.

# Installation
1. Clone the repository
2. Have PHP 8.3 installed on your machine, composer 2, and activate the extensions requested by composer when running "composer install"
3. Run "Composer install"
4. Create a .env file and paste the contents of .env.example
5. Run the command php artisan key:generate
6. Run the command php artisan test, solve the tests

7. After the test is complete, create a repository on github, and upload your resolution to the repository
8. Send the repository link to WhatsApp +55 41 98702-5814

# Installation

Orchestra Platform is best installed in a clean Laravel environment, due to the facts it require to create `users` table and administrator account during installation.

<a name="download"></a>
## Installation with Laravel Artisan

	php artisan bundle:install orchestra

### Bundle Registration

	'orchestra' => array('auto' => true, 'handles' => 'orchestra'),

### Publish Bundle Asset

	php artisan bundle:publish

You can change handles value to anything unique, such as `admin` for example.

<a name="setup"></a>
# Setup

Now navigate to your [Orchestra](/admin) in a web browser, you should see an installation page. Do remember to change the URL if you use a different handles value.

Please ensure that your configuration is correct, Orchestra will utilize configuration from `application/config` folder to make the process streamless with your other application (or bundles).

- Create a `User` model, which extends `Orchestra\Model\User` model.
- Update `application/config/database.php` and ensure your database connection is properly set up.
- Update `application/config/auth.php`.
	- Orchestra only support Eloquent auth driver at the moment.
	- Select your `User` model, or change it to `Orchestra\Model\User`.

Complete the installation wizard, a simple 3 step installation process.
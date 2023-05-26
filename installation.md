## Installation

Clone this repository and install all dependency first

```sh
composer install
yarn
```

Setup .env by copying .env.example file. Generate the laravel key after that.

```sh
php artisan key:generate

```

Here's the thing. In the .env, you should pay attention to some of the things below

-   APP_ENV = You must set this to production so the attendance system will use a server time. But you can set this to local or development so the attendance system will use an inputted time from the request
-   FILE_UPLOAD_ENDPOINT= You must define the base endpoint where you upload the file here
-   DASHBOARD_TIMEZONE= Here you can define the timezone of the dashboard. The default timezone is UTC, but you can change based on your needs
-   BPJSK_EMPLOYEE_PRECENTAGE= This is payroll related. You can ignore this, but you can set how much percentage of employees taken from the bpjsk deduction
-   FIREBASE_CREDENTIALS= Copy .json of your firebase credential. This will handle the firebase cloud messaging to the employee apps later when your apps are ready

After you setup the database, run the migration and seeder

```sh
php artisan migrate
php artisan db:seed
```

Run the server and it was ready to use

```sh
php artisan serve
yarn dev
```

## How To Deploy

After you successfully install it locally, maybe you want to deploy it too. things you should pay attention to when deploying are these.

1. If you use VPS you can repeat the installation step and don't forget to run this command.
    ```sh
    yarn build
    ```
2. If you use CPanel or something similar to that, you can run this command before uploading the apps into your CPanel.
   `sh
    yarn build
    `
   The last important thing. You must set up the cronjob/schedular to your VPS/CPanel. You can set the cronjob command like this.

```sh
* * * * * cd /var/www/battlehr && php artisan schedule:run >> /dev/null 2>&1
```

The Note is you must set the cronjob every minute to run the schedule:run artisan command. This will execute some features such as:

1. Force clock-out attendance
   This feature will automatically clock out the employee based on the setting that already you made in Settings > Attendance > Attendance > Time for force clock out section.
2. Reminder clockin
   This feature will send a notification to your mobile apps inside the interval you were config in Settings > Attendance > Attendance > Time for notification section. You can uncomment the code in App/Console/Kernel to use this feature if you already have your mobile apps.
3. Reset the Leave Quota
   This feature will reset your leave quota based on the settings in Settings > Leave > General.

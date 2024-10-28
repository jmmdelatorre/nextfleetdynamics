# PHP Boilerplate Project

This is a boilerplate structure for a PHP web application.

## Project Structure

project-root/
├── config/
│   └── config.php             # Database and app configurations
├── controllers/
│   └── HomeController.php      # Example controller
├── models/
│   └── User.php               # Example model
├── views/
│   └── home.php               # Example view file
├── public/
│   ├── index.php              # Main entry point
│   ├── css/
│   │   └── style.css          # Stylesheet folder
│   ├── js/
│   │   └── script.js          # JavaScript folder
│   └── assets/                # Assets (images, etc.)
├── helpers/
│   └── functions.php          # Helper functions
└── storage/
    └── logs/                  # Log files


### Description of Folders

- **config/**: Configuration files, such as `config.php` for database and application settings.
- **controllers/**: Application logic and controller files like `HomeController.php`.
- **models/**: Contains model classes, e.g., `User.php`.
- **views/**: Templates and view files, like `home.php`.
- **public/**: Web root for the application, including `index.php` as the entry point, along with assets.
- **helpers/**: Custom helper functions, e.g., `functions.php`.
- **storage/**: Directory for application logs and storage.

## Getting Started

1. Clone this repository.
2. Configure your environment in `config/config.php`.
3. Open `public/index.php` to start building the app.

## Requirements

- PHP 7.4 or higher
- Web server (Apache, Nginx)
- Database (MySQL or any supported by PHP)

## License

This project is open source and free to use.

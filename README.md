# pws

## Overview

This project is a file management web service built with PHP and Laravel. It provides APIs for uploading, storing, and managing files.

## Requirements

- PHP 7.4 or higher
- Composer
- Laravel 8.x
- MySQL
- Docker

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/mehedi8gb/file-ws.git
    cd file-ws
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Copy the `.env.example` file to `.env` and configure your environment variables:
    ```bash
    cp .env.example .env
    ```

4. Generate an application key:
    ```bash
    php artisan key:generate
    ```

5. Run the database migrations:
    ```bash
    php artisan migrate
    ```

## Usage

### Running the Application

To start the application, use the following command:
```bash
php artisan serve
```
The application will be available at `http://localhost:8000`.

### Running the Application with Docker

#### Prerequisites
- Docker
- Docker compose

#### Clone
```bash
git clone https://github.com/mehedi8gb/pws.git
```

#### Open directory
```bash
cd pws
```

#### Build
```bash
./bin/deploy_dev.sh
```

#### Access the dev site
```bash
http://localhost:8000
```

### API Documentation

The API documentation is generated using the Scribe package. To generate the documentation, run:
```bash
php artisan scribe:generate
```
You can view the documentation at `http://file-ws.test/docs`.

### Testing

To run the tests, use the following command:
```bash
php artisan test
```

## Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -m 'Add some feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Open a pull request.

## License

This project is licensed under the MIT License.
